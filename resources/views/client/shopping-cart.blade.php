@extends('client.layouts.master')
@section('main')

<div class="__container __cart">
  <form asp-controller="Cart" asp-action="" id="paymentForm">
      <table>
          <tr>
              <th class="col-md-1 d-none d-sm-table-cell text-center">STT</th>
              <th class="col-md-4 col-7 py-4 text-center">Sản phẩm</th>
              <th class="col-md-2 text-center"><div class="d-none d-md-block"> Phân loại </div></th>
              <th class="col-md-1 col-2 text-center">Số lượng</th>
              <th class="col-md-2 col-2 text-center">Số tiền</th>
              <th class="col-md-2 col-1 text-center">Thao tác</th>
          </tr>
          @if ($carts and count($carts->items))
            @php
              $i = 1;
              $totalPrice = 0;
            @endphp
            @foreach($carts->items as $c)
               <tr class="border items_tr" data-id="{{ $c['item']->id }}">
                  <td class="col-md-1 text-center d-none d-sm-table-cell">
                    <div> {{ $i }} </div>
                  </td>
                  <td class="col-md-4 col-7" onclick="location.href ='{{ url('chi-tiet-san-pham/' . $c['item']->id ) }}'" style="cursor: pointer">
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
                  <td class="col-md-2 text-center"><div class="d-none d-md-block"> {{ $c['item']->category->name }} </div></td>
                  <td class="col-md-1 col-2">
                      <div class="d-flex justify-content-center">
                          <input type="number" name="items_quantity[]" data-unit-price="{{ $c['item']->price }}" value="{{ $c['qty'] }}" min="1" class="_form-input text-center px-0" onchange="changeItemPrice(this)">
                      </div>
                  </td>
                  <td class="col-md-2 col-2 text-center">
                      <div class="items_price">{{ number_format($c['qty'] * $c['item']->price, 0, ",", ".") }}đ</div>
                      {{-- <div>{{ number_format($c['qty'] * $c['item']->price, 0) }}đ</div> --}}
                  </td>
                  <td class="col-md-2 col-2">
                      <div class="d-flex justify-content-center">
                          <a data-href="{{ url('xoa-khoi-gio-hang') }}" style="cursor: pointer" class="text-decoration-none text-center remove-item-from-cart">Xóa</a>
                      </div>
                  </td>
              </tr> 
              @php
                $i++;
                $totalPrice += ($c['qty'] * $c['item']->price);
              @endphp
            @endforeach
          @else
          <tr>
            <td colspan="6" class="text-center border h4">Giỏ hàng rỗng, bạn chưa chọn mua sản phẩm nào.</td>
          </tr>
          @endif
      </table>
  </form>

  <div class="d-flex flex-row-reverse align-items-center">
    <div style="min-width: fit-content">
      <button id="payment_btn" class="checkout _btn text-light d-flex justify-content-center">Mua hàng</button>
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
    }, 1500);
  }

  function updateQty(id, quantity) {
    // var form = $(this);
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
    });
  }
</script>






@endsection