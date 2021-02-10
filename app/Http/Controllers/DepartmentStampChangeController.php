<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentStampChangeController extends Controller
{
    public function update(Request $request)
    {
        // 驗證格式是否正確
        $this->validateImage($request);

        // 儲存進資料庫
        $this->saveNewImage($request);

        // return '<img src="data:image/jpeg;base64,' . $base64_image . '" alt="未設定圖檔">';
        $data = [
            'ok'=> true
        ];

        return $data;
    }

    private function validateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ], [
            'required' => '不能沒有圖檔',
            'image' => '不能為非圖檔類型',
        ]);
    }

    private function saveNewImage(Request $request)
    {
        $department_stampConfig = Config::where('key', 'department_stamp')->first();
        $department_stampConfig->value = base64_encode(file_get_contents($request->file('image')));
        $department_stampConfig->save();
    }
}
