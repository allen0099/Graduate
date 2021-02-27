<?php

namespace App\Http\Requests;

use App\Models\Item;
use App\Models\Order;
use App\Models\Set;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $order_id = $this->order;
        $order = Order::find($order_id);

        if (Auth::check()) {
            if (Auth::user()->isRole(User::STUDENT) && (Auth::id() !== $order->owner->id))
                return false;
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();
        $order = Order::find($this->order);
        $request = $this;

        if ($user->isRole(User::STUDENT)) {
            return [
                'document_id' => [
                    'required',
                    Rule::unique('orders', 'document_id')
                        ->ignore($order->document_id, 'document_id'),
                    'exists:orders,document_id', // student update check
                ],
                'owner_username' => [
                    'required',
                    'exists:users,username',
                    Rule::unique('users', 'username')
                        ->ignore($user->id, 'id'), // student update check
                ],
                'status_code' => [
                    'required',
                    Rule::in([
                        Order::code_canceled,
                    ]),
                    function ($attribute, $value, $fail) use ($request) {
                        // todo: change fail, or not changed code
                        $order = Order::where('document_id', $request->document_id)->first();
                        if (!is_null($order) && $order->status_code === Order::code_canceled)
                            $fail(__('validation.order_canceled'));
                    },
                ],
                'sets.*.set_owner' => [
                    'distinct',
                    'exists:users,username',
                    function ($attribute, $value, $fail) use ($request) {
                        $user = User::where('username', $value)->first();
                        $stu_ids = Set::getHaveSetIds();

                        $order = Order::where('document_id', $request->document_id)->first();
                        if (!is_null($order)) {
                            $sets = $order->sets;
                            $set_ids = $sets->map->only('student_id')->flatten()->all();

                            $other_ids = array_diff($stu_ids, $set_ids);

                            if (in_array($user->id, $other_ids)) {
                                $fail(__('validation.student_had_set'));
                            }
                        }
                    },
                ],
                'sets.*.accessory' => [
                    'exists:items,id',
                    function ($attribute, $value, $fail) use ($request) {
                        // $index = explode('.', $attribute)[1];

                        // $username = $request->sets[$index]['set_owner'];

                        // $user = User::where('username', $username)->first();
                        // $school_class = $user->school_class;

                        // $accessory = Item::find($value);

                        // if (!is_null($school_class->default_color) && $accessory->spec !== $school_class->default_color) {
                        //   $fail(__('validation.color_not_match'));
                        // }

                        if (!in_array($value, Item::accessoryIds())) {
                            $fail(__('validation.item_set_wrong'));
                        }
                    },
                    function ($attribute, $value, $fail) use ($request) {
                        $sets = $request->sets;
                        $return = array();
                        array_walk($sets, function ($a) use (&$return) {
                            $return[] = $a['accessory'];
                            $return[] = $a['cloth'];
                        });
                        foreach (array_count_values($return) as $key => $value) {
                            $item = Item::find($key);
                            if ($item->remainQuantity - $value < 0)
                                $fail(__('validation.item_not_enough'));
                        }
                    },
                ],
                'sets.*.cloth' => [
                    'exists:items,id',
                    function ($attribute, $value, $fail) use ($request) {
                        if (!in_array($value, Item::clothIds())) {
                            $fail(__('validation.item_set_wrong'));
                        }
                    },
                    function ($attribute, $value, $fail) use ($request) {
                        $sets = $request->sets;
                        $return = array();
                        array_walk($sets, function ($a) use (&$return) {
                            $return[] = $a['accessory'];
                            $return[] = $a['cloth'];
                        });
                        foreach (array_count_values($return) as $key => $value) {
                            $item = Item::find($key);
                            if ($item->remainQuantity - $value < 0)
                                $fail(__('validation.item_not_enough'));
                        }
                    },
                ],
            ];
        }
        if ($user->isRole(User::ADMIN)) {
            return [
                'document_id' => [
                    'required',
                    Rule::unique('orders', 'document_id')
                        ->ignore($order->document_id, 'document_id'),
                ],
                'payment_id' => Rule::unique('orders', 'payment_id')
                    ->ignore($order->payment_id, 'payment_id'),
                'owner_username' => [
                    'required',
                    'exists:users,username',
                ],
                'status_code' => [
                    'required',
                    Rule::in([
                        Order::code_created,
                        Order::code_paid,
                        Order::code_received,
                        Order::code_returned,
                        Order::code_canceled,
                        Order::code_refunding,
                        Order::code_refunded,
                    ]),
                ],
                'sets.*.set_owner' => [
                    'distinct',
                    'exists:users,username',
                    function ($attribute, $value, $fail) use ($request) {
                        $user = User::where('username', $value)->first();
                        $stu_ids = Set::getHaveSetIds();

                        $order = Order::where('document_id', $request->document_id)->first();
                        if (!is_null($order)) {
                            $sets = $order->sets;
                            $set_ids = $sets->map->only('student_id')->flatten()->all();

                            $other_ids = array_diff($stu_ids, $set_ids);

                            if (in_array($user->id, $other_ids)) {
                                $fail(__('validation.student_had_set'));
                            }
                        }
                    },
                ],
                'sets.*.accessory' => [
                    'exists:items,id',
                    function ($attribute, $value, $fail) use ($request) {
                        // $index = explode('.', $attribute)[1];

                        // $username = $request->sets[$index]['set_owner'];

                        // $user = User::where('username', $username)->first();
                        // $school_class = $user->school_class;

                        // $accessory = Item::find($value);

                        // if (!is_null($school_class->default_color) && $accessory->spec !== $school_class->default_color) {
                        //   $fail(__('validation.color_not_match'));
                        // }

                        if (!in_array($value, Item::accessoryIds())) {
                            $fail(__('validation.item_set_wrong'));
                        }
                    },
                ],
                'sets.*.cloth' => [
                    'exists:items,id',
                    function ($attribute, $value, $fail) use ($request) {
                        if (!in_array($value, Item::clothIds())) {
                            $fail(__('validation.item_set_wrong'));
                        }
                    },
                ],
            ];
        }
    }
}
