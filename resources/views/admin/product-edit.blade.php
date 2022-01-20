@extends('admin.layouts.master')
@section('main')

<main class="__product-main">
  <div class="container-fluid px-4">
    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="__product-title-box" style="margin: 0px">
                <h4>Cập nhật thông tin sản phẩm</h4>
                <ol class="breadcrumb" style="margin-bottom: 0px">
                <li class="breadcrumb-item"><a href="{{route('productManagement')}}">Quản lý sản phẩm</a></li>
                <li class="breadcrumb-item"><a href="{{route('productInfo', $product->id)}}">{{ $product->name }}</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
                </ol>
            </div>
        </div>
    </div>
      
      <form id="update-product-form" action="{{ route('updateProcess') }}" enctype="multipart/form-data" method="post">
        @csrf
        <input id="removed-images" name="removed" type="text" style="display: none" />
          <div class="row">
              <div class="col-sm-12 col-lg-6">
                  <div class="__imgae-section">
                      <div class="__thumbnails">
                          @foreach ($product->image as $index => $image)
                          <div class="__thumbnail-input-pic rounded" style="margin-top: 0; position: relative ">
                              <div class="__remove-image" style="display: block; cursor: pointer">&times;</div>
                              <button type="button" class="btn" style="display: none;" onclick="document.getElementById('{{ 'input' . $index }}').click();">
                                  Thêm ảnh
                              </button>
                              <input id="{{ 'input' . $index }}" type="file" name="images[]" style="display: none" onchange="readURL(this);" accept="image/*" data-hasValue="true" />
                              <img src="{{ $image->url }}" alt="project-image" style="display: block; width: 100%" />
                          </div>
                          @endforeach
                          @for ($i = count($product->image); $i < 4; $i++)
                          <div class="__thumbnail-input-pic rounded" style="margin-top: 0; position: relative ">
                              <div class="__remove-image" style="display: none; cursor: pointer">&times;</div>
                              <button type="button" class="btn" style="display: block;" onclick="document.getElementById('{{ 'input' . $i }}').click();">
                                  Thêm ảnh
                              </button>
                              <input id="{{ 'input' . $i }}" type="file" name="images[]" style="display: none" onchange="readURL(this);" accept="image/*" data-hasValue="false" />
                              <img src="" alt="project-image" style="display: none; width: 100%" />
                          </div>                              
                          @endfor
                      </div>
                      <div class="__product-image-box __nonselection w-100">
                          <div class="__main-pic">
                            @if($errors->has('images'))
                                <p class="d-flex justify-content-center align-items-center text-danger">{{ $errors->first('images') }}</p>
                            @elseif (Session::has('upload-image-error'))
                                <p class="d-flex justify-content-center align-items-center text-danger">{{ Session::get('upload-image-error') }}</p>
                            @else
                                <p class="d-flex justify-content-center align-items-center">Chưa chọn ảnh nào</p>
                            @endif
                              <img src="" alt="product-image" style="display: none; width: 100%" />
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-sm-12 col-lg-6 mt-3 mt-sm-3 mt-lg-0">
                  <div class="__product-input-box mt-2 mt-sm-0">
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <h6 class="__input-label">Mã sản phẩm</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <input name="id" readonly class="form-control shadow-none" value="{{ $product->id }}"/>
                          </div>
                      </div>
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <h6 class="__input-label">Tên sản phẩm</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <input name="name" placeholder="Tên sản phẩm" type="text" class="form-control shadow-none" value="{{ $product->name }}"/>
                              <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px; margin-left: 4px;">{{ $errors->first('name') ?? '' }}</div>
                          </div>
                      </div>
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <h6 class="__input-label">Loại sản phẩm</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <select class="form-control shadow-none" name="type">
                                  @foreach ($categories as $category)
                                    @if ($product->category->id == $category->id)
                                        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endif
                                  @endforeach
                              </select>
                              <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px; margin-left: 4px;">{{ $errors->first('type') ?? '' }}</div>
                          </div>
                      </div>
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <h6 class="__input-label">Giá sản phẩm</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <input name="price" placeholder="Giá sản phẩm" type="number" class="form-control shadow-none"  value="{{ $product->price }}"/>
                              <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px; margin-left: 4px;">{{ $errors->first('price') ?? '' }}</div>
                          </div>
                      </div>
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <h6 class="__input-label">Chiết khấu</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <input name="discount" placeholder="Phần trăm chiết khấu (%)" type="number" class="form-control shadow-none"  value="{{ $product->discount ?? 0 }}"/>
                              <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px; margin-left: 4px;">{{ $errors->first('discount') ?? '' }}</div>
                          </div>
                      </div>
                      <div class="row m-3 mt-sm-4">
                          <div class="col-12 align-self-center">
                              <h6 class="__input-label">Mô tả sản phẩm</h6>
                          </div>
                          <div class="col-12 text-secondary mt-sm-2">
                              <textarea class="form-control shadow-none" name="description" rows="8" cols="50" placeholder="Mô tả chi tiết về sản phẩm">{{ $product->description }}</textarea>
                              <div id="update-error-msg" class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px; margin-left: 4px;">{{ $errors->first('description') ?? '' }}</div>
                          </div>
                      </div>
                      <div class="row mx-3 my-2">
                          <div class="d-flex flex-row-reverse">
                              <button id="update-product-btn" class="btn btn-primary shadow-none">
                                  Lưu
                              </button>
                              <button id="update-product-loading-btn" class="btn btn-primary" type="button" disabled style="display: none">
                                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                  Đang lưu...
                              </button>
                              <a id="cancelButton" class="btn btn-danger mx-3" data-href="{{ route('productInfo', $product->id) }}">
                                  Huỷ
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </form>
  </div>
</main>

@include('admin.includes.pop-up-confirm')

<script src="{{ asset('admin/js/create-edit-product.js') }}"></script>

@endsection