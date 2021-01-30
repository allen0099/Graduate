<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchUserController extends Controller
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

        if (!is_null($search)) {
            $find_user = User::where('username', $search)
                ->with(['set']);

            if ($find_user->count() === 0) {
                return abort(404);
            }

            $user = $find_user->first();

            if (Auth::user()->role === User::ADMIN) {
                return $user;
            } else {
                $attributes = array_keys($user->toArray());
                unset($user->set->student);
                return $user->makeHidden($attributes)->makeVisible(['name', 'username', 'school_class', 'set']);
            }
        }

        return abort(404);
    }
}
