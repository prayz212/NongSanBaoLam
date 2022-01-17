@extends('admin.layouts.master')
@section('main')

<main class="__product-main">
  <div class="container-fluid px-4">
      <form action="" enctype="multipart/form-data" method="post" onsubmit="return checkImage()">
          <div class="row">
              <div class="col-sm-12 col-lg-6">
                  <div class="__imgae-section">
                      <div class="__thumbnails">
                          <div class="__thumbnail-input-pic rounded" style="margin-top: 0; position: relative ">
                              <div class="__remove-image" style="display: none; cursor: pointer">&times;</div>
                              <button type="button" class="btn" onclick="document.getElementById('input1').click();">
                                  Thêm ảnh
                              </button>
                              <input id="input1" type="file" name="image1" style="display: none" onchange="readURL(this);" accept="image/*" />
                              <img alt="project-image" style="display: none; width: 100%" />
                          </div>
                          <div class="__thumbnail-input-pic rounded" style="margin-top: 0; position: relative ">
                              <div class="__remove-image" style="display: none; cursor: pointer">&times;</div>
                              <button type="button" class="btn" onclick="document.getElementById('input2').click();">
                                  Thêm ảnh
                              </button>
                              <input id="input2" type="file" name="image2" style="display: none" onchange="readURL(this);" accept="image/*" />
                              <img alt="project-image" style="display: none; width: 100%" />
                          </div>
                          <div class="__thumbnail-input-pic rounded" style="margin-top: 0; position: relative ">
                              <div class="__remove-image" style="display: none; cursor: pointer">&times;</div>
                              <button type="button" class="btn" onclick="document.getElementById('input3').click();">
                                  Thêm ảnh
                              </button>
                              <input id="input3" type="file" name="image3" style="display: none" onchange="readURL(this);" accept="image/*" />
                              <img alt="project-image" style="display: none; width: 100%" />
                          </div>
                          <div class="__thumbnail-input-pic rounded" style="margin-top: 0; position: relative ">
                              <div class="__remove-image" style="display: none; cursor: pointer">&times;</div>
                              <button type="button" class="btn" onclick="document.getElementById('input4').click();">
                                  Thêm ảnh
                              </button>
                              <input id="input4" type="file" name="image4" style="display: none" onchange="readURL(this);" accept="image/*" />
                              <img alt="project-image" style="display: none; width: 100%" />
                          </div>
                      </div>
                      <div class="__product-image-box __nonselection w-100">
                          <div class="__main-pic">
                              <p class="d-flex justify-content-center align-items-center">Chưa chọn ảnh nào</p>
                              <img src="" alt="product-image" style="display: none; width: 100%" />
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-sm-12 col-lg-6 mt-3 mt-sm-3 mt-lg-0">
                  <div class="__product-input-box mt-2 mt-sm-0">
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <div class="__input-label">Tên sản phẩm</div>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <input name="name" placeholder="Tên sản phẩm" type="text" class="form-control shadow-none" />
                          </div>
                      </div>
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <div class="__input-label">Loại sản phẩm</div>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <select class="form-control shadow-none" name="type">
                                  <option value="null" selected disabled hidden>Chọn loại sản phẩm</option>
                                  @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <div class="__input-label">Giá sản phẩm</div>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <input name="price" placeholder="Giá sản phẩm" type="number" class="form-control shadow-none" />
                          </div>
                      </div>
                      <div class="row m-3">
                          <div class="col-sm-3 align-self-center">
                              <div class="__input-label">Chiết khấu</div>
                          </div>
                          <div class="col-sm-9 text-secondary">
                              <input name="discount" placeholder="Phần trăm chiết khấu (%)" type="number" class="form-control shadow-none" />
                          </div>
                      </div>
                      <div class="row m-3 mt-sm-4">
                          <div class="col-12 align-self-center">
                              <div class="__input-label">Mô tả sản phẩm</div>
                          </div>
                          <div class="col-12 text-secondary mt-sm-2">
                              <textarea class="form-control shadow-none" name="description" rows="8" cols="50" placeholder="Mô tả chi tiết về sản phẩm">
                              </textarea>
                          </div>
                      </div>
                      <div class="row mx-3 my-2">
                          <div class="d-flex flex-row-reverse">
                              <button type="submit" class="btn btn-primary shadow-none">
                                  Lưu
                              </button>
                              <a id="cancelButton" class="btn btn-danger mx-3" data-href="{{ route('productManagement') }}">
                                  Huỷ
                              </a>
                          </div>
                      </div>

                      {{-- <div class="row m-3">
                          <div id="errorMsg" class="AcCreateMess text-danger">@ViewBag.acCreateError</div>
                          <div asp-validation-summary="All" class="text-danger"></div>
                      </div> --}}
                  </div>
              </div>
          </div>
      </form>
  </div>
</main>

{{-- <script>
  function checkImage() {
      let srcs = [];
      srcs.push($('.__thumbnails .__thumbnail-input-pic img').eq(0).attr('src'))
      srcs.push($('.__thumbnails .__thumbnail-input-pic img').eq(1).attr('src'))
      srcs.push($('.__thumbnails .__thumbnail-input-pic img').eq(2).attr('src'))
      srcs.push($('.__thumbnails .__thumbnail-input-pic img').eq(3).attr('src'))

      let count = srcs.filter(function (element) {
          return element !== undefined;
      }).length;

      if (count == 0) {
          $('#errorMsg').html('<ul style="margin-bottom: 0rem"><li>Sản phẩm phải có ít nhất 1 hình</li></ul>')
      }
      else {
          $('#errorMsg').html('')
      }

      return count >= 1;
  }
</script> --}}

@include('admin.includes.pop-up-confirm')

<script src="{{ asset('admin/js/create-product.js') }}"></script>

@endsection