<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckStartAndEndDate;
use App\Http\Requests\UpdateList;
use App\Models\CashierList;
use App\Models\Set;
use App\Models\TimeRange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListController extends Controller
{
    public function notReturnedTotal()
    {

        $start_date = Carbon::createFromFormat('Y-m-d H:i:s', TimeRange::find(TimeRange::RET)->start_time . ' 00:00:00', 'Asia/Taipei');
        $end_date = Carbon::createFromFormat('Y-m-d H:i:s', TimeRange::find(TimeRange::RET)->end_time . ' 23:59:59', 'Asia/Taipei');

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

    public function getNotListedSets(CheckStartAndEndDate $request)
    {
        $request->validated();

        if (is_null($request->start_date)) {
            $start_date = TimeRange::find(TimeRange::RET)->start_time;
            $end_date = today();
        } else {
            $start_date = Carbon::parse($request->start_date);
            $end_date = Carbon::parse($request->end_date);
        }

        return Set::all()
            ->whereNull('list_id')
            ->whereBetween('returned', [$start_date, $end_date]);
    }

    public function getListByStatus(Request $request)
    {
        $request->validate([
            'status_code' => ['required', Rule::in(CashierList::CODE_ARRAY)],
        ]);

        return CashierList::all()->where('status', $request->status_code);
    }

    public function getSetsByStatus(Request $request)
    {
        $request->validate([
            'status_code' => ['required', Rule::in(CashierList::CODE_ARRAY)],
        ]);

        return Set::all()->where('cashier_list.status', $request->status_code);
    }

    public function createNewList(Request $request)
    {
        $request->validate([
            'id.*' => ['required', 'exists:sets,id'],
        ]);

        $list = new CashierList();
        $list->save();

        foreach ($request->id as $item) {
            $set = Set::find($item);
            $set->forceFill([
                'list_id' => $list->id,
            ])->save();
        }

        return $list->fresh();
    }

    public function updateList(UpdateList $request)
    {
        $request->validated();

        $list = CashierList::find($request->id);

        if ($request->status === 'delete') {
            $list->delete();

            return response()->noContent();
        }

        $list->forceFill([
            'status' => $request->status,
        ])->save();

        return $list->fresh();
    }
}
