<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CheckOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $order = Order::where('document_id', $this->order_id);

        if (is_null($order))
            return false;
        if (Auth::user()->isRole(User::ADMIN))
            return true;
        if (Auth::user()->isRole(User::STUDENT)) {
            return (Auth::id() !== $order->first()->owner->id)
                ? false
                : true;
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
        return [
            'order_id' => ['required', 'exists:orders,document_id'],
        ];
    }
}
