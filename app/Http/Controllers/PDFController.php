<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Set;
use App\Models\TimeRange;
use App\Models\Config;
use App\Models\CashierList;
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

    public function uploadPdf(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'pdf_file' => ['required', 'mimes:pdf', 'max:5000'],
        ]);

        $disk = Storage::disk('pdf');
        $disk->putFileAs('', $request->pdf_file, $request->name . '.pdf');

        return response()->noContent();
    }

    public function orderPdf(Request $request)
    {
        $document_id = $request->document_id;

        if (!is_null($document_id)) {
            $result = Order::where('document_id', $document_id)->first();

            if (Auth::user()->role !== User::ADMIN && $result->owner->id !== Auth::user()->id) {
                return abort(403);
            }

            if (!is_null($result)) {

                $cloth_type = $result->owner->isMaster() ? "碩士服" : "學士服";

                $barcode_username = (new DNS1D)->getBarcodePNG((string)$result->owner->username, 'C39');
                $barcode_id = (new DNS1D)->getBarcodePNG((string)$result->document_id, 'C39');

                $paid_time = TimeRange::find(TimeRange::PAID_TIME);
                $rec_time = TimeRange::find($result->owner->isMaster() ? TimeRange::M : TimeRange::B);
                $location = Config::getReturnLocation();
                $price = $result->owner->isMaster() ? Config::getMasterPrice() : Config::getBachelorPrice();
                $margin = $result->owner->isMaster() ? Config::getMasterMarginPrice() : Config::getBachelorMarginPrice();

                $data = [
                    'order' => $result,
                    'price' => (int)$price->value,
                    'margin' => (int)$margin->value,
                    'cloth_type' => $cloth_type,
                    'location' => $location->value,
                    'paid_time' => $paid_time,
                    'rec_time' => $rec_time
                ];

                $pdf = PDF::loadView('pdf/order', $data)->setPaper('a4', 'potrait');

                return $pdf->stream('訂單-' . $result->owner->username . '.pdf');
                // return $data;
            }
        }
        return abort(404);
    }

    public function preservePdf()
    {
        // $Bachelor_start = Carbon::createFromFormat('Y-m-d', TimeRange::getBachelorReceiveStartTime());
        // $Bachelor_end = Carbon::createFromFormat('Y-m-d', TimeRange::getBachelorReceiveEndTime());

        $disk = Storage::disk('pdf');
        $Bachelor_start = TimeRange::getBachelorReceiveStartTime();
        $Bachelor_end = TimeRange::getBachelorReceiveEndTime();
        $start = null;
        $end = null;

        $res = [];

        if (today()->addDays(1) >= $Bachelor_start) {
            $start = today()->addDays(1) > $Bachelor_start ? $Bachelor_start : today()->addDays(1);
            $end = today()->addDays(1) > $Bachelor_end ? $Bachelor_end : today()->addDays(1);
            while ($start <= $end) {
                if ($disk->exists('preseve/學士服預約清單' . $start->format('Y-m-d') . '.pdf')) {
                    array_push($res, [
                            'filepath' => $disk->url('preseve/學士服預約清單' . $start->format('Y-m-d') . '.pdf'),
                            'filename' => '學士服預約清單' . $start->format('Y-m-d') . '.pdf'
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
                Storage::put('pdf/preseve/學士服預約清單' . $start->format('Y-m-d') . '.pdf', $content);

                array_push($res, [
                        'filepath' => $disk->url('preseve/學士服預約清單' . $start->format('Y-m-d') . '.pdf'),
                        'filename' => '學士服預約清單' . $start->format('Y-m-d') . '.pdf'
                    ]
                );
                $start->addDays(1);
            }
        }

        $Master_start = TimeRange::getMasterReceiveStartTime();
        $Master_end = TimeRange::getMasterReceiveEndTime();
        $start = null;
        $end = null;

        if (today()->addDays(1) >= $Master_start) {
            $start = today()->addDays(1) > $Master_start ? $Master_start : today()->addDays(1);
            $end = today()->addDays(1) > $Master_end ? $Master_end : today()->addDays(1);
            while ($start <= $end) {
                if ($disk->exists('preseve/碩士服預約清單' . $start->format('Y-m-d') . '.pdf')) {
                    array_push($res, [
                            'filepath' => $disk->url('preseve/碩士服預約清單' . $start->format('Y-m-d') . '.pdf'),
                            'filename' => '碩士服預約清單' . $start->format('Y-m-d') . '.pdf'
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
                Storage::put('pdf/preseve/碩士服預約清單' . $start->format('Y-m-d') . '.pdf', $content);

                array_push($res, [
                        'filepath' => $disk->url('preseve/碩士服預約清單' . $start->format('Y-m-d') . '.pdf'),
                        'filename' => '碩士服預約清單' . $start->format('Y-m-d') . '.pdf'
                    ]
                );
                $start->addDays(1);
            }
        }

        return $res;
    }

    public function receiptPdf(Request $request)
    {
        if (Auth::user()->role !== User::ADMIN) {
            $find_set = Set::where('student_id', Auth::user()->id);
        } else if (Auth::user()->role === User::ADMIN) {
            $student_id = $request->student_id;
            if (!is_null($student_id)) {
                $find_studnet = User::where('username', $student_id);
                if ($find_studnet->count() === 0) {
                    return abort(404);
                }
                $find_set = Set::where('student_id', $find_studnet->first()->id);
            } else {
                return abort(404);
            }
        } else {
            return abort(403);
        }

        if ($find_set->count() === 0) {
            return abort(404);
        }

        $set = $find_set->first();

        $data = [
            'student' => $set->student,
            'accessory' => $set->accessory,
            'cloth' => $set->cloth
        ];

        $pdf = PDF::loadView('pdf/receipt', $data)->setPaper('a4', 'potrait');

        return $pdf->stream('歸還證明單-' . $set->student->username . '.pdf');
        // return $data;
    }

    public function refundPdf(Request $request) {
        $id = $request->id;
        if(!is_null($id)){
            $list = CashierList::find($id);
            
            $state =  ['meow', '尚未還款', '還款中', '已還款'];
            if(!is_null($list)){
                $data = [
                    'list' => $list,
                    'state' => $state[$list->status],
                ];

                $pdf = PDF::loadView('pdf/refund', $data)->setPaper('a4', 'potrait');
                return $pdf->stream('還款名單-' . $list->id . '-' . $state[$list->status] .'.pdf');
            }
        }
        return abort(404);
    }

    public function test()
    {
        $barcode_username = (new DNS1D)->getBarcodeHTML('4445645656', 'C39+');
        error_log($barcode_username);
        // return '<img src="data:image/png; base64, '.$barcode_username.'" />';
        return $barcode_username;
    }
}
