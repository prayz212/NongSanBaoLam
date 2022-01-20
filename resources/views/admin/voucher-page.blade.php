@extends('admin.layouts.master')
@section('main')

<main>
    <div class="container-fluid px-4">
        <div class="row my-4">
            <div class="col-sm-8 col-md-7 col-12">
                <div class="h4">Quản lý tài khoản</div>
            </div>
            
            <div class="col-sm-4 col-md-5 col-12 align-items-center">
                <div class="d-block d-sm-flex flex-row-reverse">
                    <div class="mx-sm-3 mb-sm-0 mb-2">
                        <a class="btn btn-primary w-100" href="{{ route('createVoucher') }}">Thêm mới</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Danh sách voucher
            </div>
            <div class="card-body">
                <table id="voucherTables">
                    <thead>
                        <tr>
                            <th>Mã voucher</th>
                            <th>Chiết khấu (VND)</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Số lượng</th>
                            <th>Số lượng đã sử dụng</th>
                            <th>Số lượng còn lại</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vouchers as $voucher)
                        
                        <tr style="cursor: pointer" onclick="window.location = '{{ route('voucherInfo', ['code' => $voucher->code]) }}'">
                            <td>{{ $voucher->code}}</td>
                            <td>{{ number_format(round($voucher->discount), 0, ",", ".") }}đ</td>
                            <td>{{ date('d/m/Y',strtotime($voucher->start_at)) }}</td>
                            <td>{{ date('d/m/Y',strtotime($voucher->end_at)) }}</td>
                            <td>{{ $voucher->quantity }}</td>
                            <td>{{ $voucher->used ?? 0}}</td>
                            <td>{{ $voucher->remain ?? $voucher->quantity}}</td>
                        </tr>
                        
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection