<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginRedirectConroller extends Controller
{
    public  function redirectTo() 
    {
        if (Auth::user()->role === User::ADMIN) {
            
            return redirect('/admin/home');
        } else if (Auth::user()->role === User::STUDENT) {
            return redirect('/student/myorder');
        }
        return redirect('/');
    }
}