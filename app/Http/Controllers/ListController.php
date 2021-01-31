<?php

namespace App\Http\Controllers;

use App\Http\Requests\CashierListDate;
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

        $sets = Set::all()->whereBetween('returned', [$start_date, $end_date]);

        // todo: filter 出還沒送出納組的人
        //  new set()
    }
}
