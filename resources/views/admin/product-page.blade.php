@extends('admin.layouts.master')
@section('main')

<main>
  <div class="container-fluid px-4">
      <div class="row my-4">
          <div class="col-sm-8 col-md-7 col-12">
              <div class="h4">Quản lý sản phẩm</div>
          </div>
          
          <div class="col-sm-4 col-md-5 col-12 align-items-center">
              <div class="d-block d-sm-flex flex-row-reverse">
                <div class="mx-sm-3 mb-sm-0 mb-2"><a class="btn btn-primary w-100" href="{{ route('createProduct') }}">Thêm mới</a></div>
                <div><a class="btn btn-success w-100" href="{{ route('productStockIn') }}">Nhập kho</a></div>
              </div>
          </div>
      </div>
      <div class="card mb-4">
          <div class="card-header">
              <i class="fas fa-table me-1"></i>
              Danh sách sản phẩm
          </div>
          <div class="card-body">
              <table id="productTables">
                  <thead>
                      <tr>
                          <th>Mã</th>
                          <th>Tên</th>
                          <th>Loại</th>
                          <th>Giá</th>
                          <th>Chiết khẩu (%)</th>
                          <th>Đánh giá</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr>
                          <th>Mã</th>
                          <th>Tên</th>
                          <th>Loại</th>
                          <th>Giá</th>
                          <th>Chiết khẩu (%)</th>
                          <th>Đánh giá</th>
                      </tr>
                  </tfoot>
                  <tbody>
                      @foreach ($products as $product)
                          <tr style="cursor:pointer" onclick="location.href = '{{ url('admin/thong-tin-san-pham/' . $product->id)}}'">
                              <td>{{ $product->id }}</td>
                              <td>{{ $product->name }}</td>
                              <td>{{ $product->category->name }}</td>
                              <td>{{ number_format(round($product->price), 0, ",", ".") }}đ</td>
                              <td>{{ $product->discount ?? 'NULL' }}</td>
                              <td>{{ $product->avgRating->first() ? round($product->avgRating->first()->rating) : 'Rỗng' }}</td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</main>

@endsection