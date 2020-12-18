<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class ReturnLocationController extends Controller
{
    public function update(Request $request)
    {
        // flash?
        // https://github.com/inertiajs/pingcrm/commit/f61d969aa59fc89255f26f55e4dbe5f6eea1eefb
        $this->validateLocation($request);

        $this->saveLocation($request);

        return redirect()->route('home')->with('success', '歸還地點更新成功！');
    }

    private function validateLocation(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
        ]);
    }

    private function saveLocation(Request $request)
    {
        $location = Config::where('key', '歸還地點')->first();
        $location->value = $request->input('location');
        $location->save();
    }
}
