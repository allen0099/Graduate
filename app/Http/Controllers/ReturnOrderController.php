<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class ReturnOrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $doc_id = $request->doc_id;

        if ($doc_id !== null) {
            $order = Order::where('document_id', $doc_id)->firstOr(function () {
                return abort(404);
            });

            if ($order->status_code === Order::code_returned) {
                return [
                    'error' => 'duplicate',
                    'message' => 'order has returned'
                ];
            }

            $order->status_code = Order::code_returned;
            $order->save();

            return $order;
        }
        return abort(404);
    }
}
