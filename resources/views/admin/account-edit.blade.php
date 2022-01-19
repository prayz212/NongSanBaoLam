@extends('admin.layouts.master')
@section('main')

<main class="__product-main">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="__product-title-box d-flex justify-content-between" style="margin-top: 0px; margin-bottom: 0px">
                    <div class="print-title">
                        <h4 >Thông tin tài khoản</h4>
                        <ol class="breadcrumb none-print" style="margin-bottom: 0px">
                            <li class="breadcrumb-item"><a href="{{ route('accountManagement') }}">Quản lý tài khoản</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('adminAccountInfo', $customer->id) }}">{{ $customer->username }}</a></li>
                            <li class="breadcrumb-item active">Chỉnh sửa</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5 col-lg-6 pe-md-1">
                <div class="__product-title-box mb-0">
                    <div class="card-body px-3 px-md-2 px-lg-4">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" style="width: 90px; height: 90px; border-radius: 50%">
                            <div class="my-3">
                                <h4>{{ $customer->username ?? '' }}</h4>
                                <div>
                                    <p class="text-secondary">{{ $customer->email ?? '' }}</p>
                                </div>
                                <div class="my-2">
                                    <div class="text-dark fs-5">Họ và tên: {{ $customer->fullname ?? "Chưa cập nhật" }} </div>
                                </div>
                                <div class="my-2">
                                    <div class="text-dark fs-5">Số điện thoại: {{ $customer->phone ?? "Chưa cập nhật" }}</div>
                                </div>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush border-top">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span> Tổng số hóa đơn:</span>
                                <span class="text-secondary">{{ $customer->totalBill->first() ? $customer->totalBill->first()->total : '0' }} hóa đơn</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span> Tổng tiền đã mua:</span>
                                <span class="text-secondary">{{ $customer->totalPay->first() ? number_format(round($customer->totalPay->first()->total), 0, ",", ".") : "0" }}đ</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-lg-6">
                <div class="__product-title-box">
                    <form class="px-3 pt-3" method="POST" action="{{ route('updateAccountProcess', ['id' => $customer->id]) }}">
                        @csrf
                        <div class="row pb-3">
                            <div class="col-sm-3 col-md-4 align-self-center">
                                <h6 class="__input-label">Mã khách hàng</h6>
                            </div>
                            <div class="col-sm-9 col-md-8 text-secondary">
                                <input disabled type="text" class="form-control shadow-none" value="{{ $customer->id ?? '' }}" placeholder="Mã khách hàng">
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-3 col-md-4 align-self-center">
                                <h6 class="__input-label">Tên tài khoản</h6>
                            </div>
                            <div class="col-sm-9 col-md-8 text-secondary">
                                <input disabled name="username" type="text" class="form-control shadow-none" value="{{ old('username') ? old('username') : $customer->username ?? '' }}" placeholder="Tên tài khoản">
                                <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px">{{ $errors->first('username') ?? '' }}</div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-3 col-md-4 align-self-center">
                                <h6 class="__input-label">Họ và tên</h6>
                            </div>
                            <div class="col-sm-9 col-md-8 text-secondary">
                                <input name="fullname" type="text" class="form-control shadow-none" value="{{ old('fullname') ? old('fullname') : $customer->fullname ?? '' }}" placeholder="Họ và tên">
                                <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px">{{ $errors->first('fullname') ?? '' }}</div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-3 col-md-4 align-self-center">
                                <h6 class="__input-label">Email</h6>
                            </div>
                            <div class="col-sm-9 col-md-8 text-secondary">
                                <input name="email" type="text" class="form-control shadow-none" value="{{ old('email') ? old('email') : $customer->email ?? '' }}" placeholder="Email">
                                <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px">{{ $errors->first('email') ?? '' }}</div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-3 col-md-4 align-self-center">
                                <h6 class="__input-label">Số điện thoại</h6>
                            </div>
                            <div class="col-sm-9 col-md-8 text-secondary">
                                <input name="phone" type="number" class="form-control shadow-none" value="{{ old('phone') ? old('phone') : $customer->phone ?? '' }}" placeholder="Số điện thoại">
                                <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px">{{ $errors->first('phone') ?? '' }}</div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-sm-3 col-md-4 align-self-center">
                                <h6 class="__input-label">Địa chỉ</h6>
                            </div>
                            <div class="col-sm-9 col-md-8 text-secondary">
                                <input name="address" type="text" class="form-control shadow-none" value="{{ old('address') ? old('address') : $customer->address ?? '' }}" placeholder="Địa chỉ">
                                <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px">{{ $errors->first('address') ?? '' }}</div>
                                
                                @if (Session::get('account-noti-error'))
                                    <div class="__notify-msg" style="font-size: medium; color: red">{{ Session::get('account-noti-error') ?? '' }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-secondary d-flex justify-content-end">
                                <button class="btn btn-primary px-4 mt-0 mt-md-3">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection