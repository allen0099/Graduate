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

                $D_data = file_get_contents('picture/' .Config::getDepartmentStampFilename());
                $A_data = file_get_contents('picture/' .Config::getAdminStampFilename());
                $D_type = pathinfo('picture/' .Config::getDepartmentStampFilename(), PATHINFO_EXTENSION);
                $A_type = pathinfo('picture/' .Config::getAdminStampFilename(), PATHINFO_EXTENSION);

                $data = [
                    'order' => $result,
                    'price' => (int)$price->value,
                    'margin' => (int)$margin->value,
                    'cloth_type' => $cloth_type,
                    'location' => $location->value,
                    'paid_time' => $paid_time,
                    'rec_time' => $rec_time,
                    'department_stamp' => 'data:image/' . $D_type . ';base64,' . base64_encode($D_data),
                    'admin_stamp' => 'data:image/' . $A_type . ';base64,' . base64_encode($A_data)
                ];

                $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isFontSubsettingEnabled' => true])->setPaper('a4', 'potrait')->loadView('pdf/order', $data);
                // 'isFontSubsettingEnabled' => true
                // $pdf = PDF::loadView('pdf/order', $data)->setPaper('a4', 'potrait');
                return $pdf->stream('訂單-' . $result->owner->username . '.pdf');
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
                $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isFontSubsettingEnabled' => true])->setPaper('a4', 'potrait')->loadView('pdf/preserve', $data);
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
                $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isFontSubsettingEnabled' => true])->setPaper('a4', 'potrait')->loadView('pdf/preserve', $data);
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

        $pdf = PDF::setOptions([
            'isRemoteEnabled' => true, 
            'isFontSubsettingEnabled' => true,
            'isPhpEnabled' => true
            ])->setPaper('a4', 'potrait')->loadView('pdf/receipt', $data);

        return $pdf->stream('歸還證明單-' . $set->student->username . '.pdf');
    }

    public function refundPdf(Request $request) {
        $id = $request->id;
        if(!is_null($id)){
            $list = CashierList::find($id);
            
            $state =  ['meow', '尚未送出', '還款中', '已還款'];
            if(!is_null($list)){

                foreach ($list->sets as $item => $set) {
                    $order = Order::find($set->order_id);
                    $set['document_id'] = $order->document_id;
                    $pos = -1;

                    foreach ($order->sets as $key => $value){
                        if ($set->id === $value->id){
                            $pos = $key + 1;
                            break;
                        }
                    }

                    $set['return_id'] = $order->payment_id.'-'.$pos;
                }
                

                $year = today()->year - 1911;
                if(today()->month <= 7){
                    $year -= 1;
                }

                $sets = collect([...$list->sets, ...$list->sets, ...$list->sets, ...$list->sets, ...$list->sets, ...$list->sets, ...$list->sets, ...$list->sets]);

                $type = $list->type === 0 ? '學士' : '碩士';

                $data = [
                    'list' => $list,
                    // 'sets_chunk' => $list->sets->chunk(30),
                    'sets_chunk' => $sets->chunk(35),
                    'state' => $state[$list->status],
                    'year' => $year,
                    'type' => $type
                ];
                $pdf = PDF::loadView('pdf/refund', $data)->setPaper('a4', 'potrait');

                return $pdf->stream($year.'學年度'.$type.'學位服還款清單-'.$list->id.'-'.$state[$list->status] .'.pdf');
            }
        }
        return abort(404);
    }

    public function returnPdf(Request $request) {
        if(Auth::check()) {
            $document_id = $request->document_id;
            $stu_id =$request->stu_id;
            if(!is_null($stu_id) && !is_null($document_id)){
                if (Auth::user()->role === User::STUDENT && Auth::user()->username !== $stu_id){
                    return abort(403);
                } else {
                    $find_studnet = User::where('username', $stu_id);
                    
                    if ($find_studnet->count() === 0) {
                        return abort(404);
                    }

                    $find_order = Order::where('document_id', $document_id);

                    if ($find_order->count() === 0) {
                        return abort(404);
                    }

                    $order = $find_order->first();

                    $find_set = Set::where('student_id', $find_studnet->first()->id);

                    if ($find_set->count() === 0) {
                        return abort(404);
                    }

                    $set = $find_set->first();

                    $pos = -1;

                    foreach ($order->sets as $key => $value){
                        if ($set->id === $value->id){
                            $pos = $key + 1;
                            break;
                        }
                    }

                    $D_data = file_get_contents('picture/' .Config::getDepartmentStampFilename());
                    $A_data = file_get_contents('picture/' .Config::getAdminStampFilename());
                    $D_type = pathinfo('picture/' .Config::getDepartmentStampFilename(), PATHINFO_EXTENSION);
                    $A_type = pathinfo('picture/' .Config::getAdminStampFilename(), PATHINFO_EXTENSION);

                    $data = [
                        'set' => $set,
                        'payment_id' => $order->payment_id,
                        'document_id' => $order->document_id,
                        'pos' => $pos,
                        'department_stamp' => 'data:image/' . $D_type . ';base64,' . base64_encode($D_data),
                        'admin_stamp' => 'data:image/' . $A_type . ';base64,' . base64_encode($A_data),
                        'return_time' => TimeRange::find(TimeRange::RET)
                    ];

                    $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isFontSubsettingEnabled' => true, 'isHtml5ParserEnabled' => true])->setPaper('a4', 'potrait')->loadView('pdf/return', $data);

                    return $pdf->stream('歸還證明單-' . $set->student->username . '.pdf');
                }
            }
            return abort(404);
        }
        return abort(403);
    }

    public function test()
    {
        $barcode_username = (new DNS1D)->getBarcodeHTML('4445645656', 'C39+');
        error_log($barcode_username);
        // return '<img src="data:image/png; base64, '.$barcode_username.'" />';
        return $barcode_username;
    }
}
