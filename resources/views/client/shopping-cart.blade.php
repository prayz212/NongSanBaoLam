@extends('client.layouts.master')
@section('main')

<div class="__container __cart">
    <table>
        <tr>
            <th class="col-md-1 d-none d-sm-table-cell text-center">STT</th>
            <th class="col-md-4 col-5 py-4 text-center">Sản phẩm</th>
            <th class="col-md-2 d-none d-sm-table-cell text-center">Phân loại</th>
            <th class="col-md-1 col-4 text-center">Số lượng</th>
            <th class="col-md-2 col-2 text-center">Số tiền</th>
            <th class="col-md-2 col-1 text-center">Thao tác</th>
        </tr>
        @if ($carts and count($carts->items))
          @php
            $i = 1;
            $totalPrice = 0;
            $emptyCart = false;
          @endphp
          @foreach($carts->items as $c)
            <tr class="border items_tr" data-id="{{ $c['item']->id }}">
                <td class="col-md-1 text-center d-none d-md-table-cell">
                  <div> {{ $i }} </div>
                </td>
                <td class="col-sm-4 col-5" onclick="location.href ='{{ url('chi-tiet-san-pham/' . $c['item']->id ) }}'" style="cursor: pointer">
                    <div class="__cart-info row">
                        <div class="col-12 col-sm-3 px-4 px-sm-0">
                            <img src="{{ asset('images/products/' . $c['item']->main_pic->url) }}" alt="{{ $c['item']->main_pic->name }}">
                        </div>
                        <div class="d-sm-flex d-none align-items-center col-0 col-sm-9">
                            <div class="d-flex align-items-center">
                                <a href="{{ url('chi-tiet-san-pham/' . $c['item']->id ) }}" class="fs-2"><p class="text-break"></p> {{ $c['item']->name }} </a>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="col-sm-2 text-center d-none d-sm-table-cell">{{ $c['item']->category->name }}</td>
                @php
                  $finalPrices = $c['item']->price - ($c['item']->price * ($c['item']->discount ?? 0)/100);
                @endphp
                <td class="col-md-2 col-sm-3 col-4">
                  <div class="d-flex justify-content-center align-items-center qty btn_added">
                    <input type="button" value="+" class="__quantity-plus">
                    <input type="number" data-unit-price="{{ $finalPrices }}" value="{{ $c['qty'] }}" step="1" min="1" max="" class="_form-input text-center px-0" onchange="changeItemPrice(this)" style="margin: 0px 4px 0px 4px; max-width: 6rem;">
                    <input type="button" value="-"  class="__quantity-minus">
                  </div>
                </td>
                <td class="col-md-2 col-sm-2 col-1 text-center">
                    <div class="items_price">{{ number_format($c['qty'] * $finalPrices, 0, ",", ".") }}đ</div>
                </td>
                <td class="col-md-1 col-sm-1 col-2">
                    <div class="d-flex justify-content-center">
                        <a data-href="{{ url('xoa-khoi-gio-hang') }}" style="cursor: pointer" class="text-decoration-none text-center remove-item-from-cart">Xóa</a>
                    </div>
                </td>
            </tr> 
            @php
              $i++;
              $totalPrice += ($c['qty'] * $finalPrices);
            @endphp
          @endforeach
        @else
        @php
            $emptyCart = true;
        @endphp
        <tr>
          <td colspan="6" class="text-center border h4">Giỏ hàng rỗng, bạn chưa chọn mua sản phẩm nào.</td>
        </tr>
        @endif
    </table>
    @if (Session::has('cart-error'))
    <div class="p-3 d-flex flex-row-reverse">
      <div id="error-msg-cart" class="text-danger">{{ Session::get('cart-error') }}</div>
    </div>
    @endif
    <div class="d-flex flex-row-reverse align-items-center">
      <div style="min-width: fit-content">
        @if (Auth::check()) 
        <a style="cursor: pointer" id="cart-submit" data-href-check="{{ route('checkQuantity') }}" data-href-redirect="{{ route('payment') }}" class="checkout _btn text-light d-flex justify-content-center {{ $emptyCart ? '__disabled-btn' : '' }}" {{ $emptyCart ? 'disabled' : '' }}>Mua hàng</a>
        @else  
        <a href="{{ route('authenticatepage') }}" class="checkout _btn text-light d-flex justify-content-center">Đăng nhập</a>
        @endif
      </div>
      <div class="mx-4">
        Tổng thành tiền: <b class="fs-1 text-primary" id="total-price" data-total="{{ $totalPrice ?? 0 }}">{{ number_format($totalPrice ?? 0, 0, ",", ".") }}đ</b>
      </div>
    </div>
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

<script>
  var cbTimeout;
  function changeItemPrice(_this) {
    if (cbTimeout) {
      clearTimeout(cbTimeout);
    }

    const preQuantity = parseInt(_this.getAttribute("value"))
    const quantity = parseInt($(_this).val())
    if (preQuantity == quantity) return
    _this.setAttribute('value', quantity)
    
    const unitPrice = parseInt($(_this).attr('data-unit-price'));
    const preTotal = preQuantity * unitPrice;
    const newTotal = quantity * unitPrice;

    var pricesElement = $(_this).closest('.items_tr').find("td:nth-child(5)").children(":first")
    pricesElement.text(newTotal.toLocaleString('it-IT', { currency: 'VND' }) + "đ")

    const preTotalPrice = parseInt($('#total-price').attr('data-total'));
    const newTotalPrice = preTotalPrice - preTotal + newTotal;

    $('#total-price').attr('data-total', newTotalPrice)
    $('#total-price').text(newTotalPrice.toLocaleString('it-IT', { currency: 'VND' }) + "đ")

    cbTimeout = setTimeout(function() {
      updateQty($(_this).closest('.items_tr').attr('data-id'), quantity)
    }, 600);
  }

  function updateQty(id, quantity) {
    var url = '{{ url('cap-nhat-so-luong' )}}'
    var data = {
      id, quantity
    }

    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url,
        data ,
        success: function (data) {
            if (data.status == 200) {
                console.log("updated")
            } else {
                console.log("failed")
            }
        },
        error: function() {
          console.log("failed")
        }
    });
  }

  //plus - minus button
  function wcqib_refresh_quantity_increments() {
    jQuery(
        "div.qty:not(.btn_added), td.qty:not(.btn_added)"
    ).each(function (a, b) {
        var c = jQuery(b);
        c.addClass("btn_added"),
            c
                .children()
                .first()
                .before('<input type="button" value="-" class="__quantity-minus" />'),
            c
                .children()
                .last()
                .after('<input type="button" value="+" class="__quantity-plus" />');
    });
}
String.prototype.getDecimals ||
    (String.prototype.getDecimals = function () {
        var a = this,
            b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
        return b
            ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0))
            : 0;
    }),
    jQuery(document).ready(function () {
        wcqib_refresh_quantity_increments();
    }),
    jQuery(document).on("updated_wc_div", function () {
        wcqib_refresh_quantity_increments();
    }),
    jQuery(document).on("click", ".__quantity-plus, .__quantity-minus", function () {
        var a = jQuery(this).closest(".qty").find("._form-input"),
            b = parseFloat(a.val()),
            c = parseFloat(a.attr("max")),
            d = parseFloat(a.attr("min")),
            e = a.attr("step");
        (b && "" !== b && "NaN" !== b) || (b = 0),
            ("" !== c && "NaN" !== c) || (c = ""),
            ("" !== d && "NaN" !== d) || (d = 0),
            ("any" !== e &&
                "" !== e &&
                void 0 !== e &&
                "NaN" !== parseFloat(e)) ||
                (e = 1),
            jQuery(this).is(".__quantity-plus")
                ? c && b >= c
                    ? a.val(c)
                    : a.val((b + parseFloat(e)).toFixed(e.getDecimals()))
                : d && b <= d
                ? a.val(d)
                : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())),
            a.trigger("change");
    });
</script>
@endsection