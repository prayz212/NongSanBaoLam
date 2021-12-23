@extends('client.layouts.master')
@section('main')

<div class="mb-5 pb-5">
  @include('client.includes.advert_top')

  <!-- Featured -->
  @if (count($bestSaler) > 0)
      <section class="__feature-section __featured">
          <div class="__title">
              <h1>Sản phẩm bán chạy</h1>
              <div>
                  <a class="__view-more">Xem thêm</a>
              </div>
          </div>
          <div class="__product-center __container">
              @foreach ($bestSaler as $p)
                  <div class="__product">
                      <div class="__product-header">
                          <img src="{{ asset('images/products/' . $p->main_pic->url) }}" alt="">
                          <a href="{{ url('chi-tiet-san-pham/' . $p->id) }}" >
                              <ul class="icons">
                                  <span><i class='bx bxs-show show-icons'></i></span>
                              </ul>
                          </a>
                      </div>
                      <div class="__product-footer">
                          <a href="{{ url('chi-tiet-san-pham/' . $p->id) }}">
                              <h3>{{ $p->name }}</h3>
                          </a>
                          <div class="__rating">
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star"></i>
                            <i class="bx bxs-star"></i>
{{--                               @for (int i = 0; i < item.ratings; i++)--}}
{{--                              {--}}
{{--                                  <i class="bx bxs-star"></i>--}}
{{--                              }--}}

{{--                              @for (int i = 0; i < 5 - item.ratings; i++)--}}
{{--                              {--}}
{{--                                  <i class="bx bx-star"></i>--}}
{{--                              }--}}
                          </div>
                          <h4 class="__price">{{ number_format($p->price, 0, ",", ".") }}đ</h4>
                      </div>
                  </div>
              @endforeach

          </div>
      </section>
  @endif

      <!--Latest -->
    @if (count($newProducts) > 0)
        <section class="__feature-section __featured">
            <div class="__title">
                <h1>Sản phẩm mới</h1>
                <div>
                    <a class="__view-more">Xem thêm</a>
                </div>
            </div>

            <div class="__product-center __container">
                @foreach ($newProducts as $np)
                    <div class="__product">
                        <div class="__product-header">
                            <img src="{{ asset('images/products/' . $np->main_pic->url) }}" alt="{{ $np->main_pic->name }}">
                            <a href="{{ url('chi-tiet-san-pham/' . $np->id) }}">
                                <ul class="icons">
                                    <span><i class='bx bxs-show show-icons'></i></span>
                                </ul>
                            </a>
                        </div>
                        <div class="__product-footer">
                            <a href="{{ url('chi-tiet-san-pham/' . $np->id) }}">
                                <h3>{{ $np->name }}</h3>
                            </a>
                            <div class="__rating">
                                <i class="bx bxs-star"></i>
                                <i class="bx bxs-star"></i>
                                <i class="bx bxs-star"></i>
                                <i class="bx bxs-star"></i>
                                <i class="bx bxs-star"></i>
                                {{-- @for (int i = 0; i < item.ratings; i++)
                                {
                                    <i class="bx bxs-star"></i>
                                }

                                @for (int i = 0; i < 5 - item.ratings; i++)
                                {
                                    <i class="bx bx-star"></i>
                                } --}}
                            </div>
                            <h4 class="__price">{{ number_format($np->price, 0) }}đ</h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

      @include('client.includes.advert_bottom')

      @include('client.includes.feedback')
  </div>

@endsection
