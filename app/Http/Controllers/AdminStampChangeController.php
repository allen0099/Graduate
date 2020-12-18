<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminStampChangeController extends Controller
{
    public function update(Request $request)
    {
        // 驗證格式是否正確
        $this->validateImage($request);

        // 儲存進資料庫
        $this->saveNewImage($request);

        // return '<img src="data:image/jpeg;base64,' . $base64_image . '" alt="未設定圖檔">';
        return redirect()->route('profile')->with('success', '印鑑變更成功！');
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
        $user = User::find(Auth::id());
        $user->base64Img = base64_encode(file_get_contents($request->file('image')));
        $user->save();
    }
}
