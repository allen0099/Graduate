<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    public function updateDepartmentStamp(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ], [
            'required' => '不能沒有圖檔',
            'image' => '不能為非圖檔類型',
        ]);

        $stamp = Config::getDepartmentStamp();
        $disk = Storage::disk('picture');

        if ($disk->exists($stamp->value)) {
            $disk->delete($stamp->value);
        }

        $stamp->forceFill([
            'value' => $request->file('image')->store('', 'picture'),
        ])->save();

        return response()->noContent();
    }

    public function updateAdminStamp(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ], [
            'required' => '不能沒有圖檔',
            'image' => '不能為非圖檔類型',
        ]);

        $stamp = Config::getAdminStamp();
        $disk = Storage::disk('picture');

        if ($disk->exists($stamp->value)) {
            $disk->delete($stamp->value);
        }

        $stamp->forceFill([
            'value' => $request->file('image')->store('', 'picture'),
        ])->save();

        return response()->noContent();
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'location' => 'required|string',
            'type' => 'required|in:return,payment,receive',
        ]);
        
        $type = $request->input('type');
        $msg = '';

        if($type === 'return') {
            $location = Config::getReturnLocation();
            $msg = '歸還';
        } else if($type === 'payment') {
            $location = Config::getPaymentLocation();
            $msg = '付款';
        } else if($type === 'receive') {
            $location = Config::getReceiveLocation();
            $msg = '領取';
        }

        $location->value = $request->input('location');
        $location->save();

        return redirect()->back()->with('success', $msg.'地點更新成功！');
    }

    public function editSetPrice(Request $request)
    {
        $request->validate([
            'type' => 'required|in:bachelor,master,bachelor_margin,master_margin',
            'price' => 'required|integer',
        ]);

        return Config::editSetPrice($request->type, $request->price);
    }

    public function updatePdfName(Request $request)
    {
        $request->validate([
            'pdf' => 'required|in:a,b,c',
            'value' => 'required|string',
        ]);

        return Config::editPdfName($request->pdf, $request->value);
    }
}
