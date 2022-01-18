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
                        <a class="btn btn-primary w-100" href="{{ route('createAccount') }}">Thêm mới</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Danh sách tài khoản
            </div>
            <div class="card-body">
                <table id="accountTables">
                    <thead>
                        <tr>
                            <th>Mã tài khoản</th>
                            <th>Tên tài khoản</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Tổng số hóa đơn</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>                
                        @foreach ($customers as $customer)
                            <tr style="cursor: pointer" onclick="window.location = '{{ route('adminAccountInfo', ['id' => $customer->id]) }}'">
                                <td>{{ $customer->id}}</td>
                                <td>{{ $customer->username}}</td>
                                <td>{{ $customer->fullname}}</td>
                                <td>{{ $customer->email}}</td>
                                <td>{{ $customer->phone}}</td>
                                <td>{{ $customer->totalBill }}</td>
                                <td>{{ $customer->totalPay != NULL ? number_format(round($customer->totalPay), 0, ",", ".") : "0" }}đ </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection