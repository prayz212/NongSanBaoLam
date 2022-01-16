@extends('client.layouts.master')
@section('main')

<div class="container __payment-page pt-5">
  <form method="post" action = {{ route('postPayment') }}>
    @csrf
      <div class="row mb-sm-0 mb-5">
          <div class="col-sm-8 col-md-7 col-12 border-end">
              <div class="mx-4 mr-sm-5">
                  <div class="fs-1 fw-bold mb-3">Thông tin thanh toán</div>

                  <div class="row">
                      <div class="col-lg-8 col-md-8 col-sm-12">
                          <input name="fullname" class="_form-input" type="text" placeholder="Họ tên" value="{{ old('fullname') ? old('fullname') : $customer->fullname ?? '' }}">
                          <div class="__notify-msg" style="font-size: smaller; color: red; margin-left: 5px;">{{ $errors->first('fullname') ?? '' }}</div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-12">
                          <input name="phone" class="_form-input" type="text" placeholder="Số điện thoại" value="{{ old('phone') ? old('phone') : $customer->phone ?? '' }}">
                          <div class="__notify-msg" style="font-size: smaller; color: red; margin-left: 5px;">{{ $errors->first('phone') ?? '' }}</div>
                      </div>
                  </div>

                  <input name="email" class="_form-input" type="text" placeholder="Email" value="{{ old('email') ? old('email') : $customer->email ?? '' }}">
                  <div class="__notify-msg" style="font-size: smaller; color: red; margin-left: 5px;">{{ $errors->first('email') ?? '' }}</div>
                  <input name="address" class="_form-input" type="text" placeholder="Địa chỉ" value="{{ old('address') ? old('address') : $customer->address ?? '' }}">
                  <div class="__notify-msg" style="font-size: smaller; color: red; margin-left: 5px;">{{ $errors->first('address') ?? '' }}</div>

                  <input name="notes" class="_form-input" type="text" placeholder="Ghi chú (Ví dụ: Giao giờ hành chính)" value="{{ old('notes') ?? '' }}">
                  @php
                    if (old('paymentType') == null) {
                        if ($errors->first('cardNumber') != null || $errors->first('validDate') != null || $errors->first('secretNumber') != null) {
                            $currentMethod = "CreditCard";
                        }
                        else {
                            $currentMethod = old('paymentType');
                        }
                    } else {
                        $currentMethod = old('paymentType');
                    }
                  @endphp
                  {{old('paymentType')}}
                  <div class="fs-1 fw-bold mt-4 mb-3">Hình thức thanh toán</div>
                  <div class="px-3">
                      <input id="payment-method" hidden value="{{ $currentMethod ?? 'COD' }}">
                      <div class="form-check form-check-inline col-6">
                          <input class="form-check-input" type="radio" name="paymentType" id="COD" {{ $currentMethod ?? 'COD' == 'COD' ? 'checked' : '' }} value="COD">
                          <label class="form-check-label" for="COD">
                              COD
                          </label>
                      </div>
                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="paymentType" id="CreditCard" {{ $currentMethod ?? 'COD' == 'CreditCard' ? 'checked' : '' }} value="CreditCard">
                          <label class="form-check-label" for="CreditCard">
                              Thẻ tín dụng
                          </label>
                      </div>
                      <div class="__notify-msg" style="font-size: smaller; color: red; margin-left: 5px;">{{ $errors->first('paymentType') ?? '' }}</div>
                  </div>
                  <div class="__payment-info">
                      <div id="COD-info" class="fs-3 mt-3 mb-4">
                          Khách hàng sẽ thanh toán khi nhận được hàng từ đơn vị vận chuyển
                      </div>
                      <div id="CreditCard-info" class="mt-3 mb-4">
                          <input name="cardNumber" class="_form-input" type="text" placeholder="Số thẻ" value="{{ old('cardNumber') ?? '' }}">
                          <div class="__notify-msg" style="font-size: smaller; color: red; margin-left: 5px;">{{ $errors->first('cardNumber') ?? '' }}</div>
                          <div class="row">
                              <div class="col-12 col-sm-6">
                                  <input name="validDate" class="_form-input" type="date" placeholder="Ngày hết hạn" value="{{ old('validDate') ?? '' }}">
                                  <div class="__notify-msg" style="font-size: smaller; color: red; margin-left: 5px;">{{ $errors->first('validDate') ?? '' }}</div>
                              </div>
                              <div class="col-12 col-sm-6">
                                  <input name="secretNumber" class="_form-input" type="text" placeholder="CVV/CVV2" value="{{ old('secretNumber') ?? '' }}">
                                  <div class="__notify-msg" style="font-size: smaller; color: red; margin-left: 5px;">{{ $errors->first('secretNumber') ?? '' }}</div>
                              </div>
                          </div>

                          @if (Session::has('payment-error'))
                          <div class="text-danger pt-2" style="margin-left: 3px">
                              {{ Session::get('payment-error') }}
                          </div>
                          @endif
                      </div>
                  </div>

                  <div class="fs-1 fw-bold mb-3">Voucher giảm giá</div>

                  <div class="row mb-4">
                      <div class="col-lg-8 col-md-7 col-sm-12">
                          <input id="voucher-input" name="voucher" class="_form-input" type="text" placeholder="Mã voucher" value="{{ old('voucher') ?? '' }}">
                      </div>
                      <div class="col-lg-4 col-md-5 col-sm-12">
                          <button id="voucher-btn" type="button" style="padding-top: 6px;padding-bottom: 6px;" class="_btn fs-3 w-100" data-href="{{ url('kiem-tra-voucher' )}}">Áp dụng</button>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-sm-4 col-md-5 col-12">
              <div class="mx-4 mx-sm-3">
                  <div class="fs-1 fw-bold">Giỏ hàng</div>
                  <table>
                      <tr>
                        <td class="fs-3">Tổng tiền hàng</td>
                        <td id="total-price-amount" data-amount="{{ $totalPrice }}">{{ number_format($totalPrice, 0, ",", ".") }}đ</td>
                      </tr>
                      <tr id="total-discount-tr">
                        <td class="fs-3">Chiết khấu</td>
                        <td id="total-discount-amount" class="fs-3" data-amount="{{ $totalDiscount }}">{{ number_format($totalDiscount, 0, ",", ".") }}đ</td>
                      </tr>
                      <tr>
                        <td class="fs-3">Voucher giảm giá</td>
                        <td id="voucher-amount" class="fs-3" data-amount="0">0đ</td>
                      </tr>
                      <tr>
                        <td class="fs-3">Phí giao hàng</td>
                        <td id="shipping-cost-amount"class="fs-3" data-amount="{{ $shippingCost }}">{{ number_format($shippingCost, 0, ",", ".") }}đ</td>
                      </tr>
                      <tr class="border-top">
                        <td class="fs-3">Tổng</td>
                        <td id="total-pay-amount" class="fs-2 fw-bold">{{ number_format($totalPrice - $totalDiscount + $shippingCost, 0, ",", ".") }}đ</td>
                      </tr>
                  </table>
                  <div class="">
                      <button type="submit" class="_btn fs-3 w-100">Thanh toán</button>
                  </div>
              </div>
          </div>
      </div>
  </form>
</div>

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
@endsection

