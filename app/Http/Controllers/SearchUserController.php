<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
                ->with(['set', 'orders']);

            if ($find_user->count() === 0) {
                return abort(404);
            }

            $user = $find_user->first();

            return $user;
        }

        return abort(404);
    }
}
