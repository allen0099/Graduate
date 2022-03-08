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
use Illuminate\Support\Str;
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

    /** 學生的借用單 **/
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

                $return_location = Config::getReturnLocationValue();
                $payment_location = Config::getPaymentLocationValue();
                $receive_location = Config::getReceiveLocationValue();

                $price = $result->owner->isMaster() ? Config::getMasterPrice() : Config::getBachelorPrice();
                $margin = $result->owner->isMaster() ? Config::getMasterMarginPrice() : Config::getBachelorMarginPrice();

                $D_data = file_get_contents('picture/' . Config::getDepartmentStampFilename());
                $A_data = file_get_contents('picture/' . Config::getAdminStampFilename());
                $D_type = pathinfo('picture/' . Config::getDepartmentStampFilename(), PATHINFO_EXTENSION);
                $A_type = pathinfo('picture/' . Config::getAdminStampFilename(), PATHINFO_EXTENSION);

                $data = [
                    'order' => $result,
                    'price' => (int)$price->value,
                    'margin' => (int)$margin->value,
                    'cloth_type' => $cloth_type,
                    'return_location' => $return_location,
                    'payment_location' => $payment_location,
                    'receive_location' => $receive_location,
                    'paid_time' => $paid_time,
                    'rec_time' => $rec_time,
                    'department_stamp' => 'data:image/' . $D_type . ';base64,' . base64_encode($D_data),
                    'admin_stamp' => 'data:image/' . $A_type . ';base64,' . base64_encode($A_data),
                    'check_code' => Str::random(5)
                ];

                $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isFontSubsettingEnabled' => true])->setPaper('a4', 'potrait')->loadView('pdf/order', $data);
                return $pdf->stream('訂單-' . $result->owner->username . '.pdf');
            }
        }
        return abort(404);
    }

    /** 預約清單的數量計算 **/
    public function preserveCount($orders, $type)
    {

        foreach ($orders as $index => $order) {
            $sizeList = $type === 0 ? ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0] : ['M' => 0, 'L' => 0, 'XL' => 0];
            $colorList = $type === 0 ? ['白' => 0, '藍' => 0] : ['白' => 0, '黃' => 0, '橘' => 0, '灰' => 0, '藍' => 0, '紫' => 0];

            foreach ($order->sets as $i => $i_value) {
                if ($i === 0) {
                    $order['rep_color'] = $i_value->accessory->spec;
                }
                $colorList[$i_value->accessory->spec] += 1;
                $sizeList[$i_value->cloth->spec] += 1;
            }
            $order['sizeList'] = $sizeList;
            $order['colorList'] = $colorList;
        }

        $sorted_orders = [];

        $colorList = $type === 0 ? ['白' => 0, '藍' => 0] : ['白' => 0, '黃' => 0, '橘' => 0, '灰' => 0, '藍' => 0, '紫' => 0];

        while (count($orders) !== 0) {
            foreach ($colorList as $color => $value) {
                foreach ($orders as $index => $order) {
                    if ($order->colorList[$color] > 0) {
                        array_push($sorted_orders, $order);
                        unset($orders[$index]);
                    }
                }
            }
        }

        return collect($sorted_orders);
    }

    /** 管理員的預約清單 單日**/
    public function preservePdf()
    {
        $year = today()->year - 1911;
        if (today()->month <= 7) {
            $year -= 1;
        }

        $disk = Storage::disk('pdf');

        // 學士服
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

                $orders = Order::whereDate('preserve', '=', $start)->get();
                $orders = $orders->filter(function ($value, $key) {
                    return $value->owner->username[0] < "5" && $value->status_code === Order::code_paid;
                });

                $computed_orders = $this->preserveCount($orders, 0);

                $sizeList = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0];
                $colorList = ['白' => 0, '藍' => 0];

                foreach ($computed_orders as $index => $order) {
                    foreach ($sizeList as $spec => $value) {
                        $sizeList[$spec] += $order->sizeList[$spec];
                    }
                    foreach ($colorList as $spec => $value) {
                        $colorList[$spec] += $order->colorList[$spec];
                    }
                }


                $data = [
                    'type' => '學士',
                    'date' => $start->format('m-d'),
                    'orders_chunk' => $computed_orders->chunk(40),
                    'sizeList' => $sizeList,
                    'colorList' => $colorList,
                    'year' => $year
                ];

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

        // 碩士服
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
                $orders = Order::whereDate('preserve', '=', $start)->get();
                $orders = $orders->filter(function ($value, $key) {
                    return $value->owner->username[0] > "5" && $value->status_code === Order::code_paid;
                });

                $computed_orders = $this->preserveCount($orders, 1);

                $sizeList = ['M' => 0, 'L' => 0, 'XL' => 0];
                $colorList = ['白' => 0, '黃' => 0, '橘' => 0, '灰' => 0, '藍' => 0, '紫' => 0];

                foreach ($computed_orders as $index => $order) {
                    foreach ($sizeList as $spec => $value) {
                        $sizeList[$spec] += $order->sizeList[$spec];
                    }
                    foreach ($colorList as $spec => $value) {
                        $colorList[$spec] += $order->colorList[$spec];
                    }
                }

                $data = [
                    'type' => '碩士',
                    'date' => $start->format('m-d'),
                    'orders_chunk' => $computed_orders->chunk(40),
                    'sizeList' => $sizeList,
                    'colorList' => $colorList,
                    'year' => $year,
                ];

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

    /** 管理員的 "已預約" 清單 全部**/
    public function preserveAllPdf()
    {
        $year = today()->year - 1911;
        if (today()->month <= 7) {
            $year -= 1;
        }

        $disk = Storage::disk('pdf');

        // 學士服
        $Bachelor_start = TimeRange::getBachelorReceiveStartTime();
        $Bachelor_end = TimeRange::getBachelorReceiveEndTime();
        $start = null;
        $end = null;

        $res = [];

        if (today()->addDays(1) >= $Bachelor_start) {
            $start = today()->addDays(1) > $Bachelor_start ? $Bachelor_start : today()->addDays(1);
            $end = today()->addDays(1) > $Bachelor_end ? $Bachelor_end : today()->addDays(1);
            $allOrders = collect(new Order);
            while ($start <= $end) {
                $orders = Order::whereDate('preserve', '=', $start)->get();
                $orders = $orders->filter(function ($value, $key) {
                    return $value->owner->username[0] < "5" && $value->status_code === Order::code_paid;
                });
                $allOrders = $allOrders->merge($orders);
                $start->addDays(1);
            }

            $computed_orders = $this->preserveCount($allOrders, 0);

            $sizeList = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0];
            $colorList = ['白' => 0, '藍' => 0];

            foreach ($computed_orders as $index => $order) {
                foreach ($sizeList as $spec => $value) {
                    $sizeList[$spec] += $order->sizeList[$spec];
                }
                foreach ($colorList as $spec => $value) {
                    $colorList[$spec] += $order->colorList[$spec];
                }
            }

            $today = today()->format('m-d');

            $data = [
                'type' => '學士',
                'preserve' => "已預約",
                'date' => $today,
                'orders_chunk' => $computed_orders->chunk(40),
                'sizeList' => $sizeList,
                'colorList' => $colorList,
                'year' => $year
            ];

            $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isFontSubsettingEnabled' => true])->setPaper('a4', 'potrait')->loadView('pdf/preserve_all', $data);

            $content = $pdf->download()->getOriginalContent();

            Storage::put('pdf/preseve/學士服已預約清單-' . $year . '年度-'.$today.'.pdf', $content);

            array_push($res, [
                    'filepath' => $disk->url('preseve/學士服已預約清單-' . $year . '年度-'.$today.'.pdf'),
                    'filename' => '學士服已預約清單-' . $year . '年度-'.$today.'.pdf'
                    ]
            );
        }

        // 碩士服
        $Master_start = TimeRange::getMasterReceiveStartTime();
        $Master_end = TimeRange::getMasterReceiveEndTime();
        $start = null;
        $end = null;

        if (today()->addDays(1) >= $Master_start) {
            $start = today()->addDays(1) > $Master_start ? $Master_start : today()->addDays(1);
            $end = today()->addDays(1) > $Master_end ? $Master_end : today()->addDays(1);
            while ($start <= $end) {
                $orders = Order::whereDate('preserve', '=', $start)->get();
                $orders = $orders->filter(function ($value, $key) {
                    return $value->owner->username[0] > "5" && $value->status_code === Order::code_paid;
                });
                $allOrders = $allOrders->merge($orders);
                $start->addDays(1);
            }

            $computed_orders = $this->preserveCount($allOrders, 1);

            $sizeList = ['M' => 0, 'L' => 0, 'XL' => 0];
            $colorList = ['白' => 0, '黃' => 0, '橘' => 0, '灰' => 0, '藍' => 0, '紫' => 0];

            foreach ($computed_orders as $index => $order) {
                foreach ($sizeList as $spec => $value) {
                    $sizeList[$spec] += $order->sizeList[$spec];
                }
                foreach ($colorList as $spec => $value) {
                    $colorList[$spec] += $order->colorList[$spec];
                }
            }


            $today = today()->format('m-d');

            $data = [
                'type' => '碩士',
                'preserve' => "已預約",
                'date' => $today,
                'orders_chunk' => $computed_orders->chunk(40),
                'sizeList' => $sizeList,
                'colorList' => $colorList,
                'year' => $year
            ];

            $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isFontSubsettingEnabled' => true])->setPaper('a4', 'potrait')->loadView('pdf/preserve_all', $data);

            $content = $pdf->download()->getOriginalContent();

            Storage::put('pdf/preseve/碩士服已預約清單-' . $year . '年度-'.$today.'.pdf', $content);

            array_push($res, [
                    'filepath' => $disk->url('preseve/碩士服已預約清單-' . $year . '年度-'.$today.'.pdf'),
                    'filename' => '碩士服已預約清單-' . $year . '年度-'.$today.'.pdf'
                    ]
            );
        }

        return $res;
    }

        /** 管理員的 "未預約" 清單**/
    public function nonePreservePdf()
    {
        $year = today()->year - 1911;
        if (today()->month <= 7) {
            $year -= 1;
        }
        
        $today = today()->format('m-d');

        $disk = Storage::disk('pdf');

        $res = [];

        $orders = Order::whereNull('preserve')->get();

        // 學士
        $B_orders = $orders->filter(function ($value, $key) {
            return $value->owner->username[0] < "5" && $value->status_code === Order::code_paid;
        });

        $computed_orders = $this->preserveCount($B_orders, 0);

        $sizeList = ['S' => 0, 'M' => 0, 'L' => 0, 'XL' => 0];
        $colorList = ['白' => 0, '藍' => 0];

        foreach ($computed_orders as $index => $order) {
            foreach ($sizeList as $spec => $value) {
                $sizeList[$spec] += $order->sizeList[$spec];
            }
            foreach ($colorList as $spec => $value) {
                $colorList[$spec] += $order->colorList[$spec];
            }
        }

        $data = [
            'type' => '學士',
            'preserve' => "未預約",
            'date' => $today,
            'orders_chunk' => $computed_orders->chunk(40),
            'sizeList' => $sizeList,
            'colorList' => $colorList,
            'year' => $year
        ];

        $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isFontSubsettingEnabled' => true])->setPaper('a4', 'potrait')->loadView('pdf/preserve_all', $data);

        $content = $pdf->download()->getOriginalContent();

        Storage::put('pdf/preseve/學士服未預約清單-' . $year . '年度-'.$today.'.pdf', $content);

        array_push($res, [
                'filepath' => $disk->url('preseve/學士服未預約清單-' . $year . '年度-'.$today.'.pdf'),
                'filename' => '學士服未預約清單-' . $year . '年度-'.$today.'.pdf'
                ]
        );

        // 碩士
        $M_orders = $orders->filter(function ($value, $key) {
            return $value->owner->username[0] > "5" && $value->status_code === Order::code_paid;
        });

        $computed_orders = $this->preserveCount($M_orders, 1);

        $sizeList = ['M' => 0, 'L' => 0, 'XL' => 0];
        $colorList = ['白' => 0, '黃' => 0, '橘' => 0, '灰' => 0, '藍' => 0, '紫' => 0];

        foreach ($computed_orders as $index => $order) {
            foreach ($sizeList as $spec => $value) {
                $sizeList[$spec] += $order->sizeList[$spec];
            }
            foreach ($colorList as $spec => $value) {
                $colorList[$spec] += $order->colorList[$spec];
            }
        }

        $data = [
            'type' => '碩士',
            'preserve' => "未預約",
            'date' => $today,
            'orders_chunk' => $computed_orders->chunk(40),
            'sizeList' => $sizeList,
            'colorList' => $colorList,
            'year' => $year
        ];

        $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isFontSubsettingEnabled' => true])->setPaper('a4', 'potrait')->loadView('pdf/preserve_all', $data);

        $content = $pdf->download()->getOriginalContent();

        Storage::put('pdf/preseve/碩士服未預約清單-' . $year . '年度-'.$today.'.pdf', $content);

        array_push($res, [
                'filepath' => $disk->url('preseve/碩士服未預約清單-' . $year . '年度-'.$today.'.pdf'),
                'filename' => '碩士服未預約清單-' . $year . '年度-'.$today.'.pdf'
                ]
        );

        return $res;
    }

    /** 已預約 + 未預約清單 合在一起送就不用在前端處理 **/
    public function getAllPreservePdf(){
        $preservePdf = $this->preservePdf();
        $preserveAllPdf = $this->preserveAllPdf();
        $nonePreservePdf = $this->nonePreservePdf();
        return [...$preservePdf, ...$preserveAllPdf, ...$nonePreservePdf];
    }

    /** 還款那頁的清單 **/
    public function refundPdf(Request $request)
    {
        $id = $request->id;
        if (!is_null($id)) {
            $list = CashierList::find($id);

            $state = ['meow', '尚未送出', '請款中', '已還款'];
            if (!is_null($list)) {

                foreach ($list->sets as $item => $set) {
                    $order = Order::find($set->order_id);
                    $set['document_id'] = $order->document_id;
                    $pos = -1;

                    foreach ($order->sets as $key => $value) {
                        if ($set->id === $value->id) {
                            $pos = $key + 1;
                            break;
                        }
                    }

                    if (count($order->sets) === 1) {
                        $pos = 0;
                    }

                    $set['return_id'] = $order->payment_id . '-' . $pos;
                }


                $year = today()->year - 1911;
                if (today()->month <= 7) {
                    $year -= 1;
                }

                $type = $list->type === 0 ? '學士' : '碩士';

                $margin = $list->type === 0
                    ? Config::getBachelorMarginPrice()
                    : Config::getMasterMarginPrice();

                $data = [
                    'list' => $list,
                    'margin' => $margin->value,
                    'sets_chunk' => $list->sets->chunk(35),
                    'state' => $state[$list->status],
                    'year' => $year,
                    'type' => $type
                ];
                $pdf = PDF::loadView('pdf/refund', $data)->setPaper('a4', 'potrait');

                return $pdf->stream($year . '學年度' . $type . '學位服還款清單-' . $list->id . '-' . $state[$list->status] . '.pdf');
            }
        }
        return abort(404);
    }

    /** 學生個人歸還單 **/
    public function returnPdf(Request $request)
    {
        if (Auth::check()) {
            $document_id = $request->document_id;
            $stu_id = $request->stu_id;
            if (!is_null($stu_id) && !is_null($document_id)) {
                if (Auth::user()->role === User::STUDENT && Auth::user()->username !== $stu_id) {
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

                    foreach ($order->sets as $key => $value) {
                        if ($set->id === $value->id) {
                            $pos = $key + 1;
                            break;
                        }
                    }

                    if (count($order->sets) === 1) {
                        $pos = 0;
                    }

                    $D_data = file_get_contents('picture/' . Config::getDepartmentStampFilename());
                    $A_data = file_get_contents('picture/' . Config::getAdminStampFilename());
                    $D_type = pathinfo('picture/' . Config::getDepartmentStampFilename(), PATHINFO_EXTENSION);
                    $A_type = pathinfo('picture/' . Config::getAdminStampFilename(), PATHINFO_EXTENSION);

                    $return_location = Config::getReturnLocationValue();

                    $data = [
                        'set' => $set,
                        'payment_id' => $order->payment_id,
                        'document_id' => $order->document_id,
                        'pos' => $pos,
                        'department_stamp' => 'data:image/' . $D_type . ';base64,' . base64_encode($D_data),
                        'admin_stamp' => 'data:image/' . $A_type . ';base64,' . base64_encode($A_data),
                        'return_time' => TimeRange::find(TimeRange::RET),
                        'return_location' => $return_location,
                        'check_code' => Str::random(5)
                    ];

                    $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isFontSubsettingEnabled' => true])->setPaper('a4', 'potrait')->loadView('pdf/return', $data);

                    return $pdf->stream('歸還證明單-' . $set->student->username . '.pdf');
                }
            }
            return abort(404);
        }
        return abort(403);
    }


    /** 匯出訂單用 **/
    public function find_sets($order) {
        $res = [];

        foreach ($order->sets as $pos => $set) {

            $status_code = [
                (string)(Order::code_created) => "未付款",
                (string)(Order::code_paid) => "已付款",
                (string)(Order::code_received) => "未歸還",
                (string)(Order::code_returned) => "已歸還",
                (string)(Order::code_refunded) => "已還款",
                (string)(Order::code_canceled) => "已取消"
            ];

            if ($set->refund) {
                $status = "已還款";
            } else if (!empty($set->returned)) {
                $status = "已歸還";
            } else {
                $status = $status_code[$order->status_code];
            }

            $add = $order->sets->count() > 1 ? 1 : 0;


            $return_id = null;
            if(!(is_null($set->list_id))) {
                $return_id = $order->payment_id . '-' . ($pos+$add);
            }

            $x = [
                'student_id' => $set->student->username,
                'name' => $set->student->name,
                'class' => $set->student->school_class->class_name,
                'size' => $set->cloth->spec,
                'color' => $set->accessory->spec,
                'document_id'=> $order->document_id,
                'payment_id' => $order->payment_id,
                'return_id' => $return_id,
                'batch_id' => $set->list_id,
                'status' => $status
            ];
            array_push($res, $x);
        }

        return $res;
    }
    
    /** 匯出全部訂單 
     * type: 0:學士 1:碩士
     * **/
    public function exportPdf(Request $request){
        
        $type = $request->type;

        $list = collect([]);
        if ($type == 1){
            $orders = Order::all()->filter(function ($value, $key) {
                return $value->owner->username[0] > "5";
            });
        } else {
            $orders = Order::all()->filter(function ($value, $key) {
                return $value->owner->username[0] < "5";
            });
        }

        foreach ($orders as $order){
            $sets = $this->find_sets($order);
            $list = $list->merge($sets);
        }


        $list = $list->sortBy('status')->values();

        // return $list;

        $year = today()->year - 1911;
        if (today()->month <= 7) {
            $year -= 1;
        }

        $data = [
            'type' => $type == 1 ? '碩士' : '學士',
            'list' => $list,
            'list_chunk' => $list->chunk(45),
            'year' => $year,
        ];


        $pdf = PDF::loadView('pdf/export_orders', $data)->setPaper('a4', 'potrait');

        return $pdf->stream($type == 1 ? '碩士' : '學士' . today()->format('Y-m-d-') . Str::random(5) . '.pdf');
    }
}
