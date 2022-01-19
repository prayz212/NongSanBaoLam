@extends('admin.layouts.master')
@section('main')

<main class="__product-main">
  <div class="container-fluid px-4">
    <div class="row">
      <div class="col-sm-12">
        <div class="__product-title-box" style="margin: 0px">
          <h4>Thông tin sản phẩm</h4>
          <ol class="breadcrumb" style="margin-bottom: 0px">
            <li class="breadcrumb-item"><a href="{{route('productManagement')}}">Quản lý sản phẩm</a></li>
            <li class="breadcrumb-item active">Nhập kho</li>
          </ol>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="__product-info-box" style="padding: 16px 8px;">
          <div class="row fw-bold fs-3 d-flex justify-content-center">Nhập kho</div>
          <div class="d-flex justify-content-center">
            <div class="col-lg-7 col-md-10">
              <form id="stock-in-form" data-action="{{ route('stockInProcess') }}">
                @csrf
                <div>
                  <div class="row m-3">
                    <div class="col-md-4 align-self-center">
                        <h6>Thể loại sản phẩm</h6>
                    </div>
                    <div class="col-md-8 text-secondary">
                        <select name="category" class="form-select shadow-none" id="category-selector" data-href="{{ route('getProductByCategory') }}">
                          <option value="" selected disabled hidden>Loại sản phẩm</option>
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="row m-3">
                      <div class="col-md-4 align-self-center">
                          <h6>Sản phẩm</h6>
                      </div>
                      <div class="col-md-8 text-secondary">
                          <select name="product" class="form-select shadow-none" id="product-selector" disabled="true">
                          </select>
                      </div>
                  </div>
                  <div class="row m-3">
                      <div class="col-md-4 align-self-center">
                          <h6>Số lượng sản phẩm</h6>
                      </div>
                      <div class="col-md-8 text-secondary">
                          <input name="quantity" id="product-quantity" placeholder="Số lượng sản phẩm" type="number" class="form-control shadow-none">
                          <div id="validation-error-msg" class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px;"></div>
                      </div>
                  </div>
                  <div class="row m-3">
                    <div class="col-12 d-md-flex justify-content-end d-inline">
                      <div class="col-md-4 col-12 text-secondary d-md-flex justify-content-end">
                        <input id="stock-in-btn" type="button" class="btn btn-primary shadow-none" value="Nhập kho">
                      </div>
                    </div>
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

@include('admin.includes.pop-up-notify')

<script src="{{ asset('admin/js/stock-in.js') }}"></script>

<style>
  /* Chrome, Safari, Edge, Opera */
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  input[type=number] {
    -moz-appearance: textfield;
  }
</style>

@endsection