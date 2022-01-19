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
                            <li class="breadcrumb-item active">{{ $customer->username }}</li>
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
                                <h4>{{ $customer->username }}</h4>
                                <div>
                                    <p class="text-secondary">{{ $customer->email }}</p>
                                </div>
                                <div class="my-2">
                                    <div class="text-dark fs-5">Họ và tên: {{ $customer->fullname != NULL ? $customer->fullname : "Chưa cập nhật" }} </div>
                                </div>
                                <div class="my-2">
                                    <div class="text-dark fs-5">Số điện thoại: {{ $customer->phone != NULL ? $customer->phone : "Chưa cập nhật" }}</div>
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
                <div class="__product-info-box">
                        <p>
                            <b>Mã khách hàng: </b>
                            {{ $customer->id }}
                        </p>
                            <b>Tên tài khoản: </b>
                            {{ $customer->username }}
                        </p>
                        <p>
                            <b>Họ và tên: </b>
                            {{ $customer->fullname != NULL ? $customer->fullname : "Chưa cập nhật" }}
                        </p>
                        <p>
                            <b>Email: </b>
                            {{ $customer->email != NULL ? $customer->email : "Chưa cập nhật" }}
                        </p>
                        <p>
                            <b>Số điện thoại: </b>
                            {{ $customer->phone != NULL ? $customer->phone : "Chưa cập nhật" }}
                        </p>
                        <p style="border-bottom: none">
                            <b>Địa chỉ: </b>
                            {{ $customer->address != NULL ? $customer->address : "Chưa cập nhật" }}
                        </p>
                        <div class="row">
                            <div class="col-sm-12 d-flex justify-content-end text-secondary">
                                <a href="{{ route('updateAccount', ['id' => $customer->id]) }}" class="btn btn-primary px-4 me-3">Chỉnh sửa</a>
                                <a data-href="{{ url('admin/xoa-tai-khoan/' . $customer->id) }}" class="btn btn-danger px-4 me-3" id="deleteButton" role="button">Xoá</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('admin.includes.pop-up-confirm')
@endsection