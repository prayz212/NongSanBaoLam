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
                  <a class="__view-more" href="{{ url('san-pham-ban-chay') }}">Xem thêm</a>
              </div>
          </div>
          <div class="__product-center __container">
              @foreach ($bestSaler as $p)
                  <div class="__product">
                      <div class="__product-header">
                          <img src="{{ asset('images/products/' . $p->main_pic->url) }}" alt="">
                          @if ($p->discount)
                          <img style="width: 7rem; height: 5rem; position: absolute; top: 1%; right: 2%" src="{{ asset('images/sales.png') }}" alt="discount">
                          <span style="position: absolute; top: 6.5%; right: 9%; color: red; font-size: 1.4rem;">-{{$p->discount}}%</span>
                          @endif
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
                            @php
                                $avgRating = $p->avgRating->first()->rating ?? 0;
                            @endphp
                            @for ($i = 0; $i < round($avgRating); $i++)
                                <i class="bx bxs-star"></i>
                            @endfor
                            @for ($i = 0; $i < 5 - round($avgRating); $i++)
                                <i class="bx bx-star"></i>
                            @endfor
                          </div>

                          @if ($p->discount)
                          @php
                          $discountPrice = $p->price - $p->price * ($p->discount/(float)100);
                          @endphp
                          <h4 class="__price">{{ number_format(round($discountPrice), 0, ",", ".") }}đ</h4>
                          @else
                          <h4 class="__price">{{ number_format($p->price, 0, ",", ".") }}đ</h4>
                          @endif
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
                    <a class="__view-more" href="{{ url('san-pham-moi') }}">Xem thêm</a>
                </div>
            </div>

            <div class="__product-center __container">
                @foreach ($newProducts as $np)
                    <div class="__product">
                        <div class="__product-header">
                            <img src="{{ asset('images/products/' . $np->main_pic->url) }}" alt="{{ $np->main_pic->name }}">
                            @if ($np->discount)
                            <img style="width: 7rem; height: 5rem; position: absolute; top: 1%; right: 2%" src="{{ asset('images/sales.png') }}" alt="discount">
                            <span style="position: absolute; top: 6.5%; right: 9%; color: red; font-size: 1.4rem;">-{{$np->discount}}%</span>
                            @endif
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
                            @php
                                $avgRating = $np->avgRating->first()->rating ?? 0;
                            @endphp
                            @for ($i = 0; $i < round($avgRating); $i++)
                                <i class="bx bxs-star"></i>
                            @endfor
                            @for ($i = 0; $i < 5 - round($avgRating); $i++)
                                <i class="bx bx-star"></i>
                            @endfor
                            </div>

                            @if ($p->discount)
                            @php
                            $discountPrice = $np->price - $np->price * ($np->discount/(float)100);
                            @endphp
                            <h4 class="__price">{{ number_format(round($discountPrice), 0, ",", ".") }}đ</h4>
                            @else
                            <h4 class="__price">{{ number_format($np->price, 0) }}đ</h4>
                            @endif
                            
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
