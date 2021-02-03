<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\TimeRange;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;

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

            // $sizeList = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0];
            // $colorList = ['白' => 0, '黃' => 0, '橘' => 0, '灰' => 0, '藍' => 0, '紫' => 0];
            // $totle = 0;

            if (!is_null($result)) {

                $cloth_type = $result->owner->isMaster() ? "碩士服" : "學士服";

                // foreach ($result->sets as $i => $i_value) {
                //     $colorList[$i_value->accessory->spec] += 1;
                //     $sizeList[$i_value->cloth->spec] += 1;
                //     $totle += 1;
                // }

                $barcode_username = (new DNS1D)->getBarcodePNG((string)$result->owner->username, 'C39');
                $barcode_id = (new DNS1D)->getBarcodePNG((string)$result->document_id, 'C39');

                $data = [
                    'order' => $result,
                    // 'sizeList' => $sizeList,
                    // 'colorList' => $colorList,
                    'totle' => 10,
                    'one_set_price' => 1000,
                    'cloth_type' => $cloth_type,
                    // 'barcode_username' => $barcode_username,
                    'barcode_id' => $barcode_id
                ];

                $pdf = PDF::loadView('pdf/order', $data)->setPaper('a4', 'potrait');
                // $pdf = PDF::setOptions(
                //     ['isHtml5ParserEnabled'=>true,'isRemoteEnabled'=>true])->loadView('pdf/order', $data
                // );

                return $pdf->stream('訂單-'.$result->owner->username.'.pdf');
                // return view('pdf/order', $data);
                // return '<img src="data:image/png; base64, '.$barcode_username.'" />';
            }
        }
        return '資料錯誤';
    }

    public function preservePdf(){
        // $Bachelor_start = Carbon::createFromFormat('Y-m-d', TimeRange::getBachelorReturnStartTime());
        // $Bachelor_end = Carbon::createFromFormat('Y-m-d', TimeRange::getBachelorReturnEndTime());
        
        $disk = Storage::disk('pdf');

        $Bachelor_start = TimeRange::getBachelorReturnStartTime();
        $Bachelor_end = TimeRange::getBachelorReturnEndTime();
        $start = null;
        $end = null;

        $res = [];

        if(today()->addDays(1) >= $Bachelor_start){
            $start = today()->addDays(1) > $Bachelor_start ? $Bachelor_start : today()->addDays(1);
            $end = today()->addDays(1) > $Bachelor_end ? $Bachelor_end : today()->addDays(1);
            while($start <= $end){
                if($disk->exists('preseve/學士服預約清單'.$start->format('Y-m-d').'.pdf')){
                    array_push($res, [
                        'filepath'=>$disk->url('preseve/學士服預約清單'.$start->format('Y-m-d').'.pdf'),
                        'filename' => '學士服預約清單'.$start->format('Y-m-d').'.pdf'
                        ]
                    );
                    $start->addDays(1);
                    continue;
                }

                $order = Order::whereDate('preserve', '=', $start)->get();
                $order = $order->filter(function ($value, $key) {
                    return $value->owner->username[0] < "5";
                });
                $data = ['date' => $start->format('Y-m-d')];
                $pdf = PDF::loadView('pdf/preserve', $data)->setPaper('a4', 'potrait');
                $content = $pdf->download()->getOriginalContent();
                Storage::put('pdf/preseve/學士服預約清單'.$start->format('Y-m-d').'.pdf', $content);
                
                array_push($res, [
                    'filepath'=>$disk->url('preseve/學士服預約清單'.$start->format('Y-m-d').'.pdf'),
                    'filename' => '學士服預約清單'.$start->format('Y-m-d').'.pdf'
                    ]
                );
                $start->addDays(1);
            }
        }

        $Master_start = TimeRange::getMasterReturnStartTime();
        $Master_end = TimeRange::getMasterReturnEndTime();
        $start = null;
        $end = null;

        if(today()->addDays(1) >= $Master_start){
            $start = today()->addDays(1) > $Master_start ? $Master_start : today()->addDays(1);
            $end = today()->addDays(1) > $Master_end ? $Master_end : today()->addDays(1);
            while($start <= $end){
                if($disk->exists('preseve/碩士服預約清單'.$start->format('Y-m-d').'.pdf')){
                    array_push($res, [
                        'filepath'=>$disk->url('preseve/碩士服預約清單'.$start->format('Y-m-d').'.pdf'),
                        'filename' => '碩士服預約清單'.$start->format('Y-m-d').'.pdf'
                        ]
                    );
                    $start->addDays(1);
                    continue;
                }
                $order = Order::whereDate('preserve', '=', $start)->get();
                $order = $order->filter(function ($value, $key) {
                    return $value->owner->username[0] > "5";
                });
                $data = ['date' => $start->format('Y-m-d')];
                $pdf = PDF::loadView('pdf/preserve', $data)->setPaper('a4', 'potrait');
                $content = $pdf->download()->getOriginalContent();
                Storage::put('pdf/preseve/碩士服預約清單'.$start->format('Y-m-d').'.pdf', $content);
                
                array_push($res, [
                    'filepath'=>$disk->url('preseve/碩士服預約清單'.$start->format('Y-m-d').'.pdf'),
                    'filename' => '碩士服預約清單'.$start->format('Y-m-d').'.pdf'
                    ]
                );
                $start->addDays(1);
            }
        }

        return $res;
    }

    public function test(){
        $barcode_username = (new DNS1D)->getBarcodeHTML('4445645656', 'C39+');
        error_log($barcode_username);
        // return '<img src="data:image/png; base64, '.$barcode_username.'" />';
        return $barcode_username;
    }


}
