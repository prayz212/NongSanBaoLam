@extends('admin.layouts.master')
@section('main')

<main class="__product-main">
  <div class="container-fluid px-4">

    <div class="row">
        <div class="col-sm-12">
            <div class="__product-title-box" style="margin-top: 0px">
              <h4>Thông tin sản phẩm</h4>
              <ol class="breadcrumb" style="margin-bottom: 0px">
                  <li class="breadcrumb-item"><a href="{{route('productManagement')}}">Quản lý sản phẩm</a></li>
                  <li class="breadcrumb-item active">{{ $product->name }}</li>
              </ol>
            </div>
        </div>
    </div>

      <div class="row">
          <div class="col-lg-7 col-sm-12">
              <div class="__imgae-section justify-content-lg-center">
                  <div class="__thumbnails">
                      @foreach ($product->image as $k => $i)
                          <div class="__thumbnail-pic rounded" {!! $k == 0 ? 'style="margin-top: 0"' : '' !!}>
                              <img src="{{ asset('images/products/' . $i->url) }}"
                                   alt="{{ $i->name }}" />
                          </div>
                      @endforeach
                  </div>
                  <div class="__product-image-box __main-pic-section">
                      <div class="__main-pic">
                          <img src="{{ asset('images/products/' . $product->main_pic->url) }}"
                               alt="{{ $product->main_pic->name }}" />
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-lg-5 col-sm-12 __left-infor-section">
              <div class="__product-info-box mt-2 mt-sm-0">
                  <p><b>Mã sản phẩm:</b> #{{ $product->id }}</p>
                  <p><b>Tên sản phẩm:</b> {{ $product->name }}</p>
                  <p><b>Loại sản phẩm:</b> {{ $product->category->name }}</p>
                  <p><b>Giá:</b> {{ number_format(round($product->price), 0, ",", ".") }}đ</p>
                  <p><b>Đã bán:</b> {{ $product->sold ?? 0 }} kg</p>
                  <p><b>Còn lại:</b> {{ $product->quantity - $product->sold }} kg</p>
                  <p><b>Trung bình đánh giá:</b> {{ $product->avgRating->first() ? round($product->avgRating->first()->rating) . ' sao' : 'Chưa có đánh giá' }} </p>
              </div>

              <div class="__product-info-box">
                  <p><b>Đang khuyến mãi:</b> {{ $product->discount ? 'Có' : 'Không' }}</p>
                  <p><b>Chiết khấu:</b> {{ $product->discount ?? 0 }}%</p>
              </div>
          </div>
      </div>

      <div class="row">
          <div class="col-sm-12">
              <div class="__product-info-box mt-0 mt-sm-4">
                  <h5>Mô tả sản phẩm</h5>
                  <p class="mb-0">
                    {{ $product->description }}
                  </p>
              </div>
          </div>
      </div>

      <div class="row">
          <div class="d-flex flex-row-reverse">
              <a class="btn btn-danger" id="deleteButton" data-href="{{ url('admin/xoa-san-pham/' . $product->id) }}">Xoá</a>
              <a class="btn btn-primary mx-3" href="{{ url('admin/chinh-sua-san-pham/' . $product->id) }}">Chỉnh sửa</a>
          </div>
      </div>
  </div>
</main>

@include('admin.includes.pop-up-confirm')

@endsection