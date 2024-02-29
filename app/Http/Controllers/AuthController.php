<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('dangnhap');
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        $user = User::where('email', $credentials['email'])->first();
        if ($user && Hash::check( $request->input('password'), $user->password)) {
            Session::put('user', $user);
            return redirect('/');
        } else {
            // Đăng nhập không thành công
            return redirect()->back()->withErrors('Email hoặc mật khẩu không đúng');
        }
    }

    public function logout()
    {
        Session::forget('user');
        return view('dangnhap');
    }
}
