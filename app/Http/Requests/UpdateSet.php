<?php

namespace App\Http\Requests;

use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateSet extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->isRole(User::ADMIN))
            return true;
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

        return [
            'set_id' => [
                'required',
                'exists:sets,id',
            ],
            'cloth_id' => [
                'required',
                'exists:items,id',
                function ($attribute, $value, $fail) use ($request) {
                    if (!in_array($value, Item::clothIds())) {
                        $fail(__('validation.item_set_wrong'));
                    }
                },
                function ($attribute, $value, $fail) {
                    $item = Item::find($value);
                    if ($item->remainQuantity - $value < 0)
                        $fail(__('validation.item_not_enough'));
                },
            ],
            'accessory_id' => [
                'required',
                'exists:items,id',
                function ($attribute, $value, $fail) use ($request) {
                    if (!in_array($value, Item::accessoryIds())) {
                        $fail(__('validation.item_set_wrong'));
                    }
                },
                function ($attribute, $value, $fail) {
                    $item = Item::find($value);
                    if ($item->remainQuantity - $value < 0)
                        $fail(__('validation.item_not_enough'));
                },
            ]
        ];
    }
}
