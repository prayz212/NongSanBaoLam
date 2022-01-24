@extends('admin.layouts.master')
@section('main')

<main>
  <div class="container-fluid px-4">
      <div class="h4 my-4">Thống kê tổng quát</div>
      <div class="card mb-2 area-chart-section" data-href="{{ route('orderAnalysis') }}">
          <div class="card-header">
              <div class="d-flex align-items-center" title="Biểu đồ thống kê số lượng đơn đặt hàng">
                  <div class="__break-word-dots col-sm-6 col-md-8 col-lg-9">
                    <i class="fas fa-chart-area me-1"></i>
                    Biểu đồ thống kê số lượng đơn đặt hàng
                  </div>
                  <div class="d-none d-sm-flex justify-content-end col-sm-6 col-md-4 col-lg-3">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input value="week" type="radio" class="btn-check area-chart-mode" name="btnradio" id="btnradio1">
                        <label class="btn btn-outline-dark shadow-none" for="btnradio1">Tuần</label>
                        
                        <input value="month" type="radio" class="btn-check area-chart-mode" name="btnradio" id="btnradio2" checked>
                        <label class="btn btn-outline-dark shadow-none" for="btnradio2">Tháng</label>
                        
                        <input value="quarter" type="radio" class="btn-check area-chart-mode" name="btnradio" id="btnradio3">
                        <label class="btn btn-outline-dark shadow-none" for="btnradio3">Quý</label>
                    </div>
                  </div>
              </div>
          </div>
          <div class="card-body">
            <canvas id="area-chart-week" width="100%" height="30"></canvas>
          </div>
          <div class="card-body" style="display: none">
            <canvas id="area-chart-month" width="100%" height="30"></canvas>
          </div>
          <div class="card-body" style="display: none">
            <canvas id="area-chart-quarter" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted __break-word-dots">Cập nhật lần cuối lúc <span class="updated-time"></span></div>
      </div>
      <div class="card mb-5">
          <div class="card-body">
              Biểu đồ vùng thống kê các số liệu về tổng số lượng đơn đặt hàng trong hệ thống. Quản trị viên có thể chọn các chế độ xem như xem theo tuần, tháng hoặc quý để có cái nhìn trực quan hơn về tình hình kinh doanh tại chuỗi cửa hàng. Trục tung trong biểu đồ là các mức giá trị của dữ liệu và trục hoành trong biểu đồ là các mốc thời gian tại giá trị đó.
          </div>
      </div>

      <div class="row my-4">
          <div class="col-lg-6 bar-chart-section" data-href="{{ route('productAnalysis') }}">
              <div class="card mb-2">
                  <div class="card-header __break-word-dots" title="Biểu đồ thống kê số lượng sản phẩm bán ra">
                      <i class="fas fa-chart-bar me-1"></i>
                      Biểu đồ thống kê số lượng sản phẩm bán ra
                  </div>
                  <div class="card-body">
                      <canvas id="bar-chart" width="100%" height="50"></canvas>
                  </div>
                  <div class="card-footer small text-muted __break-word-dots">Cập nhật lần cuối lúc <span class="updated-time"></span></div>
              </div>
              <div class="card mb-5">
                <div class="card-body">
                    Biểu đồ cột thống kê các số liệu về tổng số lượng các sản phẩm được bán ra trong thời gian vừa qua. Trục tung đại diện cho các mức giá trị của dữ liệu, trục hoành đại diện cho sản phẩm được bán ra.
                </div>
              </div>
          </div>
          <div class="col-lg-6 mt-sm-0 mt-4 pie-chart-section" data-href="{{ route('billStatusAnalysis') }}">
              <div class="card mb-2">
                  <div class="card-header __break-word-dots" title="Biểu đồ thống kê tình trạng các đơn hàng">
                      <i class="fas fa-chart-pie me-1"></i>
                      Biểu đồ thống kê tình trạng các đơn hàng
                  </div>
                  <div class="card-body"><canvas id="pie-chart" width="100%" height="50"></canvas></div>
                  <div class="card-footer small text-muted __break-word-dots">Cập nhật lần cuối lúc <span class="updated-time"></span></div>
              </div>
              <div class="card mb-3">
                <div class="card-body">
                    Biểu đồ tròn thống kê các số liệu về tình trạng các đơn hàng trong hệ thống. Biểu đồ sẽ chia hình tròn thành các phần tương ứng với số liệu của từng trạng thái và có các màu sắc khác nhau.
                </div>
              </div>
          </div>
      </div>
  </div>
</main>

<script>
    window.onload = function () {
        Chart.defaults.global.defaultFontFamily =
            '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = "#292b2c";
    };
</script>

@include('admin.includes.pop-up-notify')
<script src="{{ asset('admin/js/dashboard.js') }}"></script>

@endsection