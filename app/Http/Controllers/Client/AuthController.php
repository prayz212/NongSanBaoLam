<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function resetPassword() {
        return view('client.request-reset-password');
    }

    public function requestResetPassword(ResetPasswordRequest $request) {
        try {
            $customer = Customer::where('email', $request->email)->firstOrFail();
        
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $customer->email,
            ], [
                'token' => Str::random(60),
            ]);
            if ($passwordReset) {
                $customer->notify(new ResetPasswordNotification($passwordReset->token));
            }
    
            return redirect()->back()->withInput()->with('noti', 'Link khôi phục mật khẩu đã được gửi tới email vừa nhập');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->withInput()->with('request-reset-pass-err', 'Email chưa được đăng ký');
        }
    }

    public function updatePassword($token) {
        try {
            $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
            $customer = Customer::where('email', $passwordReset->email)->firstOrFail();

            if (Carbon::parse($passwordReset->updated_at)->addMinutes(5)->isPast()) {
                $passwordReset->delete();

                die('expired 404');
            }

            return view('client.request-update-password')
                ->with('username', $customer->username)
                ->with('token', $token);
        } catch (ModelNotFoundException $e) {
            die("Lỗi");
        }
    }

    public function updateNewPassword($token, UpdatePasswordRequest $request) {
        try { 
            $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
        
            $customer = Customer::where('email', $passwordReset->email)->firstOrFail();
            $customer->password = Hash::make($request->password);
            $customer->save();

            $passwordReset->delete();

            return redirect()->route('authenticatepage');
        } catch (ModelNotFoundException $e) {
            die("Lỗi");
        }
    }    

    public function logout() {
        Auth::logout();
        return redirect()->route('authenticatepage');
    }
}
