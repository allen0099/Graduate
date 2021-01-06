<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->showOrders();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => [
                'required',
                'exists:users,username',
                function ($attribute, $value, $fail) {
                    $user = \request()->user();
                    if ($user->role !== User::ADMIN && $user->username !== $value) {
                        $fail($attribute . ' not match.');
                    }
                },
            ],
            'items' => 'required',
            'items.*.id' => 'required|distinct|exists:items,id',
            'items.*.quantity' => [
                'required',
                'gt:0',
                'numeric',
                function ($attribute, $request_value, $fail) {
                    $loc = Str::between($attribute, '.', '.');
                    $id = request()->items[$loc]['id'];

                    $target = Item::find($id);
                    if ($target->remain_quantity < $request_value) {
                        $fail($attribute . ' is too much.');
                    }
                },
            ],
        ]);

        $order = new Order();

        $order->document_id = Str::uuid(); // todo: replace with document id generate method
        $order->owner_id = User::where('username', $request->username)->first()->id;
        $order->status_code = Order::code_0;

        $order->save();

        $this->createItems($order, $request->items);

        $this->saveLog($order, "{$request->username} 建立新的訂單。");
        $order->fresh();

        return redirect()->back()->with('success', $order->fresh());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return $order;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $user = Auth::user();
        if ($user->role === User::STUDENT) {
            // role student, only cancel
            $this->checkBelongToStudent($order);

            $request->validate([
                'document_id' => [
                    'required',
                    Rule::unique('orders', 'document_id')
                        ->ignore($order->document_id, 'document_id'),
                    'exists:orders,document_id', // student update check
                ],
                'owner_username' => [
                    'required',
                    'exists:users,username',
                    Rule::unique('users', 'username')
                        ->ignore($user->id, 'id'), // student update check
                ],
                'status_code' => [
                    'required',
                    Rule::in([
                        Order::code_requestCancel
                    ]),
                    function ($attribute, $value, $fail) {
                        $order = Order::where('document_id', \request()->document_id)->first();
                        if ($order->status_code === Order::code_canceled)
                            $fail($order->document_id . ' has been cancelled, contact admin for more help.');
                        if ($order->status_code === Order::code_requestCancel)
                            $fail($order->document_id . ' has been cancelled successfully.');
                    },
                ],
                'items' => 'required',
                'items.*.id' => 'required|distinct|exists:items,id',
                'items.*.quantity' => [
                    'required',
                    'gt:0',
                    'numeric',
                    function ($attribute, $request_value, $fail) {
                        $loc = Str::between($attribute, '.', '.');
                        $id = request()->items[$loc]['id'];

                        $target = Item::find($id);
                        if ($target->remain_quantity < $request_value) {
                            $fail($attribute . ' is too much.');
                        }
                    },
                ],
            ]);
        }
        if ($user->role === User::ADMIN) {
            // role admin, edit order
            $request->validate([
                'document_id' => [
                    'required',
                    Rule::unique('orders', 'document_id')
                        ->ignore($order->document_id, 'document_id'),
                ],
                'owner_username' => [
                    'required',
                    'exists:users,username',
                ],
                'status_code' => [
                    'required',
                    Rule::in([
                        Order::code_created,
                        Order::code_paid,
                        Order::code_received,
                        Order::code_returned,
                        Order::code_requestCancel,
                        Order::code_canceled,
                    ]),
                ],
                'items' => 'required',
                'items.*.id' => 'required|distinct|exists:items,id',
                'items.*.quantity' => [
                    'required',
                    'gt:0',
                    'numeric',
                    function ($attribute, $request_value, $fail) {
                        $loc = Str::between($attribute, '.', '.');
                        $id = request()->items[$loc]['id'];

                        $target = Item::find($id);
                        if ($target->remain_quantity < $request_value) {
                            $fail($attribute . ' is too much.');
                        }
                    },
                ],
            ]);
        }

        $order->document_id = $request->document_id;
        $order->owner_id = User::where('username', $request->owner_username)->first()->id;
        $order->status_code = $request->status_code;

        $order->save();

        $old_items = $order->items()->get()->makeVisible(['pivot']);
        $old_items->each(function ($item, $key) {
            $item->pivot->delete();
        });

        $this->createItems($order, $request->items);

        if ($user->role === User::ADMIN) {
            $this->saveLog($order, "{$user->username} 更新了訂單狀態。");
        } else {
            $this->saveLog($order, "{$user->username} 要求取消訂單。");
        }

        return $order->fresh();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        $order->delete();

        return response()->noContent();
    }

    public static function showOrders()
    {
        if (Auth::check()) {
            if (Auth::user()->role === User::ADMIN) {
                return Order::all();
            }
            return [
                'own' => User::find(Auth::id())->owned_orders,
                'shared' => User::find(Auth::id())->shared_orders,
            ];
        }
        return [];
    }

    private function createItems($order, $items)
    {
        foreach ($items as $item) {
            $id = $item['id'];
            $quantity = $item['quantity'];

            $order_item = new OrderItem();
            $order_item->item_id = $id;
            $order_item->order_id = $order->id;
            $order_item->quantity = $quantity;
            $order_item->save();
        }
    }

    private function checkBelongToStudent($order)
    {
        if ($order->owner->id !== Auth::id())
            abort(403);
    }

    private function saveLog($order, $message)
    {
        $log = new OrderLog();
        $log->order_id = $order->id;
        $log->status_code = $order->status_code;
        $log->description = $message;
        $log->log_time = now();

        $log->save();
    }
}
