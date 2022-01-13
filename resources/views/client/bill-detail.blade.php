@extends('client.layouts.master')
@section('main')

@php
    $isEnable = $bill->status == "Đã giao hàng";
    $pointer = "cursor: pointer";
@endphp

<div class="__container __cart">
    <div class="fs-1 fw-bold mt-5">Thông tin đơn hàng:</div>
    <div class="row border p-3 mx-1 my-4">
        <div class="col-md-4 col-12">
            <div class="px-4 py-3 py-sm-4 row fs-3">
                <div class="col-6"> Mã đơn hàng: </div>
                <div class="col-6">  #{{$bill->id}} </div>
            </div>
            <div class="px-4 pb-3 py-sm-4 row fs-3">
                <div class="col-6"> Loại thanh toán: </div>
                <div class="col-6"> {{$bill->method == 'CreditCard' ? 'Thẻ tín dụng' : 'Thu hộ'}} </div>
            </div>
            <div class="px-4 pb-3 py-sm-4 row fs-3">
                <div class="col-6"> Số thẻ Visa: </div>
                <div class="col-6"> {{$bill->card->number ?? 'Không có'}} </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="px-4 pb-3 py-sm-4 row fs-3">
                <div class="col-6"> Voucher: </div>
                <div class="col-6 __break-word-dots"> {{$bill->voucher->code ?? 'Không có'}} </div>
            </div>
            <div class="px-4 pb-3 py-sm-4 row fs-3">
                <div class="col-6"> Ngày đặt hàng: </div>
                <div class="col-6"> {{date('d/m/Y',strtotime($bill->created_at))}} </div>
            </div>
            <div class="px-4 pb-3 py-sm-4 row fs-3">
                <div class="col-6"> Ngày giao hàng: </div>
                <div class="col-6"> 
                    {{$bill->delivery_at == null 
                    ? 'Chưa cập nhật'
                    : date('d/m/Y',strtotime($bill->delivery_at))
                    }} 
                </div>
            </div>
        </div>

        <div class="col-md-4 col-12">
            <div class="px-4 pb-3 py-sm-4 row fs-3">
                <div class="col-6"> Tình trạng: </div>
                <div class="col-6"> {{$bill->status}} </div>
            </div>
            <div class="px-4 pb-3 py-sm-4 __break-word-dots">Ghi chú: {{$bill->notes}}</div>
        </div>
    </div>


    <div class="fs-1 fw-bold mt-5">Danh sách sản phẩm:</div>
    <table class="my-4" id="product-table">
        <tr>
            <th class="col-md-1 col-1 py-4 text-center">STT</th>
            <th class="col-md-4 col-3 py-4 text-center">Sản phẩm</th>
            <th class="col-md-2 d-none d-md-table-cell text-center"> Phân loại </th>
            <th class="col-md-2 col-2 text-center">Số lượng </th>
            <th class="col-md-1 col-3 text-center">Đơn giá </th>
            <th class="col-md-2 col-3 text-center">Thành tiền</th>
        </tr>
        @php
            $count = 1;
        @endphp
        @foreach ($bill->bill_detail as $detail)
        @php
            $isRated = false;
            $ratedStar = -1;
            foreach ($bill->rating as $rate) {
                if ($rate->product_id == $detail->product_id) {
                    $isRated = true;
                    $ratedStar = $rate->star;
                    break;
                }
            }
        @endphp
            <tr style="{{$isEnable == true ? $pointer : ''}}" class="border" data-enable="{{$isEnable}}" data-product="{{ $detail->product_id }}" data-receipt="{{ $detail->bill_id }}" data-rated="{{$isRated}}" data-rated-star="{{$ratedStar == -1 ? '' : $ratedStar}}">
                <td class="col-md-1 col-1 text-center">{{ $count }}</td>
                <td class="col-md-4 col-3">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                          <img src="{{asset('images/products/' . $detail->item->main_pic->url)}}" alt="{{$detail->item->main_pic->alt}}">
                        </div>
                        <div class="d-md-flex d-none d-md-table-cell align-items-center col-sm-9">
                            <p class="text-break fs-2"> {{$detail->item->name}}</p>
                        </div>
                    </div>
                </td>
                <td class="col-md-1 text-center d-none d-md-table-cell">{{$detail->item->category->name}}</td>
                <td class="col-md-2 col-2 text-center">{{$detail->quantity}}</td>
                <td class="col-md-1 col-3 text-center">{{number_format(round($detail->unit_price), 0, ",", ".")}}đ</td>
                <td class="col-md-2 col-3 text-center">{{number_format(round($detail->unit_price * $detail->quantity), 0, ",", ".")}}đ</td>
            </tr>
          @php
              $count++;
          @endphp  
       @endforeach   
    </table>

    <div class="d-flex justify-content-end my-4">
        <div class="col-sm-8 col-md-6 col-12">
        </div>

        <div class="col-sm-4 col-md-6 col-12">
            <table class="fs-3">
                <tr class="border-top border-dark">
                    <td>Tổng tiền hàng:</td>
                    <td>{{number_format(round($bill->totalPrice), 0, ",", ".")}}đ</td>
                </tr>
                <tr>
                    <td>Giảm giá hóa đơn:</td>
                    <td>{{number_format(round($bill->totalDiscount), 0, ",", ".")}}đ</td>
                </tr>
                <tr>
                    <td>Giảm giá voucher:</td>
                    <td>{{$bill->voucher != null ? number_format(round($bill->voucher->discount), 0, ",", ".") : 0}}đ</td>
                </tr>
                <tr>
                    <td>Chi phí vận chuyển:</td>
                    <td>{{number_format(round($bill->shippingCost), 0, ",", ".")}}đ</td>
                </tr>
                <tr>
                    <td>Thành tiền:</td>
                    <td class="fs-2 fw-bold">{{number_format(round($bill->totalPay), 0, ",", ".")}}đ</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@if ($isEnable)
    <div class="__popup-rating" data-href="{{route('rating')}}">
        <span class="helper"></span>
        <div>
            <div class="__popup-close __popup-rating-close">&times;</div>

            <div class="fs-2 fw-bold">Đánh giá sản phẩm</div>
            <!-- Rating Stars Box -->
            <div class='__rating-stars'>
                <ul id='stars'>
                    <li class='__star' title='Tệ' data-value='1'>
                        <i class='bx bx-star'></i>
                    </li>
                    <li class='__star' title='Trung bình' data-value='2'>
                        <i class='bx bx-star'></i>
                    </li>
                    <li class='__star' title='Tốt' data-value='3'>
                        <i class='bx bx-star'></i>
                    </li>
                    <li class='__star' title='Rất tốt' data-value='4'>
                        <i class='bx bx-star'></i>
                    </li>
                    <li class='__star' title='Xuất sắc' data-value='5'>
                        <i class='bx bx-star'></i>
                    </li>
                </ul>
            </div>
            <button class="_btn _submit-rating">Lưu đánh giá</button>
        </div>
    </div>

    <div class="__popup-rated">
        <span class="helper"></span>
        <div>
            <div class="__popup-close __popup-rated-close">&times;</div>

            <div class="fs-2 fw-bold">Đánh giá sản phẩm</div>
            <!-- Rating Stars Box -->
            <div style="padding: 1rem 2rem">
                <div>Bạn đã thực hiện đánh giá cho sản phẩm này</div>
            </div>
        </div>
    </div>

    <div class="__wrapper" id="toast_success">
        <div id="toast">
            <div class="container-1">
                <i class='bx bxs-bookmark-star'></i>
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
@endif

<script src="{{ asset('client/js/popup-rating.js') }}"></script>
@endsection