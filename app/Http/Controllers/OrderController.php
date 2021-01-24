<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Item;
use App\Models\Order;
use App\Models\Set;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


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
                function ($attribute, $value, $fail) use ($request) {
                    $user = $request->user();
                    if ($user->role !== User::ADMIN && $user->username !== $value) {
                        $fail($attribute . ' not match.');
                    }
                },
            ],
            'sets' => 'required',
            'sets.*.set_owner' => [
                'required',
                'distinct',
                'exists:users,username',
                function ($attribute, $value, $fail) use ($request) {
                    $user = User::where('username', $value)->first();
                    $stu_ids = Set::getHaveSetIds();

                    if (in_array($user->id, $stu_ids)) {
                        $fail(__('validation.student_had_set'));
                    }
                },
            ],
            'sets.*.accessory' => [
                'exists:items,id',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];

                    $username = $request->sets[$index]['set_owner'];

                    $user = User::where('username', $username)->first();
                    $department = $user->school_class->department;

                    $accessory = Item::find($value)->first();

                    if (!is_null($department->default_color) && $accessory->spec !== $department->default_color) {
                        $fail(__('validation.color_not_match'));
                    }

                    if (!in_array($value, Item::accessoryIds())) {
                        $fail(__('validation.item_set_wrong'));
                    }
                },
            ],
            'sets.*.cloth' => [
                'exists:items,id',
                function ($attribute, $value, $fail) use ($request) {
                    if (!in_array($value, Item::clothIds())) {
                        $fail(__('validation.item_set_wrong'));
                    }
                },
            ],
        ]);

        $order = new Order();

        $order->document_id = Order::createDocumentId();
        $order->owner_id = User::where('username', $request->username)->first()->id;

        $order->status_code = Order::code_created;
        $order->total_price = $this->calculateTotalPrice($request->sets);

        $order->save();

        $this->saveSets($order, $request->sets);

        // return Inertia::render('Student/Order/Show', ['re_order'=> $order, 'finish'=> true]);
        return redirect()->back()->with('success', $order->fresh());
        // return $order->fresh();
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

        if (is_null($order))
            abort(404);

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
                    function ($attribute, $value, $fail) use ($request) {
                        // todo: change fail, or not changed code
                        $order = Order::where('document_id', $request->document_id)->first();
                        if (!is_null($order) && $order->status_code === Order::code_canceled)
                            $fail($order->document_id . ' has been cancelled, contact admin for more help.');
                        if (!is_null($order) && $order->status_code === Order::code_requestCancel)
                            $fail($order->document_id . ' has been cancelled successfully.');
                    },
                ],
                'sets.*.set_owner' => [
                    'distinct',
                    'exists:users,username',
                    function ($attribute, $value, $fail) use ($request) {
                        $user = User::where('username', $value)->first();
                        $stu_ids = Set::getHaveSetIds();

                        $order = Order::where('document_id', $request->document_id)->first();
                        if (!is_null($order)) {
                            $sets = $order->sets;
                            $set_ids = $sets->map->only('student_id')->flatten()->all();

                            $other_ids = array_diff($stu_ids, $set_ids);

                            if (in_array($user->id, $other_ids)) {
                                $fail(__('validation.student_had_set'));
                            }
                        }
                    },
                ],
                'sets.*.accessory' => [
                    'exists:items,id',
                    function ($attribute, $value, $fail) use ($request) {
                        $index = explode('.', $attribute)[1];

                        $username = $request->sets[$index]['set_owner'];

                        $user = User::where('username', $username)->first();
                        $department = $user->school_class->department;

                        $accessory = Item::find($value)->first();

                        if (!is_null($department->default_color) && $accessory->spec !== $department->default_color) {
                            $fail(__('validation.color_not_match'));
                        }

                        if (!in_array($value, Item::accessoryIds())) {
                            $fail(__('validation.item_set_wrong'));
                        }
                    },
                ],
                'sets.*.cloth' => [
                    'exists:items,id',
                    function ($attribute, $value, $fail) use ($request) {
                        if (!in_array($value, Item::clothIds())) {
                            $fail(__('validation.item_set_wrong'));
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
                'sets.*.set_owner' => [
                    'distinct',
                    'exists:users,username',
                    function ($attribute, $value, $fail) use ($request) {
                        $user = User::where('username', $value)->first();
                        $stu_ids = Set::getHaveSetIds();

                        $order = Order::where('document_id', $request->document_id)->first();
                        if (!is_null($order)) {
                            $sets = $order->sets;
                            $set_ids = $sets->map->only('student_id')->flatten()->all();

                            $other_ids = array_diff($stu_ids, $set_ids);

                            if (in_array($user->id, $other_ids)) {
                                $fail(__('validation.student_had_set'));
                            }
                        }
                    },
                ],
                'sets.*.accessory' => [
                    'exists:items,id',
                    function ($attribute, $value, $fail) use ($request) {
                        $index = explode('.', $attribute)[1];

                        $username = $request->sets[$index]['set_owner'];

                        $user = User::where('username', $username)->first();
                        $department = $user->school_class->department;

                        $accessory = Item::find($value)->first();

                        if (!is_null($department->default_color) && $accessory->spec !== $department->default_color) {
                            $fail(__('validation.color_not_match'));
                        }

                        if (!in_array($value, Item::accessoryIds())) {
                            $fail(__('validation.item_set_wrong'));
                        }
                    },
                ],
                'sets.*.cloth' => [
                    'exists:items,id',
                    function ($attribute, $value, $fail) use ($request) {
                        if (!in_array($value, Item::clothIds())) {
                            $fail(__('validation.item_set_wrong'));
                        }
                    },
                ],
            ]);
        }

        $order->document_id = $request->document_id;
        $order->owner_id = User::where('username', $request->owner_username)->first()->id;
        $order->status_code = $request->status_code;

        if (!is_null($request->sets))
            $order->total_price = $this->calculateTotalPrice($request->sets);

        $order->save();

        if (!is_null($request->sets)) {
            $order->sets()->delete();
            $this->saveSets($order, $request->sets);
        }

        return redirect()->back()->with('success', $order->fresh());
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
                'own' => User::find(Auth::id())->orders,
                'set' => User::find(Auth::id())->set,
            ];
        }
        return [];
    }

    private function saveSets($order, $sets)
    {
        foreach ($sets as $set) {
            $username = $set['set_owner'];
            $user = User::where('username', $username)->first();
            $ordered_set = new Set();
            $ordered_set->student_id = $user->id;
            $ordered_set->order_id = $order->id;
            $ordered_set->color_item = $set['accessory'];
            $ordered_set->size_item = $set['cloth'];
            $ordered_set->save();
        }
    }

    private function checkBelongToStudent($order)
    {
        if ($order->owner->id !== Auth::id())
            abort(403);
    }

    private function calculateTotalPrice($sets)
    {
        $total_price = 0;
        foreach ($sets as $set) {
            $username = $set['set_owner'];
            if (str_starts_with($username, '2') || str_starts_with($username, '4')) {
                $total_price += Config::getBachelorSetPriceValue();
            } else if (str_starts_with($username, '6') || str_starts_with($username, '7')) {
                $total_price += Config::getMasterSetPriceValue();
            } else {
                // who are you?
            }
        }
        return $total_price;
    }
}
