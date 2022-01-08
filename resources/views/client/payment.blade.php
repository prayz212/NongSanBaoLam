@extends('client.layouts.master')
@section('main')

<div class="container __payment-page pt-5">
  <form method="post">
      <div class="row mb-sm-0 mb-5">
          <div class="col-sm-8 col-12 border-end">
              <div class="mx-4 mx-sm-5">
                  <div class="fs-1 fw-bold mb-3">Thông tin thanh toán</div>

                  <div class="row">
                      <div class="col-lg-8 col-md-8 col-sm-12">
                          <input name="fullname" class="_form-input" type="text" placeholder="Họ tên" value="{{ old('fullname') ? old('fullname') : $customer->fullname ?? '' }}">
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-12">
                          <input name="phone" class="_form-input" type="text" placeholder="Số điện thoại" value="{{ old('phone') ? old('phone') : $customer->phone ?? '' }}">
                      </div>
                  </div>

                  <input name="email" class="_form-input" type="text" placeholder="Email" value="{{ old('email') ? old('email') : $customer->email ?? '' }}">
                  <input name="address" class="_form-input" type="text" placeholder="Địa chỉ" value="{{ old('address') ? old('address') : $customer->address ?? '' }}">

                  <input name="notes" class="_form-input" type="text" placeholder="Ghi chú (Ví dụ: Giao giờ hành chính)" value="{{ old('notes') ?? '' }}">

                  <div class="fs-1 fw-bold mt-4 mb-3">Hình thức thanh toán</div>
                  <div class="px-3">
                      <input id="payment-method" hidden value="{{ old('method') ?? 'COD' }}">
                      <div class="form-check form-check-inline col-6">
                          <input class="form-check-input" type="radio" name="paymentType" id="COD" {{ old('method') ?? 'COD' == 'COD' ? 'checked' : '' }} value="COD">
                          <label class="form-check-label" for="COD">
                              COD
                          </label>
                      </div>
                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="paymentType" id="CreditCard" {{ old('method') ?? 'COD' == 'CreditCard' ? 'checked' : '' }} value="CreditCard">
                          <label class="form-check-label" for="CreditCard">
                              Thẻ tín dụng
                          </label>
                      </div>
                  </div>
                  <div class="__payment-info">
                      <div id="COD-info" class="fs-3 mt-3 mb-4">
                          Khách hàng sẽ thanh toán khi nhận được hàng từ đơn vị vận chuyển
                      </div>
                      <div id="CreditCard-info" class="mt-3 mb-4">
                          <input name="cardNumber" class="_form-input" type="text" placeholder="Số thẻ">
                          <div class="row">
                              <div class="col-6">
                                  <input name="validDate" class="_form-input" type="date" placeholder="Ngày hết hạn">
                              </div>
                              <div class="col-6">
                                  <input name="secretNumber" class="_form-input" type="text" placeholder="CVV/CVV2">
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="fs-1 fw-bold mb-3">Voucher giảm giá</div>

                  <div class="row mb-4">
                      <div class="col-lg-8 col-md-8 col-sm-12">
                          <input id="voucher-input" name="voucher" class="_form-input" type="text" placeholder="Mã voucher" value="{{ old('voucher') ?? '' }}">
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-12">
                          <button id="voucher-btn" type="button" style="padding-top: 6px;padding-bottom: 6px;" class="_btn fs-3 w-100" data-href="{{ url('kiem-tra-voucher' )}}">Áp dụng</button>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-sm-4 col-12">
              <div class="mx-4 mx-sm-3">
                  <div class="fs-1 fw-bold">Giỏ hàng</div>
                  <table>
                      <tr>
                        <td class="fs-3">Tổng tiền hàng</td>
                        <td id="total-price-amount" data-amount="{{ $totalPrice }}">{{ number_format($totalPrice, 0, ",", ".") }}đ</td>
                      </tr>
                      <tr id="total-discount-tr">
                        <td class="fs-3">Tổng đã giảm</td>
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

