<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
          <div class="nav">
              <div class="sb-sidenav-menu-heading">Quản lý</div>
              <a class="nav-link {{Request::is('admin/trang-chu') ? 'active' : ''}}" style="{{Request::is('admin/trang-chu') ? 'background-color: #424242' : ''}}" href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-line fa-fw"></i></div>
                Tổng quan
              </a>
              <a class="nav-link {{Request::is('admin/quan-ly-hoa-don', 'admin/thong-tin-hoa-don/*') ? 'active' : ''}}" style="{{Request::is('admin/quan-ly-hoa-don', 'admin/thong-tin-hoa-don/*') ? 'background-color: #424242' : ''}}" href="{{ route('adminBill') }}">
                  <div class="sb-nav-link-icon"><i class="fas fa-file-invoice fa-fw"></i></div>
                  Quản lý hóa đơn
              </a>
              <a class="nav-link {{Request::is('admin/quan-ly-san-pham', 'admin/thong-tin-san-pham/*', 'admin/nhap-kho') ? 'active' : ''}}" style="{{Request::is('admin/quan-ly-san-pham', 'admin/thong-tin-san-pham/*', 'admin/nhap-kho') ? 'background-color: #424242' : ''}}" href="{{ route('productManagement') }}">
                  <div class="sb-nav-link-icon"><i class="fas fa-warehouse fa-fw"></i></div>
                  Quản lý sản phẩm
              </a>
              <a class="nav-link {{Request::is('admin/quan-ly-tai-khoan', 'admin/thong-tin-tai-khoan/*', 'admin/chinh-sua-tai-khoan/*', 'admin/tao-moi-tai-khoan') ? 'active' : ''}}" style="{{Request::is('admin/quan-ly-tai-khoan', 'admin/thong-tin-tai-khoan/*', 'admin/chinh-sua-tai-khoan/*', 'admin/tao-moi-tai-khoan') ? 'background-color: #424242' : ''}}" href="{{ route('accountManagement') }}">
                  <div class="sb-nav-link-icon"><i class="fas fa-users fa-fw"></i></div>
                  Quản lý tài khoản
              </a>
              <a class="nav-link {{Request::is('admin/quan-ly-voucher', 'admin/thong-tin-voucher/*', 'admin/tao-moi-voucher') ? 'active' : ''}}" style="{{Request::is('admin/quan-ly-voucher', 'admin/thong-tin-voucher/*', 'admin/tao-moi-voucher') ? 'background-color: #424242' : ''}}" href="{{ route('voucherManagement') }}">
                  <div class="sb-nav-link-icon pt-1"><i class="fas fa-ticket-alt fa-fw"></i></i></div>
                  Quản lý voucher
              </a>
          </div>
      </div>
  </nav>
</div>