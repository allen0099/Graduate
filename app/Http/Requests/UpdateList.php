<?php

namespace App\Http\Requests;

use App\Models\CashierList;
use App\Models\TimeRange;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateList extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'exists:lists,id'],
            'status' => ['required', Rule::in(array_merge(CashierList::CODE_ARRAY, [0]))],
        ];
    }
}
