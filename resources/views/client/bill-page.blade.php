@extends('client.layouts.master')
@section('main')

<div class="__container __cart">
  <div class="fs-1 fw-bold mt-5">Tất cả đơn hàng:</div>
  <table class="mt-4" id="bill-table">
    <tr>
      <th class="col-md-2 col-3 text-center">Mã đơn hàng</th>
      <th class="col-md-2 col-4 text-center">Ngày đặt hàng</th>
      <th class="col-md-2 d-none d-md-table-cell text-center"> Hình thức thanh toán </th>
      <th class="col-md-2 d-none d-md-table-cell text-center"> Tổng tiền thanh toán </th>
      <th class="col-md-2 col-5 text-center">Trạng thái</th>
    </tr>
    @if (count($bills) == 0)
      <tr class="border">
        <td colspan="5" class="text-center h4">Bạn chưa thực hiện giao dịch mua hàng nào.</td>
      </tr>
    @endif
    @foreach ($bills as $bill)
      <tr class="border __bill-row" data-href={{url('chi-tiet-hoa-don/' . $bill->id)}} style="cursor: pointer">
        <td class="col-md-2 col-3 text-center fw-bold"> #{{$bill->id}} </td>
        <td class="col-md-2 col-4 text-center"> {{date('d/m/Y',strtotime($bill->created_at))}} </td>
        <td class="col-md-2 d-none d-md-table-cell text-center"> {{$bill->method == 'CreditCard' ? 'Thẻ tín dụng' : 'Thu hộ'}} </td>
        <td class="col-md-2 d-none d-md-table-cell text-center"> {{number_format(round($bill->totalPay), 0, ",", ".")}}đ </td>
        <td class="col-md-2 col-5 text-center"> {{$bill->status}} </td>
      </tr>
    @endforeach
  </table>
</div>

@endsection