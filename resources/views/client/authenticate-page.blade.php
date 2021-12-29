@extends('client.layouts.master')
@section('main')

<!-- --------------------- account page -----------------  -->
<div class="_account-page">
  <div class="_container">
      <div class="_row">
          <div class="col-md-6 col-0">
              <div class="d-none d-md-block">
                  <img src="{{ asset('images/login.png') }}" width="100%">
              </div>
          </div>
          <div class="col-md-6 col-12 p-3">
              <div class="_form-container">
                  <div class="_form-btn">
                      <span id="signin_span">Đăng nhập</span>
                      <span id="signup_span">Đăng ký</span>
                      <hr id="_Indicator">
                      <form id="_LoginForm" method="post" action="{{ route('login') }}">
                          @csrf
                          <input class="_form-input" type="text" placeholder="Tên tài khoản" name="username" value="{{ old('username') }}">
                          <input class="_form-input" type="password" placeholder="Mật khẩu" name="password">
                          <div id="error-msg-log" class="__error-msg">{{ $errors->login->first() ? $errors->login->first() : Session::get('login-error') ?? '' }}</div>
                          <button type="submit" class="_btn">Đăng nhập</button>
                          <a >Quên mật khẩu</a>
                      </form>

                      <form id="_RegForm" method="post" action="{{ route('register') }}">
                          @csrf
                          <input class="_form-input" type="text" placeholder="Tên tài khoản" name="username" value="{{ old('username') }}">

                          <input class="_form-input" type="email" placeholder="Email" name="email" value="{{ old('email') }}">

                          <input class="_form-input" type="password" placeholder="Mật khẩu" name="password">
                          <div id="error-msg-reg" class="__error-msg">{{ $errors->register->first() ? $errors->register->first() : Session::get('register-error') ?? '' }}</div>
                          
                          <button type="submit" class="_btn">Đăng ký</button>
                      </form>
                  </div>
          </div>
      </div>
  </div>
</div>


@endsection