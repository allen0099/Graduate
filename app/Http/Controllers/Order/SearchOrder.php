<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class SearchOrder extends Controller
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

        if (!is_null($search)) {
            $find_owner = User::where('username', $search);
            $find_document = Order::where('document_id', $search);
            $find_payment_id = Order::where('payment_id', $search);

            if ($find_owner->count() === 0 && $find_document->count() === 0 && $find_payment_id->count() === 0)
                $result = [];

            if ($find_owner->count() > 0) {
                $result = $find_owner->first()->orders()->get();

                if ($result->count() === 0) {
                    $set = $find_owner->first()->set()->first();
                    if (!is_null($set))
                        $result = $set->order()->get();
                }
            }

            if ($find_document->count() > 0) {
                $result = $find_document->get();
            }

            if ($find_payment_id->count() > 0) {
                $result = $find_payment_id->get();
            }

            return $result;
        }

        abort(404);
    }
}
