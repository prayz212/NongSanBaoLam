@extends('client.layouts.master')
@section('main')

<!-- All Products -->
<div class="container __section __product-container">
  <div class="row">
      <div class="mb-3 col-lg-3 col-sm-5 col-12 __category-block">
          <div class="card bg-light mb-3">
              <div class="card-header text-uppercase py-3 text-center __category-block-title">DANH MỤC SẢN PHẨM</div>
              <ul class="list-group category_block">
                <a asp-action="Index" asp-route-searchByName="@ViewBag.searchByName" asp-route-filter="Áo thun tay ngắn" asp-route-sortBy="@ViewBag.sortBy"><li class="list-group-item px-5 py-3">Rau củ hữu cơ</li></a>
                  <a ><li class="list-group-item px-5 py-3">Rau củ Đà Lạt</li></a>
                  <a ><li class="list-group-item px-5 py-3">Rau củ ngoại nhập</li></a>
                  <a ><li class="list-group-item px-5 py-3">Trái cây Đà Lạt</li></a>
                  <a ><li class="list-group-item px-5 py-3">Trái cây ngoại nhập</li></a>
                  <a ><li class="list-group-item px-5 py-3">Combo trái cây</li></a>
              </ul>
          </div>
      </div>

      <div class="col-lg-9 col-sm-7 col-12">
          <div class="row">
              <section class="__all-products" id="products">
                  <div class="__top">
                      <h1>Tất cả sản phẩm</h1>
                      <select name="sortBy" id="sortBy">
                          <option value="name_asc">
                              Tên: A đến Z
                          </option>
                          <option value="name_desc">
                              Tên: Z đến A
                          </option>
                          <option value="price_asc">
                              Giá: Thấp đến Cao
                          </option>
                          <option value="price_desc">
                              Giá: Cao đến Thấp
                          </option>
                          <option value="rating_asc">
                              Đánh giá: Thấp đến Cao
                          </option>
                          <option value="rating_desc">
                              Đánh giá: Cao đến Thấp
                          </option>
                          <span><i class='bx bx-chevron-down'></i></span>
                      </select>
                  </div>

                  <div class="__product-center px-3">
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
</div>
@endsection