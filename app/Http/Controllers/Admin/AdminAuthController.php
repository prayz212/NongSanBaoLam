<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function index() {
        try {
            if (Auth::guard('admin')->check()) {
                return redirect()->route('dashboard');
            }
            return view('admin.login-page');
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function login(LoginRequest $request) {
        try {
            //check if the user logged in as an customer => logout it
            if (Auth::guard('web')->check()) {
                Auth::guard('web')->logout();
            }

            $result = Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], true);
            if ($result) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->withInput()->with('login-error', 'Tên tài khoản/Mật khẩu không đúng');
            }
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }

    public function logout() {
        try {
            Auth::guard('admin')->logout();
            return redirect()->route('adminLogin');
        }
        catch(\Exception $error){
            return view('error')
                ->with('errorMessages', $error->getMessage())
                ->with('returnUrl', url()->previous());
        }
    }
}
