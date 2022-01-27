@extends('client.layouts.master')
@section('main')

<!-- All Products -->
<div class="container __section __product-container">
  <div class="row">
      <div class="mb-3 col-lg-3 col-sm-5 col-12 __category-block">
          <div class="card mb-3">
              <div class="card-header text-uppercase py-3 text-center __category-block-title">DANH MỤC SẢN PHẨM</div>
              <ul class="list-group category_block">
                  <a href="{{ url('the-loai-san-pham/trai-cay-da-lat') }}"><li class="list-group-item px-5 py-3 {{ request()->type == 'trai-cay-da-lat' ? '__selected-category' : '' }}">Trái cây Đà Lạt</li></a>
                  <a href="{{ url('the-loai-san-pham/trai-cay-ngoai-nhap') }}"><li class="list-group-item px-5 py-3 {{ request()->type == 'trai-cay-ngoai-nhap' ? '__selected-category' : '' }}">Trái cây ngoại nhập</li></a>
                  <a href="{{ url('the-loai-san-pham/rau-cu-huu-co') }}"><li class="list-group-item px-5 py-3 {{ request()->type == 'rau-cu-huu-co' ? '__selected-category' : '' }}">Rau củ hữu cơ</li></a>
                  <a href="{{ url('the-loai-san-pham/rau-cu-da-lat') }}"><li class="list-group-item px-5 py-3 {{ request()->type == 'rau-cu-da-lat' ? '__selected-category' : '' }}">Rau củ Đà Lạt</li></a>
                  <a href="{{ url('the-loai-san-pham/rau-cu-ngoai-nhap') }}"><li class="list-group-item px-5 py-3 {{ request()->type == 'rau-cu-ngoai-nhap' ? '__selected-category' : '' }}">Rau củ ngoại nhập</li></a>
                  <a href="{{ url('the-loai-san-pham/combo-san-pham') }}"><li class="list-group-item px-5 py-3 {{ request()->type == 'combo-san-pham' ? '__selected-category' : '' }}">Combo sản phẩm</li></a>
              </ul>
          </div>
      </div>

      <div class="col-lg-9 col-sm-7 col-12">
          <div class="row">
              <section class="__all-products" id="products">
                  <div class="__top">
                      <h1>Tất cả sản phẩm</h1>
                      <select name="sortBy" id="sortBy">
                          @php
                            $currentFilter = request()->filter ?? '';
                          @endphp
                        <option value="" {{ $currentFilter == '' ? 'selected' : '' }} disabled hidden>
                            Lọc sản phẩm
                        </option>
                          <option value="a-z" {{ $currentFilter == 'a-z' ? 'selected' : '' }}>
                              Tên: A đến Z
                          </option>
                          <option value="z-a" {{ $currentFilter == 'z-a' ? 'selected' : '' }}>
                              Tên: Z đến A
                          </option>
                          <option value="gia-tang-dan" {{ $currentFilter == 'gia-tang-dan' ? 'selected' : '' }}>
                              Giá: Thấp đến Cao
                          </option>
                          <option value="gia-giam-dan"{{ $currentFilter == 'gia-giam-dan' ? 'selected' : '' }}>
                              Giá: Cao đến Thấp
                          </option>
                          <span><i class='bx bx-chevron-down'></i></span>
                      </select>
                  </div>

                  <div class="__product-center px-3">
                        @foreach ($products as $p)
                          <div class="__product">
                              <div class="__product-header">
                                  <img src="{{ $p->main_pic->url }}" alt="{{ $p->main_pic->name }}">
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
                                      <h3 class="__break-word-dots">{{ $p->name }}</h3>
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
                              $rank = $products->currentPage() / 5;
                              
                              if ($rank == 0.2) { $i = 0; $to = 4; }
                              else if ($rank == 0.4) { $i = -1; $to = 3; }
                              else { $i = -2; $to = 2; }
                          @endphp
                          @for ($i; $i <= $to; $i++)
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
</div>
@endsection