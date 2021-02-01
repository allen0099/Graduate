<?php

namespace App\Http\Requests;

use App\Models\Item;
use App\Models\Set;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'username' => [
                'required',
                'exists:users,username',
                function ($attribute, $value, $fail) use ($request) {
                    $user = $request->user();
                    if ($user->role !== User::ADMIN && $user->username !== $value) {
                        $fail($attribute . ' not match.');
                    }
                },
            ],
            'sets' => 'required',
            'sets.*.set_owner' => [
                'required',
                'distinct',
                'exists:users,username',
                function ($attribute, $value, $fail) use ($request) {
                    $user = User::where('username', $value)->first();
                    $stu_ids = Set::getHaveSetIds();

                    if (in_array($user->id, $stu_ids)) {
                        $fail(__('validation.student_had_set'));
                    }
                },
            ],
            'sets.*.accessory' => [
                'exists:items,id',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];

                    $username = $request->sets[$index]['set_owner'];

                    $user = User::where('username', $username)->first();
                    $school_class = $user->school_class;

                    $accessory = Item::find($value)->first();

                    if (!is_null($school_class->default_color) && $accessory->spec !== $school_class->default_color) {
                        $fail(__('validation.color_not_match'));
                    }

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
}
