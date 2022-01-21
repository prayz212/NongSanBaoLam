@extends('admin.layouts.master')
@section('main')

<main class="__product-main">
  <div class="container-fluid px-4">
    <div class="row">
      <div class="col-sm-12">
        <div class="__product-title-box" style="margin: 0px">
          <h4>Thông tin voucher</h4>
          <ol class="breadcrumb" style="margin-bottom: 0px">
            <li class="breadcrumb-item"><a href="{{route('voucherManagement')}}">Quản lý voucher</a></li>
            <li class="breadcrumb-item active">{{ $voucher->code }}</li>
          </ol>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="__product-info-box" style="padding: 16px 0px;">
          <div class="row fw-bold fs-3 d-flex justify-content-center">Voucher</div>
          <div class="d-flex justify-content-center">
            <div class="col-12 col-sm-8 col-md-7 col-lg-6 col-xl-5 px-sm-5 pt-3 __voucher-info">
                <div>
                                  <p>
                  <b>Mã voucher: </b>
                  {{ $voucher->code }}
                </p>
                <p>
                  <b>Chiết khấu (VND): </b>
                  {{ number_format(round($voucher->discount), 0, ",", ".") }}đ
                </p>
                <p>
                  <b>Ngày bắt đầu: </b>
                  {{ date('d/m/Y',strtotime($voucher->start_at)) }}
                </p>
                <p>
                  <b>Ngày kết thúc: </b>
                  {{ date('d/m/Y',strtotime($voucher->end_at)) }}
                </p>
                <p>
                  <b>Số lượng: </b>
                  {{ $voucher->quantity }}
                </p>
                <p>
                  <b>Số lượng đã sử dụng: </b>
                  {{ $voucher->used ?? 0}}
                </p>
                <p class="border-bottom-0">
                  <b>Số lượng còn lại: </b>
                  {{ $voucher->remain ?? $voucher->quantity }}
                </p>
                </div>
                <div class="row my-3">
                  <div class="col-12 d-md-flex justify-content-end d-inline">
                    <div class="col-md-6 col-12 text-secondary d-flex justify-content-end">
                      <a id="deleteButton" class="btn btn-danger shadow-none" data-href="{{ url('admin/xoa-voucher/' . $voucher->code) }}">Xóa</a>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

@include('admin.includes.pop-up-confirm')
@endsection