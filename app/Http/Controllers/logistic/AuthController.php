<?php

namespace App\Http\Controllers\logistic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
        return view('logistic.auth.login');
    }

    public function register(){
        return view('logistic.auth.register');
    }
    
}
