<div id="layoutSidenav_nav">
  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
      <div class="sb-sidenav-menu">
          <div class="nav">
              <div class="sb-sidenav-menu-heading">Quản lý</div>
              <a class="nav-link {{Request::is('admin/trang-chu') ? 'active' : ''}}" style="{{Request::is('admin/trang-chu') ? 'background-color: #424242' : ''}}" href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-chart-line fa-fw"></i></div>
                Tổng quan
              </a>
              <a class="nav-link {{Request::is('admin/quan-ly-hoa-don') ? 'active' : ''}}" style="{{Request::is('admin/quan-ly-hoa-don') ? 'background-color: #424242' : ''}}" >
                  <div class="sb-nav-link-icon"><i class="fas fa-file-invoice fa-fw"></i></div>
                  Quản lý hóa đơn
              </a>
              <a class="nav-link {{Request::is('admin/quan-ly-san-pham') ? 'active' : ''}}" style="{{Request::is('admin/quan-ly-san-pham') ? 'background-color: #424242' : ''}}" >
                  <div class="sb-nav-link-icon"><i class="fas fa-warehouse fa-fw"></i></div>
                  Quản lý sản phẩm
              </a>
              <a class="nav-link {{Request::is('admin/quan-ly-tai-khoan') ? 'active' : ''}}" style="{{Request::is('admin/quan-ly-tai-khoan') ? 'background-color: #424242' : ''}}" >
                  <div class="sb-nav-link-icon"><i class="fas fa-users fa-fw"></i></div>
                  Quản lý tài khoản
              </a>
          </div>
      </div>
  </nav>
</div>