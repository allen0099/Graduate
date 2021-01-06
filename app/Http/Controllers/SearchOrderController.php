<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class SearchOrderController extends Controller
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
                return [];

            if ($find_owner->count() > 0) {
                return $find_owner->first()->owned_orders()->get();
            }

            if ($find_document->count() > 0) {
                return $find_document->get();
            }
        }
        return abort(404);
    }
}
