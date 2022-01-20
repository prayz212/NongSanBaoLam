@extends('client.layouts.master')
@section('main')

<div class="_account-page __header">
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
                        <span class="_form-title">Thay đổi mật khẩu</span>
                        <hr class="_form-title-indicator" style="margin: 8px 0 6px 0; height: 3px; background: #243a6f" />
                        <small class="_form-explain">Tài khoản: <b>{{ $customer->username }}</b></small>
                    </div>
                    <form style="margin-top: 2rem" method="post" action="{{ route('requestNewPassword') }}">
                        @csrf
                        <input name="username" hidden value="{{ $customer->username }}">
                        <input name="oldPassword"
                               class="_form-input"
                               type="password"
                               placeholder="Mật khẩu cũ" />
                        <input name="newPassword"
                               class="_form-input"
                               type="password"
                               placeholder="Mật khẩu mới" />
                        <input name="confirmPassword"
                               class="_form-input"
                               type="password"
                               placeholder="Nhập lại mật khẩu mới" />
                        <div id="error-msg-log" class="__error-msg">{{ $errors->first() ? $errors->first() : Session::get('request-newpassword-err') ?? '' }}</div>

                        <button type="submit" class="_btn">Thay đổi mật khẩu</button>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection