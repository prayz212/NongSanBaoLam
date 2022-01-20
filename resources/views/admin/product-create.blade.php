@extends('admin.layouts.master')
@section('main')

<main class="__product-main">
  <div class="container-fluid px-4">
    <div class="row mb-3">
        <div class="col-sm-12">
            <div class="__product-title-box" style="margin: 0px">
                <h4>Thêm sản phẩm mới</h4>
                <ol class="breadcrumb" style="margin-bottom: 0px">
                <li class="breadcrumb-item"><a href="{{route('productManagement')}}">Quản lý sản phẩm</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </div>
        </div>
    </div>
      <form action="{{ route('createProcess') }}" enctype="multipart/form-data" method="post" id="create-product-form">
        @csrf
          <div class="row">
              <div class="col-sm-12 col-lg-6">
                  <div class="__imgae-section">
                      <div class="__thumbnails">
                          <div class="__thumbnail-input-pic rounded" style="margin-top: 0; position: relative ">
                              <div class="__remove-image" style="display: none; cursor: pointer">&times;</div>
                              <button type="button" class="btn" onclick="document.getElementById('input1').click();">
                                  Thêm ảnh
                              </button>
                              <input id="input1" type="file" name="images[]" style="display: none" onchange="readURL(this);" accept="image/*" />

                              <img alt="project-image" style="display: none; width: 100%" />
                          </div>
                          <div class="__thumbnail-input-pic rounded" style="margin-top: 0; position: relative ">
                              <div class="__remove-image" style="display: none; cursor: pointer">&times;</div>
                              <button type="button" class="btn" onclick="document.getElementById('input2').click();">
                                  Thêm ảnh
                              </button>
                              <input id="input2" type="file" name="images[]" style="display: none" onchange="readURL(this);" accept="image/*" />

                              <img alt="project-image" style="display: none; width: 100%" />
                          </div>
                          <div class="__thumbnail-input-pic rounded" style="margin-top: 0; position: relative ">
                              <div class="__remove-image" style="display: none; cursor: pointer">&times;</div>
                              <button type="button" class="btn" onclick="document.getElementById('input3').click();">
                                  Thêm ảnh
                              </button>
                              <input id="input3" type="file" name="images[]" style="display: none" onchange="readURL(this);" accept="image/*" />

                              <img alt="project-image" style="display: none; width: 100%" />
                          </div>
                          <div class="__thumbnail-input-pic rounded" style="margin-top: 0; position: relative ">
                              <div class="__remove-image" style="display: none; cursor: pointer">&times;</div>
                              <button type="button" class="btn" onclick="document.getElementById('input4').click();">
                                  Thêm ảnh
                              </button>
                              <input id="input4" type="file" name="images[]" style="display: none" onchange="readURL(this);" accept="image/*" />

                              <img alt="project-image" style="display: none; width: 100%" />
                          </div>
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
                              <h6 class="__input-label">Tên sản phẩm</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <input name="name" placeholder="Tên sản phẩm" type="text" class="form-control shadow-none" value="{{ old('name') }}"/>
                              <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px; margin-left: 4px;">{{ $errors->first('name') ?? '' }}</div>
                          </div>
                      </div>
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <h6 class="__input-label">Loại sản phẩm</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <select class="form-control shadow-none" name="type">
                                  @if (old('type') === null)
                                    <option selected disabled hidden>Chọn loại sản phẩm</option>
                                  @endif
                                  @foreach ($categories as $category)
                                    @if (old('type') == $category->id)
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
                              <input name="price" placeholder="Giá sản phẩm" type="number" class="form-control shadow-none"  value="{{ old('price') }}"/>
                              <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px; margin-left: 4px;">{{ $errors->first('price') ?? '' }}</div>
                          </div>
                      </div>
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <h6 class="__input-label">Chiết khấu</h6>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <input name="discount" placeholder="Phần trăm chiết khấu (%)" type="number" class="form-control shadow-none"  value="{{ old('discount') ?? '0' }}"/>
                              <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px; margin-left: 4px;">{{ $errors->first('discount') ?? '' }}</div>
                          </div>
                      </div>
                      <div class="row m-3 mt-sm-4">
                          <div class="col-12 align-self-center">
                              <h6 class="__input-label">Mô tả sản phẩm</h6>
                          </div>
                          <div class="col-12 text-secondary mt-sm-2">
                              <textarea class="form-control shadow-none" name="description" rows="8" cols="50" placeholder="Mô tả chi tiết về sản phẩm">{{ old('description') }}</textarea>
                              <div class="__notify-msg" style="font-size: smaller; color: red; margin-top: 4px; margin-left: 4px;">{{ $errors->first('description') ?? '' }}</div>
                          </div>
                      </div>
                      <div class="row mx-3 my-2">
                          <div class="d-flex flex-row-reverse">
                              <button id="create-product-btn" class="btn btn-primary shadow-none">
                                  Lưu
                              </button>
                              <button id="create-product-loading-btn" class="btn btn-primary" type="button" disabled style="display: none">
                                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                  Đang lưu...
                              </button>
                              <a id="cancelButton" class="btn btn-danger mx-3" data-href="{{ route('productManagement') }}">
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