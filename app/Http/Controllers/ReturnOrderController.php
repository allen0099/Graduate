<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
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
        $stu_id = $request->stu_id;

        if ($stu_id !== null) {
            $stu = User::where('username', $stu_id)->firstOr(fn() => abort(404));

            $set = $stu->set()->get()->first();

            if ($set->returned) {
                return response()
                    ->json([
                        'error' => 'duplicate',
                        'message' => __('validation.student_returned')
                    ], 400);
            }

            $set->returned = true;
            $set->save();

            $order = $set->order()->get();

            return $order;
        }
        return abort(404);
    }
}
