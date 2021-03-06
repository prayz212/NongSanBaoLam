<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
  <!-- Navbar Brand-->
  <a class="navbar-brand ps-3 d-flex align-items-center" href="{{route('dashboard')}}">
    <img src="{{ asset('images/logo.png') }}" width="24px" height="24px">
    <span class="mx-1">Nông sản Bảo Lâm</span>
  </a>

  <!-- Sidebar Toggle-->
  <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 d-lg-none d-block " id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

  <div class="d-none d-md-inline-block ms-auto me-0 me-md-3 my-2 my-md-0" style="color: rgba(255, 255, 255, 0.5)">Xin chào, {{ Auth::guard('admin')->user()->fullname ?? '' }}</div>
  
  <!-- Navbar-->
  <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="{{route('adminLogout')}}">Đăng xuất</a></li>
          </ul>
      </li>
  </ul>
</nav>