<?php

namespace App\Http\Controllers;

use App\Models\TimeRange;
use Illuminate\Http\Request;

class TimeRangeController extends Controller
{
    public function store(Request $request)
    {
        $this->validateTime($request);

        $time = new TimeRange();
        $time->content = $request->input('content');
        $time->start_time = $request->input('start_time');
        $time->end_time = $request->input('end_time');
        $time->save();
        $request->session()->flash('success', '新增資料成功！');
        return $this->redirectAfterDone();
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
            'end_time' => 'required|date|after:start_time',
        ], [
            'after' => '結束時間必須在開始時間之後。',
        ]);
    }

    private function redirectAfterDone()
    {
        return Redirect::route('time.index');
    }

    public function update(Request $request, TimeRange $timeRange)
    {
        $this->validateTime($request);

        $timeRange->start_time = $request->start_time;
        $timeRange->end_time = $request->end_time;
        $timeRange->save();
        $request->session()->flash('success', '資料變更成功！');
        return $this->redirectAfterDone();
    }

    public function destroy(Request $request, TimeRange $timeRange)
    {
        $timeRange->delete();
        $request->session()->flash('success', '資料刪除成功！');
        return $this->redirectAfterDone();
    }
}
