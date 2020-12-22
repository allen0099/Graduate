<?php

namespace App\Http\Controllers;

use App\Models\TimeRange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TimeRangeController extends Controller
{
    public function update(Request $request, $id)
    {
        $this->validateTime($request);

        $timeRange = TimeRange::find($id);
        $timeRange->start_time = $request->start_time;
        $timeRange->end_time = $request->end_time;
        $timeRange->save();

        return $this->redirectAfterDone('success', '資料變更成功！');
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

    private function redirectAfterDone(string $level = null, string $message = null)
    {
        $route = 'admin.setting';
        return $level === null || $message === null ?
            Redirect::route($route) :
            Redirect::route($route)->with($level, $message);
    }
}
