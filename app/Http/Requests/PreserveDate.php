<?php

namespace App\Http\Requests;

use App\Models\Order;
use App\Models\TimeRange;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isNull;

class PreserveDate extends FormRequest
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
        $order = Order::where('document_id', $this->order_id)->first();
        $bt = TimeRange::find(TimeRange::BORROW_TIME);
        return [
            'order_id' => [
                'required',
                'exists:orders,document_id'
            ],
            'preserve_date' => [
                'required',
                'after_or_equal:' . today()->addDays(2) > $bt->start_time
                    ? today()->addDays(2)
                    : $bt->start_time,
                'before_or_equal:' . ($order->owner->isBachelor()
                    ? TimeRange::getBachelorReturnEndTime()
                    : TimeRange::getMasterReturnEndTime()),
            ],
        ];
    }
}
