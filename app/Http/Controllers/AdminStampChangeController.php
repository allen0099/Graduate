<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminStampChangeController extends Controller
{
    public function update(Request $request)
    {
        // 驗證格式是否正確
        $this->validateImage($request);

        // 儲存進資料庫
        $this->saveNewImage($request);

        return response()->noContent();
    }

    private function validateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'required' => '不能沒有圖檔',
            'image' => '不能為非圖檔類型',
        ]);
    }

    private function saveNewImage(Request $request)
    {
        $filename = Storage::putFile('picture', $request->image);
        $user = User::find(Auth::id());
        $user->stamp = Storage::disk('local')->url($filename);
        $user->save();
    }
}