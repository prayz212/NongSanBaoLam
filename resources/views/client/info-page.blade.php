@extends('client.layouts.master')
@section('main')

@if (!empty($customer))
<div class="container my-5 py-5">
  <div class="row gutters">
      <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
          <div class="border p-5">
              <div>
                  <div class="account-settings">
                      <div class="user-profile">
                          <div class="user-avatar">
                              <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Avatar">
                          </div>
                          <h5 class="user-name fs-1 __break-word-dots">{{ $customer->username }}</h5>
                          <h6 class="user-email fs-4 __break-word-dots">{{ $customer->email }}</h6>
                      </div>
                      @if (!is_null($customer->fullname))
                          <div class="about">
                              <p class="fs-3 __break-word-dots">
                                  Họ và tên: {{ $customer->fullname }}
                              </p>
                              <p class="fs-3 __break-word-dots">
                                  Số điện thoại: {{ $customer->phone }}
                              </p>
                          </div>
                      @endif

                      <div class="d-flex justify-content-center">
                          <a class="_btn"><p class="text-white mb-0 text-center">Lịch sử đơn hàng</p></a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12 pt-3 px-5">
          <div class="h-100 px-lg-5 px-md-3 mt-lg-0 mt-5">
              <form method="post" action="{{ route('updateInfo') }}">
                  @csrf
                  <input hidden value="{{ $customer->id }}" name="id" />
                  <div class="row gutters">
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <h6 class="mb-2 fs-2 text-dark">Thông tin cá nhân</h6>
                      </div>
                      <div class="col-xl-8 col-lg-8 col-md-7 col-sm-6 col-12">
                          <div class="form-group">
                              <input type="text" class="_form-input" name="fullname" placeholder="Họ và Tên" value="{{ old('fullname') ? old('fullname') : $customer->fullname ?? '' }}">
                              <div class="__notify-msg" style="font-size: smaller; color: red">{{ $errors->first('fullname') ?? '' }}</div>
                          </div>
                      </div>

                      <div class="col-xl-4 col-lg-4 col-md-5 col-sm-6 col-12">
                          <div class="form-group">
                              <input type="text" class="_form-input" name="phone" placeholder="Số điện thoại" value="{{ old('phone') ? old('phone') : $customer->phone ?? '' }}">
                              <div class="__notify-msg" style="font-size: smaller; color: red">{{ $errors->first('phone') ?? '' }}</div>
                          </div>
                      </div>
                      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                          <div class="form-group">
                              <input type="email" class="_form-input" name="email" placeholder="Email" value="{{ old('email') ? old('email') : $customer->email ?? '' }}">
                              <div class="__notify-msg" style="font-size: smaller; color: red">{{ $errors->first('email') ?? '' }}</div>
                          </div>
                      </div>

                      <div class="col-12">
                          <div class="form-group">
                              <input type="text" class="_form-input" name="address" placeholder="Địa chỉ" value="{{ old('address') ? old('address') : $customer->address ?? '' }}">
                              <div class="__notify-msg" style="font-size: smaller; color: red">{{ $errors->first('address') ?? '' }}</div>
                          </div>
                      </div>
                  </div>
                  <div class="row gutters mt-4">
                      <div class="col-xl-8 col-lg-7 col-md-7 col-sm-6 col-6">
                          @if (Session::get('info-noti-success'))
                            <div class="__notify-msg" style="font-size: medium">{{ Session::get('info-noti-success') ?? '' }}</div>
                          @elseif (Session::get('info-noti-error'))
                            <div class="__notify-msg" style="font-size: medium; color: red">{{ Session::get('info-noti-error') ?? '' }}</div>
                          @endif
                      </div>
                      <div class="col-xl-4 col-lg-5 col-md-5 col-sm-6 col-6">
                          <div class="d-flex justify-content-end">
                              <button type="submit" class="_update-btn my-0">Cập nhật</button>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>
@endif
@endsection