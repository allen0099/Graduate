<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Set;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminShowOrderController extends Controller
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

        if ($search !== null) {
            $find_user = User::where('username', $search);
            $find_orders = Order::where('document_id', $search)->orWhere('payment_id', $search);

            if ($find_user->count() === 0 && $find_orders->count() === 0)
                $result = [];

            if ($find_user->count() > 0) {
                $find_set = Set::where('student_id', $find_user->first()->id);

                if($find_set->count() > 0){
                    $tmp = Order::where('id', $find_set->first()->order_id);
                    $result = $tmp->get();
                }
                else {
                    $result = [];
                }
            }

            if ($find_orders->count() > 0) {
                $result = $find_orders->get();
            }

        } else {
            $result = OrderController::showOrders();
        }
        return Inertia::render('Admin/Order/Show', ['search' => $search, 'orders' => $result]);
    }
}
