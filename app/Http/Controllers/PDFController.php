<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public function findPdf(Request $request)
    {
        $file_name = $request->name . '.pdf';
        $disk = Storage::disk('pdf');

        return $disk->exists($file_name)
            ? response()->redirectTo($disk->url($file_name))
            : abort(404);
    }

    public function orderPdf(Request $request)
    {
        $document_id = $request->document_id;

        if (!is_null($document_id)) {
            $result = Order::where('document_id', $document_id)->first();

            if (Auth::user()->role !== User::ADMIN && $result->owner->id !== Auth::user()->id) {
                return abort(403);
            }

            $sizeList = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0];
            $colorList = ['白' => 0, '黃' => 0, '橘' => 0, '灰' => 0, '藍' => 0, '紫' => 0];
            $totle = 0;

            if (!is_null($result)) {

                $cloth_type = $result->owner->isMaster() ? "碩士服" : "學士服";
                foreach ($result->sets as $i => $i_value) {
                    $colorList[$i_value->accessory->spec] += 1;
                    $sizeList[$i_value->cloth->spec] += 1;
                    $totle += 1;
                }

                $data = [
                    'order' => $result,
                    'sizeList' => $sizeList,
                    'colorList' => $colorList,
                    'totle' => $totle,
                    'one_set_price' => 1000,
                    'cloth_type' => $cloth_type
                ];

                $pdf = PDF::loadView('pdf/order', $data);

                return $pdf->stream($result->owner->username . '.pdf');
            }
        }
        return '資料錯誤';
    }
}
