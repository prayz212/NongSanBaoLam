@extends('client.layouts.master')
@section('main')

@php
    $isAdmin = Auth::guard('admin')->check();
@endphp

@if (!empty($detail))
<section class="__section __product-detail">
  <div class="__details __container-md">
      <div class="__left">
          <div class="__main">
              <img src="{{ $detail->image[0]->url }}" alt="{{ $detail->image[0]->name }}">
          </div>
          <div class="__thumbnails">
              @foreach ($detail->image as $img)
                  <div class="__thumbnail">
                      <img src="{{ $img->url }}" alt="{{ $img->name }}">
                  </div>
              @endforeach
          </div>
      </div>
      <div class="__right">
          <nav aria-label="breadcrumb">
              <ol class="breadcrumb bg-body">
                  <li class="breadcrumb-item"><a href="{{ url('danh-sach-san-pham') }}">Sản phẩm</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{ $detail->name }}</li>
              </ol>
          </nav>
          <h1>{{ $detail->name }}</h1>
          <div class="__rating-sold">
              <div class="__rating">
                @php
                    $avgRating = $detail->avgRating->first()->rating ?? 0;
                @endphp
                @for ($i = 0; $i < round($avgRating); $i++)
                    <i class="bx bxs-star"></i>
                @endfor
                @for ($i = 0; $i < 5 - round($avgRating); $i++)
                    <i class="bx bx-star"></i>
                @endfor
              </div>
              <div class="__divider">|</div>
              <div class="__sold">
                  Đã bán: {{ $detail->sold }}
              </div>
          </div>
          <div class="__price-detail">
            @if ($detail->discount)
                @php
                $discountPrice = $detail->price - $detail->price * ($detail->discount/(float)100);
                @endphp
                <div class="__final-price">{{ number_format(round($discountPrice), 0, ",", ".") }}đ</div>
                <div class="__original-price">{{ number_format($detail->price, 0, ",", ".") }}đ</div>
                <div class="__discount-percent">-{{ $detail->discount }}%</div>
            @else
                <div class="__final-price">{{ number_format($detail->price, 0, ",", ".") }}đ</div>
            @endif
          </div>
          <form method="post" id="addToCartForm" action="{{ route('addToCart') }}">
              @csrf
              <input hidden value="{{ $detail->id }}" name="id" />

            <div style="display: flex;">
                <div class="quantity buttons_added">
                    <input type="button" value="-" class="minus">
                    <input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode="">
                    <input type="button" value="+" class="plus">
                </div>
                <div style='height: 41px; align-self: center; color: #939191; font-size: 1.3rem; margin-left: 1.5rem;'>(Đơn vị: {{ $detail->category_id == 6 ? 'Combo' : 'Kg' }})</div>
            </div>

              <div class="__form">
                  <div class="d-flex align-items-center">
                      <div class="">
                          <button type="submit" class="_btn">Thêm vào giỏ hàng</button>
                      </div>
                  </div>
              </div>
          </form>

          <div class="__highlight-services">
              <hr>
              <div class="__highlight-services-items">
                  <div class="card">
                      <img src="{{ asset('images/icon1.jpeg') }}" class="card-img-top" alt="...">
                      <div class="card-body">
                          <p class="card-text">Cam kết sản phẩm luôn giữ được độ tươi ngon</p>
                      </div>
                  </div>

                  <div class="card">
                      <img src="{{ asset('images/icon2.jpeg') }}" class="card-img-top" alt="...">
                      <div class="card-body">
                          <p class="card-text">Đặt hàng Online nhanh chóng và tiện lợi</p>
                      </div>
                  </div>

                  <div class="card">
                      <img src="{{ asset('images/icon3.jpeg') }}" class="card-img-top" alt="...">
                      <div class="card-body">
                          <p class="card-text">Giao hàng từ 1-5 tiếng sau khi đặt hàng</p>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>

<section class="__section-feature __container-md">
  <ul class="nav nav-tabs __nav-tab" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
          <button class="nav-link {{ count($errors) == 0 ? 'active' : '' }}" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail" type="button" role="tab" aria-controls="detail" aria-selected="true">Mô tả sản phẩm</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link {{ count($errors) > 0 ? 'active' : '' }}" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment" type="button" role="tab" aria-controls="comment" aria-selected="true">Bình luận</button>
      </li>
  </ul>
  <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show {{ count($errors) == 0 ? 'active' : '' }} p-3 __product-detail-content" id="detail" role="tabpanel" aria-labelledby="detail-tab">
          {{ $detail->description }}
      </div>
      <div class="tab-pane fade show {{ count($errors) > 0 ? 'active' : '' }} p-3 __product-detail-content" id="comment" role="tabpanel" aria-labelledby="comment-tab">
        <div class="">
            <div class="blog-comment">
                <form class="clearfix" method="post" action="{{ route('addComment') }}">
                    @csrf
                    <input hidden value="{{ $detail->id }}" name="id" />
                    <img src="https://bootdey.com/img/Content/user_1.jpg" class="avatar" alt="">
                    <div class="post-comments">
                        <div class="input-group mb-3">
                            <div id="customerNameText" style="padding: 0.65rem 0.75rem!important; font-size: 1.4rem!important;" class="input-group-text">Bình luận với tên: </div>
                            <input type="text" name="name" style="padding: 0.65rem 0.75rem!important; font-size: 1.4rem!important;" class="form-control" placeholder="Nhập tên..." value="{{Auth::guard('web')->user()->fullname ?? ''}}">
                        </div>
                        <input type="text" name="content" style="padding: 0.65rem 0.75rem!important; font-size: 1.4rem!important;" class="form-control" placeholder="Nhập nội dung bình luận...">

                        <div class="d-flex justify-content-between flex-row-reverse">
                            <button type="submit" class="_btn _submit-comment mt-3" style="font-size: 1.4rem!important; width: auto">Gửi</button>
                            @if($errors)
                                <div class="text-danger pt-2">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
                <ul class="comments">
                    @foreach($detail->comment as $c)
                    <li class="clearfix">
                        @if($c->reply_to == 0)
                        <img src="https://bootdey.com/img/Content/user_1.jpg" class="avatar" alt="">
                        <div class="post-comments">
                            <p class="meta">{{ $c->name }} bình luận lúc {{ $c->created_at->format('H:i d/m/Y') }}: {!! $isAdmin ? '<i class="float-end"><a class="__reply-button" role="button"><small>Trả lời</small></a></i>' : '' !!} </p>
                            <p>
                                {{ $c->content }}
                            </p>
                        </div>
                        <ul class="comments">
                            @foreach($detail->comment as $r)
                                @if($r->reply_to == $c->id)
                                <li class="clearfix">
                                    <img src="https://bootdey.com/img/Content/user_3.jpg" class="avatar" alt="">
                                    <div class="post-comments">
                                        <p class="meta">{{ $r->name }} trả lời lúc {{ $r->created_at->format('H:i d/m/Y') }}: </p>
                                        <p>
                                            {{ $r->content }}
                                        </p>
                                    </div>
                                </li>
                                @endif
                            @endforeach
                            <form style="display: none" method="post" action="{{ route('replyComment') }}"">
                                @csrf
                                <input hidden value="{{ $detail->id }}" name="product_id" />
                                <input hidden value="{{ $c->id }}" name="comment_id" />
                                <input hidden value="{{ $isAdmin ? Auth::guard('admin')->user()->fullname : '' }}" name="name" />
                                <img src="https://bootdey.com/img/Content/user_3.jpg" class="avatar" alt="">
                                <div class="post-comments">
                                    <div class="row">
                                        <div style="align-self: center;" class="col-12 col-sm-10">
                                            <input type="text" name="content" style="padding: 0.65rem 0.75rem!important; font-size: 1.4rem!important;" class="form-control enter-event" placeholder="Nhập nội dung bình luận...">
                                        </div>

                                        <div class="col-12 col-sm-2 d-flex flex-row-reverse">
                                            <button type="button" class="_btn _submit-comment mt-3 replyCommentSubmit" style="font-size: 1.4rem!important; width: auto">Gửi</button>
                                        </div>

                                        <div class="replyCommentError text-danger"></div>
                                    </div>
                                </div>
                            </form>
                        </ul>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
  </div>
</section>

<!-- Related -->
<section class="__section __featured mb-5">
  <div class="__top __container">
      <h1>Sản phẩm tương tự</h1>
  </div>

  <div class="__product-center __container">
      @foreach ($relative as $r)
        <div class="__product">
            <div class="__product-header">
                <img src="{{ $r->main_pic->url }}" alt="{{ $r->main_pic->name }}">
                @if ($r->discount)
                <img style="width: 7rem; height: 5rem; position: absolute; top: 1%; right: 2%" src="{{ asset('images/sales.png') }}" alt="discount">
                <span style="position: absolute; top: 6.5%; right: 9%; color: red; font-size: 1.4rem;">-{{$r->discount}}%</span>
                @endif
                <a href="{{ url('chi-tiet-san-pham/' . $r->id) }}">
                    <ul class="icons">
                        <span><i class='bx bxs-show show-icons'></i></span>
                    </ul>
                </a>
            </div>
            <div class="__product-footer">
                <a href="{{ url('chi-tiet-san-pham/' . $r->id) }}">
                    <h3 class="__break-word-dots">{{ $r->name }}</h3>
                </a>
                <div class="__rating">
                @php
                    $avgRating = $r->avgRating->first()->rating ?? 0;
                @endphp
                @for ($i = 0; $i < round($avgRating); $i++)
                    <i class="bx bxs-star"></i>
                @endfor
                @for ($i = 0; $i < 5 - round($avgRating); $i++)
                    <i class="bx bx-star"></i>
                @endfor
                </div>
                
                @if ($r->discount)
                @php
                $discountPrice = $r->price - $r->price * ($r->discount/(float)100);
                @endphp
                <h4 class="__price">{{ number_format(round($discountPrice), 0, ",", ".") }}đ</h4>
                @else
                <h4 class="__price">{{ number_format($r->price, 0, ",", ".") }}đ</h4>
                @endif
            </div>
        </div>
      @endforeach
  </div>
</section>

<div class="__wrapper" id="toast_success">
  <div id="toast">
    <div class="container-1">
        <i class='bx bx-cart'></i>
    </div>
    <div class="container-2 my-2">
        <p class="toast-sta"></p>
        <p class="toast-msg"></p>
    </div>
    <button id="close">
        <i class='bx bx-x'></i>
    </button>
  </div>
</div>

<script src="{{ asset('client/js/quantity-btn.js') }}"></script>
@endif
@endsection
