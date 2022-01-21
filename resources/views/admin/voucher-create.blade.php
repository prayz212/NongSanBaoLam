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
            <li class="breadcrumb-item active">Thêm mới</li>
          </ol>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="__product-info-box" style="padding: 16px 8px;">
          <div class="row fw-bold fs-3 d-flex justify-content-center">Voucher</div>
          <div class="d-flex justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-10 px-sm-5">
                <form method="POST" action="{{ route('createVoucherProcess') }}">
                  @csrf
                  <div class="row m-3">
                    <div class="col-md-4 align-self-center">
                        <h6>Mã voucher</h6>
                    </div>
                    <div class="col-md-8 text-secondary">
                        <input name="code" placeholder="Mã voucher" type="text" value="{{ old('code') ? old('code') : '' }}" class="form-control shadow-none">
                        <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px">{{ $errors->first('code') ?? '' }}</div>
                    </div>
                  </div>
                  <div class="row m-3">
                      <div class="col-md-4 align-self-center">
                          <h6>Chiết khấu (VND)</h6>
                      </div>
                      <div class="col-md-8 text-secondary">
                          <input name="discount" placeholder="Chiết khấu" type="number" value="{{ old('discount') ? old('discount') : '' }}" class="form-control shadow-none">
                          <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px">{{ $errors->first('discount') ?? '' }}</div>
                      </div>
                  </div>
                  <div class="row m-3">
                      <div class="col-md-4 align-self-center">
                          <h6>Ngày bắt đầu</h6>
                      </div>
                      <div class="col-md-8 text-secondary">
                        <input name="start_at" placeholder="Ngày bắt đầu" type="date" value="{{ old('start_at') ? old('start_at') : '' }}" class="form-control shadow-none">
                        <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px">{{ $errors->first('start_at') ?? '' }}</div>

                      </div>
                  </div>
                  <div class="row m-3">
                      <div class="col-md-4 align-self-center">
                          <h6>Ngày kết thúc</h6>
                      </div>
                      <div class="col-md-8 text-secondary">
                        <input name="end_at" placeholder="Ngày kết thúc" type="date" value="{{ old('end_at') ? old('end_at') : '' }}" class="form-control shadow-none">
                        <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px">{{ $errors->first('end_at') ?? '' }}</div>
                      </div>
                  </div>
                  <div class="row m-3">
                      <div class="col-md-4 align-self-center">
                          <h6>Số lượng</h6>
                      </div>
                      <div class="col-md-8 text-secondary">
                        <input name="quantity" placeholder="Số lượng" type="number" value="{{ old('quantity') ? old('quantity') : '' }}" class="form-control shadow-none">
                        <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px">{{ $errors->first('quantity') ?? '' }}</div>
                        
                        @if (Session::get('voucher-noti-error'))
                            <div class="__notify-msg" style="font-size: smaller; color: red">{{ Session::get('voucher-noti-error') ?? '' }}</div>
                        @endif
                      </div>
                  </div>
                  <div class="row m-3">
                    <div class="col-12 d-flex justify-content-end d-inline">
                      <a id="cancelButton" class="btn btn-danger mx-3" data-href="{{ route('voucherManagement') }}">
                        Huỷ
                      </a>
                      <button type="submit" class="btn btn-primary shadow-none" >Lưu</button>
                    </div>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

@include('admin.includes.pop-up-confirm')

@endsection