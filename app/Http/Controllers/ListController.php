<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashierListDate;
use App\Http\Requests\CashierRefund;
use App\Models\CashierList;
use App\Models\Set;
use App\Models\TimeRange;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function createNewList(CashierListDate $request)
    {
        $request->validated();

        if (is_null($request->start_date)) {
            // run default
            $start_date = TimeRange::find(TimeRange::RET)->start_time;
            $end_date = today();
        } else {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
        }

        $sets = Set::all()
            ->whereNull('list_id')
            ->whereBetween('returned', [$start_date, $end_date]);

        $list = new CashierList();
        $list->save();

        foreach ($sets as $set) {
            $set->forceFill([
                'list_id' => $list->id,
            ])->save();
        }

        return $list->fresh();
    }

    public function refunded(CashierRefund $request)
    {
        $request->validated();

        $list = CashierList::find($request->id);
        $list->forceFill([
            'refund' => true,
        ])->save();

        return $list->fresh();
    }
}
