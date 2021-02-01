<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchOwnerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {

        if(Auth::user()->role === User::STUDENT){
            $find_set = Set::where('student_id', Auth::user()->id);
            if ($find_set->count() === 0) {
                return abort(404);
            }

            $owner = Order::findOrFail($find_set->first()->order_id)->owner;
            $hidden = array_keys($owner->toArray());
            return $owner->makeHidden($hidden)->makeVisible(['name', 'username', 'school_class', 'email']);
        }

        return abort(404);
    }
}
