<?php

namespace App\Http\Controllers;

use App\Models\TimeRange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TimeRangeController extends Controller
{
    public function update(Request $request, int $id)
    {
        $this->validateTime($request);

        $timeRange = TimeRange::find($id);

        $timeRange->forceFill([
            'start_time' => $request->start_time,
            'end_time' => Carbon::createFromFormat('Y-m-d', $request->end_time)->endOfDay(),
        ])->save();
        Log::info("[Log::TimeRangeControllerUpdate]", [
            'id' => $id,
            'ip' => $request->ip(), 
            'username'=>Auth::user()->username
        ]);
        return $this->redirectAfterDone('success', '資料變更成功！');
    }

    public function store(Request $request)
    {
        $this->validateTime($request);

        $time = new TimeRange();
        $time->forceFill([
            'content' => $request->input('content'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time')
        ])->save();

        return $this->redirectAfterDone('success', '新增資料成功！');
    }

    public function destroy(Request $request, $id)
    {
        $timeRange = TimeRange::find($id);
        $timeRange->delete();

        return $this->redirectAfterDone('success', '資料刪除成功！');
    }

    private function validateTime(Request $request)
    {
        if ($request->has('content')) {
            $request->validate([
                'content' => 'required|unique:App\Time,content',
            ]);
        }

        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ], [
            'after' => '結束時間必須在開始時間之後。',
        ]);
    }

    private function redirectAfterDone(string $level = null, string $message = null)
    {
        $route = 'admin.setting';
        return $level === null || $message === null ?
            Redirect::route($route) :
            Redirect::route($route)->with($level, $message);
    }
}
