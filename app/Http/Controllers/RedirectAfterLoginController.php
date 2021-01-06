<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAfterLoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if (Auth::user()->role === User::ADMIN) {
            return redirect('/admin/home');
        } else if (Auth::user()->role === User::STUDENT) {
            return redirect('/student/myorder');
        }
        return redirect('/');
    }
}
