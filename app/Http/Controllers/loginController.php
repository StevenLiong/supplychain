<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function home()
    {
        if (Auth::check()) {
            if (Auth()->user()->id_role == 1)
                return redirect('/logistic');
            else if (Auth::user()->id_role == 2)
                return redirect('/BOM_V2/IndexBom');
            else if (Auth::user()->id_role == 3)
                return redirect('/standardized_work/home');
            else if (Auth::user()->id_role == 4)
                return redirect('resource_work_planning/dashboard');
            else if (Auth::user()->id_role == 5)
                return redirect('materialrequest/dashboard');
            else if (Auth::user()->id_role == 6)
                return redirect('purchaseorder/dashboard');
            else if (Auth::user()->id_role == 7)
                return redirect('/BOM/IndexBom');
        }

        return redirect('/login');
    }

    public function login(){

        return view('auth.login');
    }

    public function verifyLogin(Request $request)
    {
        $field = $request->input('email');
        $password = $request->input('password');

        // Coba login berdasarkan email
        if (Auth::attempt(['email' => $field, 'password' => $password])) {
            // Jika berhasil login berdasarkan email
            if (Auth::user()->id_role == 1)
                return redirect('/logistic');
            else if (Auth::user()->id_role == 2)
                return redirect('/BOM_V2/IndexBom');
            else if (Auth::user()->id_role == 3)
                return redirect('/standardized_work/home');
            else if (Auth::user()->id_role == 4)
                return redirect('resource_work_planning/dashboard');
            else if (Auth::user()->id_role == 5)
                return redirect('/materialrequest');
            else if (Auth::user()->id_role == 6)
                return redirect('/purchaseorder');
            else if (Auth::user()->id_role == 7)
                return redirect('/BOM/IndexBom');
        }



        // Jika kedua percobaan di atas gagal, kembalikan ke halaman login
        return back()->with(['error' => 'Email/username & Password yang anda masukan salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}