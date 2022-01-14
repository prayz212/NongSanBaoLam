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
                        <span class="_form-title">Quên mật khẩu</span>
                        <hr class="_form-title-indicator" style="margin: 8px 0 0 0; height: 3px; background: #243a6f" />
                    </div>
                    <form method="post" action="{{ route('requestResetPassword') }}">
                        @csrf
                        <input name="email" class="_form-input" type="email" placeholder="Email" value="{{ old('email') }}" />
                        <div id="error-msg-reg" class="__error-msg">{{ $errors->first() ? $errors->first() : Session::get('request-reset-pass-err') ?? '' }}</div>
                        
                        <button type="submit" class="_btn">Cấp lại mật khẩu</button>

                        @if (empty(Session::get('noti')))
                            <small class="_form-explain" style="margin-bottom: 2rem; display: inline-block">
                                Khi nhấn cấp lại mật khẩu email truyền vào sẽ nhận được đường
                                link cho phép nhập mật khẩu mới.
                            </small>
                        @endif                   
                        <div class="__notify-msg">{{ Session::get('noti') ?? '' }}</div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection