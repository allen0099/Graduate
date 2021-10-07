<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function __invoke(Request $request)
    {
        $search = $request->search;

        return Inertia::render('Admin/Order/Show', ['search' => $search]);
        // return $result;
    }

    public function getOrderByState(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        Log::info("[Log::getOrderByState]", [
            'ip' => $request->ip(),
            'username' => Auth::user() ? Auth::user()->username : 'who_are_you'
        ]);

        if ($search !== null && $search !== 'null'){
            $find_user = User::where('username', $search);
            $find_orders = Order::withTrashed()->where('document_id', $search)->orWhere('payment_id', $search);
            if ($find_user->count() === 0 && $find_orders->count() === 0){
                return abort(404);
            }

            if ($find_user->count() > 0) {
                $find_set = Set::where('student_id', $find_user->first()->id);

                if($find_set->count() > 0){
                    $tmp = Order::withTrashed()->where('id', $find_set->first()->order_id);
                    $result = $tmp;
                } else {
                    return abort(404);
                }
            }

            if ($find_orders->count() > 0) {
                $result = $find_orders;
            }
            if ($status > 0 && $status <= 6) {
                $result = $result->where('status_code', $status)->orderBy('updated_at', 'desc')->paginate(20);
            } else {
                $result = $result->orderBy('updated_at', 'desc')->paginate(20);
            }

        } else {
            if ($status > 0 && $status < 6) {
                $result = Order::where('status_code', $status)->orderBy('updated_at', 'desc')->paginate(20);
            } else if ($status == 6) {
                if (Auth::user()->isRole(User::ADMIN)) {
                    $result = Order::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(20);
                }
            } else {
                $result = Order::orderBy('updated_at', 'desc')->paginate(20);
            }
        }

        Log::info("[Log::getOrderByState::SUCCESS]", [
            'ip' => $request->ip(),
            'username' => Auth::user() ? Auth::user()->username : 'who_are_you',
            'search' => ($search !== null && $search !== 'null') ? $request->search : 'null',
            'status' => $request->status,
        ]);
        
        return $result;
    }

        public function cancelAllUnpaidOrder(Request $request)
    {
        Log::info("[Log::cancelAllUnpaidOrder]", [
            'ip' => $request->ip(),
            'username' => Auth::user() ? Auth::user()->username : 'who_are_you'
        ]);

        if ($request->check !== '刪除') {
            Log::info("[Log::cancelAllUnpaidOrder::FAIL]", [
                'ip' => $request->ip(),
                'username' => Auth::user() ? Auth::user()->username : 'who_are_you',
                'msg' => 'not have check',
            ]);
            return abort(403);
        }

        $orders = Order::where('status_code', Order::code_created)->get();

        $total = $orders->count();


        foreach ($orders as $order) {
            $order->status_code = Order::code_canceled;
            $order->save();

            $order->sets()->delete();
            $order->delete();
        }

        Log::info("[Log::cancelAllUnpaidOrder:SUCCESS]", [
            'ip' => $request->ip(),
            'username' => Auth::user() ? Auth::user()->username : 'who_are_you',
            'total' => $total
        ]);

        return response()->noContent();
    }
}
