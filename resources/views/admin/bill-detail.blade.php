@extends('admin.layouts.master')
@section('main')

<main class="__product-main">
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="__product-title-box d-sm-flex justify-content-between" style="margin-top: 0px">
                <div class="print-title">
                    <h4 >Thông tin hóa đơn</h4>
                    <ol class="breadcrumb none-print" style="margin-bottom: 0px">
                        <li class="breadcrumb-item"><a href="{{ route('adminBill') }}">Quản lý hóa đơn</a></li>
                        <li class="breadcrumb-item active">Hóa đơn {{ $bill->id }}</li>
                    </ol>
                    <button class="d-block d-sm-none mt-3 btn btn-success w-100 none-print" onclick="document.title = 'Hóa đơn ' + {{ $bill->id }}; window.print();">In hóa đơn</button>
                </div>
                
                <div class="d-none d-sm-block align-self-center none-print">
                    <button class="btn btn-success w-100" onclick="document.title = 'Hóa đơn ' + {{ $bill->id }}; window.print();">In hóa đơn</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 print-col-6 pe-lg-0">
                    <div class="__product-info-box invoice-details rounded-3 mt-0">
                        <p><b>Khách hàng</b> - #{{ $bill->customer_id}}</p>
                        <p><b>Họ và tên:</b> {{ $bill->fullname}}</p>
                        <p><b>Loại thanh toán:</b> {{ $bill->method == 'COD' ? 'Thu hộ' : 'Thẻ tín dụng'}}</p>
                        <p><b>Số thẻ {{ $bill->card != NULL ? $bill->card->brand : '' }}: </b> {{ $bill->card != NULL ? $bill->card->number : "Không có" }}</p>
                        <p><b>Địa chỉ:</b> {{ $bill->address }}</p>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 print-col-6">
                    <div class="__product-info-box invoice-details rounded-3 mt-0">
                        <div class="invoice-num">
                            <p><b>Hóa đơn</b> - #{{ $bill->id }}</p>
                            <p><b>Ngày đặt hàng:</b> {{ date('d/m/Y',strtotime($bill->created_at)) }}</p>
                            <p><b>Ngày giao hàng:</b> <span id="delivery-at"> {{ $bill->delivery_at != NULL ? date('d/m/Y',strtotime($bill->delivery_at)) : $bill->status}} </span></p>
                            <p><b>Tình trạng:</b> <span id="status"> {{ $bill->status }} </span></p>
                            <p><b>Ghi chú:</b> {{ $bill->notes != NULL ? $bill->notes : "Không có"}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table custom-table m-0 border-0 overflow-hidden __invoice-table">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>Mã</th>
                                    <th>Sản phẩm</th>
                                    <th class="d-none d-sm-table-cell">Thể loại</th>
                                    <th>SL (kg)</th>
                                    <th class="text-end">Số tiền</th>
                                </tr>
                            </thead>
                            <tbody class="border-0">
                                @foreach ($bill->bill_detail as $detail)
                                    <tr class="bg-white">
                                        <td class="text-center col-lg-1">#{{ $detail->item->id }}</td>
                                        <td class="col-lg-4 col-5 __break-word-dots">
                                            {{ $detail->item->name }}
                                        </td>
                                        <td class="d-none d-sm-table-cell col-lg-3">{{ $detail->item->category->name }}</td>
                                        <td class="text-center col-lg-2 col-1">{{ $detail->quantity }}</td>
                                        <td class="text-end col-lg-2">{{ number_format(round($detail->unit_price * $detail->quantity), 0, ",", ".") }}đ</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-white">
                                    <td colspan="1" class="d-none d-sm-table-cell border-end-0"></td>
                                    <td colspan="4" class="border-start-0 print-table-border">
                                        <div class="d-flex justify-content-end" style="line-height: 2rem">
                                            <div class="col-12 col-md-8 col-lg-6">
                                                <div class="row print-total-content">
                                                    <div class="col-6 print-total"> Tổng tiền hàng: </div>
                                                    <div class="d-flex justify-content-end col-6 print-total-value">{{ number_format(round($bill->totalPrice), 0, ",", ".") }}đ</div> 
                                                </div>
                                                <div class="row print-total-content">
                                                    <div class="col-6 print-total"> Chiết khấu: </div>
                                                    <div class="d-flex justify-content-end col-6 print-total-value">{{ number_format(round($bill->totalDiscount), 0, ",", ".") }}đ</div> 
                                                </div>
                                                <div class="row print-total-content">
                                                    <div class="col-6 print-total"> Giảm giá voucher: </div>
                                                    <div class="d-flex justify-content-end col-6 print-total-value">{{ $bill->voucher != NULL ? number_format(round($bill->voucher->discount), 0, ",", ".") : '0'}}đ</div> 
                                                </div>
                                                <div class="row print-total-content">
                                                    <div class="col-6 print-total"> Chi phí vận chuyển: </div>
                                                    <div class="d-flex justify-content-end col-6 print-total-value">{{ number_format(round($bill->shippingCost), 0, ",", ".") }}đ</div> 
                                                </div>
                                                
                                                <div class="row print-total-content">
                                                    <h5 class="__text-success col-6 print-total"><b>Thành tiền: </b></h5>
                                                    <h5 class="__text-success d-flex justify-content-end col-6 print-total-value"><b>{{ number_format(round($bill->totalPay), 0, ",", ".") }}đ</b></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="__product-title-box">
                <div class="row gutters mt-0 none-print">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <h4>Cập nhật tình trạng hóa đơn</h4>
                    </div>
                </div>
                <div class="mt-3 px-1 none-print">
                    <form id="update-bill-status" data-action="{{ route('adminBillUpdate') }}">
                        @csrf
                        <div class="d-flex">
                            <div class="me-3">
                                <select name="status" class="form-select" aria-label="Default select example">
                                    <option {{ $bill->status == 'Đang xử lý' ? 'selected' : 'Đang xử lý' }} value="Đang xử lý">Đang xử lý</option>
                                    <option {{ $bill->status == 'Đang giao' ? 'selected' : 'Đang giao' }} value="Đang giao">Đang giao</option>
                                    <option {{ $bill->status == 'Đã giao' ? 'selected' : 'Đã giao' }} value="Đã giao">Đã giao</option>
                                </select>
                            </div>

                            <div class="ml-4">
                                <button id="update-bill-btn" data-bill-id="{{ $bill->id }}" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

@include('admin.includes.pop-up-notify')
<script src="{{ asset('admin/js/update-bill-status.js') }}"></script>
@endsection