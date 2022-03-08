<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewAdminCheck;
use App\Http\Requests\NewStudentCheck;
use App\Jobs\ChangeStudentPassword;
use App\Models\CashierList;
use App\Models\Department;
use App\Models\DepartmentClass;
use App\Models\OldClass;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\Facades\FastExcel;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function updateUser(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'name' => ['required'],
            'class_id' => ['required'],
            'payment_check_status' => ['required'],
            'phone' => ['digits:10'],
        ]);

        $id = $request->id;
        $name = $request->name;
        $class_id = $request->class_id;
        $payment_check_status = $request->payment_check_status;
        $phone = $request->phone;

        if (!is_null($id)) {
            if (Auth::user()->isRole(User::ADMIN)) {
                $user = User::find($id);

                if ($user->isRole(User::ADMIN)) {
                    $user->forceFill([
                        'name' => $name,
                    ])->save();
                } else {
                    $d_class = DepartmentClass::all()
                        ->where('class_id', $class_id)->first();

                    $user->forceFill([
                        'name' => $name,
                        'class_id' => $d_class->id,
                        'payment_check_status' => $payment_check_status,
                        'phone' => $phone,
                    ])->save();


                }


                Log::info("[Log::updateUser]", [
                    'update' => $user->username,
                    'ip' => $request->ip(),
                    'username' => Auth::user()->username
                ]);

                return response()->noContent();
            } else {
                return abort(403);
            }
        }
        return abort(404);
    }

    public function adminList()
    {
        if (Auth::user()->isRole(User::ADMIN)) {
            $admins = User::where('role', User::ADMIN)->get();
            return $admins;
        }
        return abort(403);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'id' => ['required'],
        ]);

        $id = $request->id;

        if (!is_null($id)) {
            if (Auth::user()->isRole(User::ADMIN)) {
                $user = User::find($id);

                $password = $user->isRole(User::ADMIN)
                    ? '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
                    : Hash::make(substr($user->username, -6));

                $user->forceFill([
                    'password' => $password,
                ])->save();


                Log::info("[Log::resetPassword]", [
                    'reset who' => $user->username,
                    'ip' => $request->ip(),
                    'username' => Auth::user()->username
                ]);

                return response()->noContent();
            } else {
                return abort(403);
            }
        }
        return abort(404);
    }

    public function uploadStudentList(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'mimes:csv,txt', 'max:5000'],
        ]);

        $path = $request->file('csv_file')->storeAs('', 'student.csv', 'public');
        $fp = Storage::disk('public')->get($path);

        Log::info("[Log::uploadStudentList]", [
            'info' => 'Upload started!',
            'ip' => $request->ip(),
            'username' => Auth::user()->username
        ]);

        mb_detect_order('ASCII,UTF-8,BIG-5');
        $encode = mb_detect_encoding($request->file('csv_file')->getContent());

        Log::info("[Log::uploadStudentList]", [
            'info' => "Encoding: $encode",
            'ip' => $request->ip(),
            'username' => Auth::user()->username
        ]);

        $fp_utf8 = mb_convert_encoding($fp, 'UTF-8', $encode);
        Storage::disk('public')->put($path, $fp_utf8);

        $firstLine = preg_split('/\r\n|\r|\n/', $fp_utf8)[0];
        $check = str_contains($firstLine, '系年班代碼');

        Log::info("[Log::uploadStudentList]", [
            'info' => "First Line: $check",
            'ip' => $request->ip(),
            'username' => Auth::user()->username
        ]);

        Log::info("[Log::uploadStudentList]", [
            'info' => 'Clear started!',
            'ip' => $request->ip(),
            'username' => Auth::user()->username
        ]);

        DepartmentClass::all()
            ->each(function ($origin_data) {
                $oc = OldClass::where('class_id', $origin_data->class_id)->first();

                if (!is_null($oc)) {
                    $oc->delete();
                }

                $nc = $origin_data->replicate();
                $nc->setTable('old_classes');
                $nc->save();

                $origin_data->delete();
            });

        CashierList::all()->each(fn($o) => $o->delete()->save());

        Log::info("[Log::uploadStudentList]", [
            'info' => 'Clear ended!',
            'ip' => $request->ip(),
            'username' => Auth::user()->username
        ]);

        $fsExcel = FastExcel::configureCsv(',', '"', '\n', 'UTF-8');

        if (!$check) {
            $fsExcel->withoutHeaders();
        }

        Log::info('fast excel');
        $fsExcel->import(Storage::disk('public')->path($path), function ($row) {
            $time = microtime(true);
            $cid = trim($row['系年班代碼'] ?? $row[0]);
            $cname = trim($row['系年班簡稱'] ?? $row[1]);
            $uid = trim($row['學號'] ?? $row[2]);
            $uname = trim($row['姓名'] ?? $row[3]);
            Log::debug('!!!Row setup!!!', [
                'time' => microtime(true) - $time,
                'row' => $row,
            ]);

            $func_time = microtime(true);
            if (is_null(DepartmentClass::where('class_id', $cid)->first())) {
                $department = Department::firstOrCreate(
                    ['department_id' => substr($cid, 0, 4)],
                    // regex remove (?:(?:(?:在職|碩士|碩專)班)|[ＡＢＣＤＥＦＧ]|[一二三四五六七八九]|進學班?)
                    ['name' => substr($cname, 0, 6)]
                );

                $old = OldClass::where('class_id', $cid)->firstOrCreate(
                    ['class_id' => $cid],
                    ['department_id' => $department->id, 'class_name' => $cname]
                );

                DepartmentClass::create([
                    'department_id' => $department->id,
                    'class_id' => $cid,
                    'class_name' => $cname,
                    'default_color' => $old->default_color,
                ]);
            }
            Log::debug('=> check department done', ['time' => microtime(true) - $func_time]);

            $func_time = microtime(true);
            if (is_null(User::where('username', $uid)->first())) {
                $time = microtime(true);
                $email = $uid . '@gms.tku.edu.tw';
                Log::debug('build email', ['time' => microtime(true) - $time]);

                $time = microtime(true);
                $pwd = '';
                Log::debug('build pwd', ['time' => microtime(true) - $time]);

                $time = microtime(true);
                $ccid = DepartmentClass::where('class_id', $cid)->first()->id;
                Log::debug('get ccid', ['time' => microtime(true) - $time]);

                $time = microtime(true);
                $user = User::create([
                    'name' => $uname,
                    'username' => $uid,
                    'email' => $email,
                    'password' => $pwd,
                    'role' => User::STUDENT,
                    'class_id' => $ccid,
                ]);
                Log::debug('build user', ['time' => microtime(true) - $time]);

                $time = microtime(true);
                ChangeStudentPassword::dispatch($user);
                Log::debug('send dispatch', ['time' => microtime(true) - $time]);
            }
            Log::debug('=> check user done', ['time' => microtime(true) - $func_time]);
            return null;
        });

        return response()->noContent();
    }

    public function updateAdminStamp(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'required' => '不能沒有圖檔',
            'image' => '不能為非圖檔類型',
        ]);

        $user = User::find(Auth::id());
        $disk = Storage::disk('picture');

        if ($disk->exists($user->stamp)) {
            $disk->delete($user->stamp);
        }

        $filename = $request->file('image')->store('', 'picture');
        $user->stamp = $filename;
        $user->save();
        return response()->noContent();
    }

    public function searchUser(Request $request)
    {
        $search = $request->search;

        if (!is_null($search)) {
            $find_user = User::where('username', $search);

            if ($find_user->count() === 0) {
                return abort(404);
            }

            $user = $find_user->first();

            if (Auth::user()->isRole(User::STUDENT)) {
                if (!is_null($user->set)) {
                    unset($user->set->student);
                }

                return $user->makeHidden(array_keys($user->toArray()))->makeVisible(['name', 'username', 'school_class',
                'set', 'payment_check_status']);
            } else if (Auth::user()->isRole(User::ADMIN)) {
                if (!is_null($user->set)) {
                    unset($user->set->student);
                }
                return $user->makeVisible(['phone']);
            }
            return abort(403);
        }
        return abort(404);
    }

    public function addNewStudent(NewStudentCheck $request)
    {
        $request->validated();

        $d_class = DepartmentClass::all()
            ->where('class_id', $request->class_id)->first();

        $user = new User();
        $user->forceFill([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->username . '@gms.tku.edu.tw',
            'password' => Hash::make(substr($request->username, -6)),
            'role' => User::STUDENT,
            'class_id' => $d_class->id,
        ])->save();

        return $user;
    }

    public function addNewAdmin(NewAdminCheck $request)
    {
        $request->validated();

        $user = new User();
        $user->forceFill([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->username . '@admin.email',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'role' => User::ADMIN,
        ])->save();

        return $user;
    }

    public function uploadPayments(Request $request)
    {
        $request->validate([
            'csv_file' => ['required', 'mimes:csv,txt', 'max:5000'],
        ]);

        $path = $request->file('csv_file')->storeAs('', Str::random(16).'.csv', 'public');
        $fp = Storage::disk('public')->get($path);

        Log::info("[Log::uploadPayments]", [
            'info' => 'Upload started!',
            'ip' => $request->ip(),
            'username' => Auth::user()->username
        ]);

        mb_detect_order('ASCII,UTF-8,BIG-5');
        $encode = mb_detect_encoding($request->file('csv_file')->getContent());

        Log::info("[Log::uploadPayments]", [
            'info' => "Encoding: $encode",
            'ip' => $request->ip(),
            'username' => Auth::user()->username
        ]);

        $fp_utf8 = mb_convert_encoding($fp, 'UTF-8', $encode);
        Storage::disk('public')->put($path, $fp_utf8);

        $firstLine = preg_split('/\r\n|\r|\n/', $fp_utf8)[0];
        $check = str_contains($firstLine, '繳費單編號');

        Log::info("[Log::uploadPayments]", [
            'info' => "First Line: $check",
            'ip' => $request->ip(),
            'username' => Auth::user()->username
        ]);

        $fsExcel = FastExcel::configureCsv(',', '"', '\n', 'UTF-8');

        if (!$check) {
            $fsExcel->withoutHeaders();
        }

        Log::info('fast excel');


        $fail = [];
        $succeed = [];

        $fsExcel->import(Storage::disk('public')->path($path), function ($row) use (&$fail, &$succeed) {
            try {
                $time = microtime(true);
                $payment_id = trim($row['繳費單編號'] ?? $row[0]);
                $money = trim($row['收費金額'] ?? $row[3]);
                $date = trim($row['繳費日期'] ?? $row[4]);
                $stuname = trim($row['繳款人'] ?? $row[5]);
                $student_id = explode("-", $stuname)[0];
                $student_name = explode("-", $stuname)[1];
                $phone = trim($row['聯絡電話'] ?? $row[6]);
                $state = trim($row['繳費狀態'] ?? $row[7]);

                if(!strlen($payment_id) or !strlen($money) or !strlen($stuname)) {
                    Log::info("[Log::uploadPayments]", [
                    'info' => "Error: 發生不明錯誤，請檢察檔案是否有缺失!",
                    ]);
                    array_push($fail, "發生不明錯誤，請檢察檔案是否有缺失! 繳費號 ".$payment_id);
                    return;
                }

            } catch (\Exception $e) {
                Log::info("[Log::uploadPayments]", [
                    'info' => "Error: $e",
                ]);
                array_push($fail, "發生不明錯誤，請檢察檔案是否有缺失!");
                return;
            }
            Log::debug('[Log::uploadPayments] => !!!Row setup!!!', [
                'time' => microtime(true) - $time,
                'row' => [
                    'payment_id' => $payment_id,
                    'money' => $money,
                    'date' => $date,
                    'username' => $student_id,
                    'name' => $student_name,
                    'phone' => $phone,
                    'state' => $state,
                ],
            ]);
            $real_integer = filter_var($money, FILTER_SANITIZE_NUMBER_INT);

            $find_owner = User::where('username', $student_id);
            if ($find_owner->count() > 0) {
                $user = $find_owner->first();
                $find_order = $find_owner->first()->orders()->get();
                if ($find_order->count() === 0) {
                    Log::debug('[Log::uploadPayments] order => 沒有訂單', [
                        'username' => $student_id,
                    ]);
                    $msg = $user->name.'('.$user->username.') 沒有訂單';
                    array_push($fail, $msg);
                } else {
                    $order = $find_order->first();
                    if(is_null($order->payment_id)) {
                        if($real_integer >= $order->total_price) {
                            $order->forceFill([
                                'status_code' => Order::code_paid,
                                'payment_id' => $payment_id
                            ])->save();
                            
                            $user->forceFill([
                                'phone' => $phone
                            ])->save();

                            Log::debug('[Log::uploadPayments] order => 更新訂單', [
                                'document_id' => $order->document_id,
                                'payment_id' => $payment_id,
                                'username' => $student_id,
                            ]);
                            $msg = $user->name.'('.$user->username.') 訂單 '.$order->document_id.' 更新付款資訊 '.$payment_id;
                            array_push($succeed, $msg);
                        } else {
                            $msg = $user->name.'('.$student_id.') 訂單 '.$order->document_id.' 付款金額不足 '.($real_integer - $order->total_price);
                            array_push($fail, $msg);
                        }
                    } else {
                        Log::debug('[Log::uploadPayments] order => 訂單已存在付款資訊', [
                            'username' => $student_id,
                        ]);
                        $msg = $user->name.'('.$user->username.') 訂單 '.$order->document_id.' 已存在付款資訊 '.$order->payment_id;
                        array_push($fail, $msg);
                    }
                }
            } else {
                Log::debug('[Log::uploadPayments] order => 沒有找到此學生', [
                    'username' => $student_id,
                ]);
                $msg = $student_name.'('.$student_id.') 沒有找到此學生';
                array_push($fail, $msg);
            }

            return;
        });
        
        Log::debug('[Log::uploadPayments] => upload done');

        return ['fail' => $fail, 'succeed' => $succeed];
    }
}
