@extends('admin.layouts.master')
@section('main')

<main class="__product-main">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="__product-title-box d-flex justify-content-between" style="margin-top: 0px">
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
            <div class="col-sm-4">
                <div class="__product-title-box">
                    <div class="card-body px-4">
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
                                <span class="text-secondary">{{ $customer->totalBill }} hóa đơn</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span> Tổng tiền:</span>
                                <span class="text-secondary">{{ $customer->totalPay != NULL ? number_format(round($customer->totalPay), 0, ",", ".") : "0" }}đ</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="__product-title-box">
                        <div class="row m-3 border-bottom pb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Mã khách hàng</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $customer->id }}
                            </div>
                        </div>
                        <div class="row m-3 border-bottom pb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Tên tài khoản</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            {{ $customer->username }}
                            </div>
                        </div>
                        <div class="row m-3 border-bottom pb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Họ và tên</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $customer->fullname != NULL ? $customer->fullname : "Chưa cập nhật" }}
                            </div>
                        </div>
                        <div class="row m-3 border-bottom pb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $customer->email != NULL ? $customer->email : "Chưa cập nhật" }}
                            </div>
                        </div>
                        <div class="row m-3 border-bottom pb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Số điện thoại</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $customer->phone != NULL ? $customer->phone : "Chưa cập nhật" }}
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Địa chỉ</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                {{ $customer->address != NULL ? $customer->address : "Chưa cập nhật" }}
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 text-secondary">
                                <a href="{{ route('updateAccount', ['id' => $customer->id]) }}" class="btn btn-primary px-4 me-3 mt-3">Chỉnh sửa</a>
                                <a data-href="{{ url('admin/xoa-tai-khoan/' . $customer->id) }}" class="btn btn-danger px-4 me-3 mt-3" id="deleteButton" role="button">Xoá</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</main>

@include('admin.includes.pop-up-confirm')
@endsection