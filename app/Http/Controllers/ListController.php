<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashierRefund;
use App\Models\CashierList;
use App\Models\Set;
use App\Models\TimeRange;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ListController extends Controller
{
    public function notReturnedTotal(){
        
        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', TimeRange::find(TimeRange::RET)->start_time.' 00:00:00', 'Asia/Taipei');
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', TimeRange::find(TimeRange::RET)->end_time.' 23:59:59', 'Asia/Taipei');

        $list = [];
        for (; $start_date <= $end_date;) {
            $temp = $start_date->copy();
            $set = Set::all()
            ->whereNull('list_id')
            ->whereBetween('returned', [$temp, $start_date->addDays(1)]);
            array_push($list, ["date" => $temp, "count" => count($set), $set]);
        }

        // $set = Set::all()
        //     ->whereNull('list_id')
        //     ->whereBetween('returned', [TimeRange::find(TimeRange::RET)->start_time, $end_date])->get();

        return $list;
    }

    public function createNewList(Request $request)
    {   
        // $request->validated();

        if (is_null($request->start_date) || is_null($request->end_date)) {
            // run default
            $start_date = TimeRange::find(TimeRange::RET)->start_time;
            $end_date = today();
        } else {
            $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_date.' 00:00:00', 'Asia/Taipei')->setTimezone('UTC');
            $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $request->end_date.' 23:59:59', 'Asia/Taipei')->setTimezone('UTC');
        }

        $sets = Set::all()
            ->whereNull('list_id')
            ->whereBetween('returned', [$start_date, $end_date]);

        if (count($sets) > 0) {
            $list = new CashierList();
            $list->save();
            foreach ($sets as $set) {
                $set->forceFill([
                    'list_id' => $list->id,
                ])->save();
            }
            $list->fresh();

            $response = [
                "ok" => true,
                "list_id" => $list->id,
                "sets" => $sets
            ];

        } else {
            $response = [
                "ok" => false,
                "list_id" => null,
                "sets" => $sets
            ];
        }

        return $response;
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
