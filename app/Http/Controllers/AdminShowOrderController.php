<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
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
            $find_owner = User::where('username', $search);
            $find_document = Order::where('document_id', $search);

            if ($find_owner->count() === 0 && $find_document->count() === 0)
                $result = [];

            if ($find_owner->count() > 0) {
                $result = $find_owner->first()->orders()->get();

                if ($result->count() === 0) {
                    $result = $find_owner->first()->set()->first()->order()->get();
                }
            }

            if ($find_document->count() > 0) {
                $result = $find_document->get();
            }
        } else {
            $result = OrderController::showOrders();
        }
        return Inertia::render('Admin/Order/Show', ['search' => $search, 'orders' => $result]);
    }
}
