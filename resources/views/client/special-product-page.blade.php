@extends('client.layouts.master')
@section('main')

<!-- All Products -->
<div class="container __section">
  <div>
      <h1>{{ $title }}</h1>
      <div class="m-5">
          <section id="products">
              <div class="__product-center">
                @foreach ($products as $p)
                <div class="__product">
                    <div class="__product-header">
                        <img src="{{ asset('images/products/' . $p->main_pic->url) }}" alt="{{ $p->main_pic->name }}">
                        @if ($p->discount)
                        <img style="width: 7rem; height: 5rem; position: absolute; top: 1%; right: 2%" src="{{ asset('images/sales.png') }}" alt="discount">
                        <span style="position: absolute; top: 6.5%; right: 9%; color: red; font-size: 1.4rem;">-{{$p->discount}}%</span>
                        @endif
                        <a href="{{ url('chi-tiet-san-pham/' . $p->id) }}">
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

              <div class="__pagination">
                <div class="">
                  @if ($products->currentPage() != 1)
                    <a href="{{ url(Request::url() . $queryString . ($products->currentPage() - 1) ) }}" class="btn shadow-none p-0">
                        <span>
                            <i class='bx bx-left-arrow-alt'></i>
                        </span>
                    </a>
                  @endif
                  @php
                      $rank = $products->lastPage() % 5 == 0 ? floor($products->lastPage() / 5 - 1) : floor($products->lastPage() / 5);
                  @endphp
                  @for ($i = 1; $i <= 5; $i++)
                      @if ($products->lastPage() != 1)
                      @php
                          $pageNumber = $i + ($rank * 5);
                          if ($pageNumber - 1 == $products->lastPage()) break;
                      @endphp
                          <a class="btn shadow-none p-0 {{$pageNumber == $products->currentPage() ? "disabled" : ""}}" href="{{ url(Request::url() . $queryString . $pageNumber ) }}">
                              <span>
                                  {{ $pageNumber }}
                              </span>
                          </a>
                      @endif
                  @endfor
                  @if ($products->currentPage() != $products->lastPage() && $products->lastPage() > 0)
                      <a class="btn shadow-none p-0" href="{{ url(Request::url() . $queryString . ($products->currentPage() + 1) ) }}">
                          <span>
                              <i class='bx bx-right-arrow-alt'></i>
                          </span>
                      </a>
                  @endif
                </div>
              </div>
          </section>
      </div>
  </div>
</div>
@endsection