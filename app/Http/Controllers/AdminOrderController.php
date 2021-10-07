<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Rap2hpoutre\FastExcel\FastExcel;

class AdminOrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function __invoke(Request $request)
    {
        $search = $request->search;

        return Inertia::render('Admin/Order/Show', ['search' => $search]);
        // return $result;
    }

    public function getOrderByState(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        Log::info("[Log::getOrderByState]", [
            'ip' => $request->ip(),
            'username' => Auth::user() ? Auth::user()->username : 'who_are_you'
        ]);

        if ($search !== null && $search !== 'null'){
            $find_user = User::where('username', $search);
            $find_orders = Order::withTrashed()->where('document_id', $search)->orWhere('payment_id', $search);
            if ($find_user->count() === 0 && $find_orders->count() === 0){
                return abort(404);
            }

            if ($find_user->count() > 0) {
                $find_set = Set::where('student_id', $find_user->first()->id);

                if($find_set->count() > 0){
                    $tmp = Order::withTrashed()->where('id', $find_set->first()->order_id);
                    $result = $tmp;
                } else {
                    return abort(404);
                }
            }

            if ($find_orders->count() > 0) {
                $result = $find_orders;
            }
            if ($status > 0 && $status <= 6) {
                $result = $result->where('status_code', $status)->orderBy('updated_at', 'desc')->paginate(20);
            } else {
                $result = $result->orderBy('updated_at', 'desc')->paginate(20);
            }

        } else {
            if ($status > 0 && $status < 6) {
                $result = Order::where('status_code', $status)->orderBy('updated_at', 'desc')->paginate(20);
            } else if ($status == 6) {
                if (Auth::user()->isRole(User::ADMIN)) {
                    $result = Order::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(20);
                }
            } else {
                $result = Order::orderBy('updated_at', 'desc')->paginate(20);
            }
        }

        Log::info("[Log::getOrderByState::SUCCESS]", [
            'ip' => $request->ip(),
            'username' => Auth::user() ? Auth::user()->username : 'who_are_you',
            'search' => ($search !== null && $search !== 'null') ? $request->search : 'null',
            'status' => $request->status,
        ]);
        
        return $result;
    }

    public function cancelAllUnpaidOrder(Request $request)
    {
        Log::info("[Log::cancelAllUnpaidOrder]", [
            'ip' => $request->ip(),
            'username' => Auth::user() ? Auth::user()->username : 'who_are_you'
        ]);

        if ($request->check !== '刪除') {
            Log::info("[Log::cancelAllUnpaidOrder::FAIL]", [
                'ip' => $request->ip(),
                'username' => Auth::user() ? Auth::user()->username : 'who_are_you',
                'msg' => 'not have check',
            ]);
            return abort(403);
        }

        $orders = Order::where('status_code', Order::code_created)->get();

        $total = $orders->count();


        foreach ($orders as $order) {
            $order->status_code = Order::code_canceled;
            $order->save();

            $order->sets()->delete();
            $order->delete();
        }

        Log::info("[Log::cancelAllUnpaidOrder:SUCCESS]", [
            'ip' => $request->ip(),
            'username' => Auth::user() ? Auth::user()->username : 'who_are_you',
            'total' => $total
        ]);

        return response()->noContent();
    }


    public function replace_character($str){
        $illegal = array("'", '"', "=", "`", "|", "?", "/", "\\", "&", "|", ";");
        $new_str = str_replace($illegal, "", $str);
        return $new_str;
    }


    public function find_sets($order) {
        $res = collect([]);

        foreach ($order->sets as $set){
            
            $status_code = [
                (string)(Order::code_created) => "未付款",
                (string)(Order::code_paid) => "已付款，未領取衣服",
                (string)(Order::code_received) => "未歸還衣服",
                (string)(Order::code_returned) => "已歸還衣服",
                (string)(Order::code_refunded) => "已還款",
                (string)(Order::code_canceled) => "已取消"
            ];

            $x = [
                '學位' => $set->student->username[0] < "5" ? '學士' :'碩士',
                '學號' => $this->replace_character($set->student->username),
                '姓名' => $this->replace_character($set->student->name),
                '系級' => $this->replace_character($set->student->school_class->class_name),
                '尺寸' => $this->replace_character($set->cloth->spec),
                '顏色' => $this->replace_character($set->accessory->spec),
                '訂單編號'=> $this->replace_character($order->document_id), 
                '付款單據編號' => $this->replace_character($order->payment_id), 
                '訂單狀態' => $this->replace_character($status_code[$order->status_code])
            ];

            $res->push($x);
        }

        return $res;
    }

    public function exportAllOrdersToExcel(Request $request){

        $list = collect([]);

        $orders = Order::orderBy('status_code')->get();

        foreach ($orders as $order){
            $sets = $this->find_sets($order);
            $list = $list->merge($sets);
        }

        return (new FastExcel($list))->download('學位服名單-' . today()->format('Y-m-d-') . Str::random(5) . '.xlsx');
    }
}
