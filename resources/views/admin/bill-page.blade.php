@extends('admin.layouts.master')
@section('main')

<main>
    <div class="container-fluid px-4">
        <h4 class="my-4">Quản lý hóa đơn</h4>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Danh sách hóa đơn
            </div>
            <div class="card-body">
                <table id="billTables">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Họ tên người nhận</th>
                            <th>Số điện thoại</th>
                            <th>Ngày đặt hàng</th>
                            <th>Ngày giao hàng</th>
                            <th>Hình thức thanh toán</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bills as $bill)
                        
                        <!-- <tr style="cursor: pointer" onclick="location.href = '@(Url.Action("Details", "Receipt", new { id = receipt.ID }))'"> -->
                        <tr style="cursor: pointer" onclick="window.location = '{{ route('adminBillDetail', ['id' => $bill->id]) }}'">
                            <td>{{ $bill->id}}</td>
                            <td>{{ $bill->fullname }}</td>
                            <td>{{ $bill->phone }}</td>
                            <td>{{ date('d/m/Y',strtotime($bill->created_at)) }}</td>
                            <td>{{ $bill->deliveryAt != NULL ? date('d/m/Y',strtotime($bill->deliveryAt)) : $bill->status }}</td>
                            <td>{{ $bill->method }}</td>
                            <td>{{ $bill->totalPay != 0 ? number_format(round($bill->totalPay), 0, ",", ".") : "0" }} đ</td>
                            <td>{{ $bill->status }}</td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection