<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class AuthController extends Controller
{
    public function index() {
        if (Auth::check()) {
            return redirect()->route('infopage');
        }
        return view('client.authenticate-page');
    }

    public function login(LoginRequest $request) {
        $result = Auth::attempt(['username' => $request->username, 'password' => $request->password], true);
        if ($result) {
            return redirect()->route('infopage');
        } else {
            return redirect()->back()->withInput()->with('login-error', 'Tên tài khoản/Mật khẩu không đúng');
        }
    }

    public function register(RegisterRequest $request) {
        $isExistUsername = Customer::where('username', $request->username)
            ->exists();

        $isExistEmail = Customer::where('email', $request->email)
            ->exists();

        if ($isExistUsername) {
            return redirect()->back()->withInput()->with('register-error', 'Tên tài khoản đã tồn tại');
        } else if ($isExistEmail) {
            return redirect()->back()->withInput()->with('register-error', 'Email đã tồn tại');
        }

        Customer::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        Auth::attempt(['username' => $request->username, 'password' => $request->password], true);

        return redirect()->route('infopage');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('authenticatepage');
    }
}
