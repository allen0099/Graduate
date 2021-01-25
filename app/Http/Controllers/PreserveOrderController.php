<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\TimeRange;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreserveOrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'order_id' => [
                'required',
                'exists:orders,document_id'
            ]
        ]);

        $order = Order::where('document_id', $request->order_id)->first();

        $request->validate([
            'preserve_date' => [
                'required',
                'after_or_equal:' . now()->addDays(2)->startOfDay(),
                'before_or_equal:' . ($order->owner->isBachelor() ?
                    TimeRange::getBachelorReturnEndTime() :
                    TimeRange::getMasterReturnEndTime()),
            ],
        ]);

        if ($user->role === User::STUDENT && $order->owner->id !== $user->id)
            return abort(403);

        $order->preserve = $request->preserve_date;
        $order->save();

        return $order->fresh();
    }
}
