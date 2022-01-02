<nav class="__nav __nav-shadow">
  <div class="__navigation __container">
      <div class="__logo">
          <a style="display: flex; align-items: center;" href="{{ url('') }}">
            <img src="{{ asset('images/logo.png') }}" width="50px" height="50px">
            <h1 class="__brand-name mx-2" style="margin-bottom: 0">Nông sản Bảo Lâm</h1>
          </a>
      </div>

      <div class="d-none d-md-inline-block __search-box">
        <form method="GET" action="{{ url('tim-kiem-san-pham') }}">
            <div class="form-actions no-color">
                <button style="position: absolute; top: 32%; right: 4%; background: transparent; border: none;" type="submit"><i class='bx bx-search' style="color: black; font-size: 2rem;"></i></button>
                <input class="_form-input" type="text" name="key" value="" placeholder="Tìm kiếm theo tên"/>
            </div>
        </form>
      </div>

      <div class="__menu">
          <div class="__top-nav">
              <div class="__logo">
                  <a>
                      <h1>Nông sản Bảo Lâm</h1>
                  </a>
              </div>
              <div class="__close">
                  <i class="bx bx-x"></i>
              </div>
          </div>

          <ul class="__nav-list">
            <li class="__nav-item">
                <div class="d-md-none d-inline-block">
                    <form method="GET" action="{{ url('tim-kiem-san-pham') }}">
                        <div class="form-actions no-color">
                            <button style="position: absolute; top: 32%; right: 4%; background: transparent; border: none;" type="submit"><i class='bx bx-search' style="color: black; font-size: 2rem;"></i></button>
                            <input class="_form-input" type="text" name="key" value="" placeholder="Tìm kiếm theo tên"/>
                        </div>
                    </form>
                  </div>
              </li>
              <li class="__nav-item">
                  <a class="__nav-link" href="{{ url('') }}">Trang chủ</a>
              </li>
              <li class="__nav-item __hoverable" id="hoverable-el">
                  <a class="__nav-link">Sản phẩm</a>                  
                  <ul class="__sub-menu">
                    <li><a href="{{ url('the-loai-san-pham/trai-cay-da-lat') }}">Trái cây Đà Lạt</a></li>
                    <li><a href="{{ url('the-loai-san-pham/trai-cay-ngoai-nhap') }}">Trái cây ngoại nhập</a></li>
                    <li><a href="{{ url('the-loai-san-pham/rau-cu-huu-co') }}">Rau củ hữu cơ</a></li>
                    <li><a href="{{ url('the-loai-san-pham/rau-cu-da-lat') }}">Rau củ Đà Lạt</a></li>
                    <li><a href="{{ url('the-loai-san-pham/rau-cu-ngoai-nhap') }}">Rau củ ngoại nhập</a></li>
                    <li><a href="{{ url('the-loai-san-pham/combo-san-pham') }}">Combo sản phẩm</a></li>
                  </ul>
              </li>
              <li class="__nav-item">
                  <a class="__nav-link" href="{{ url('dang-nhap-dang-ky') }}">Tài khoản</a>
              </li>
              <li class="__nav-item">
                  <a class="__nav-link" href="{{ url('gioi-thieu') }}">Giới thiệu</a>
              </li>
              <li class="__nav-item">
                  <a class="__nav-link icon" href="{{ url('/gio-hang') }}"><i class="bx bx-shopping-bag"></i></a>
              </li>

              @if (Auth::check())
              <li class="__nav-item">
                <a class="__nav-link icon" href="{{ url('/dang-xuat') }}"><i class="bx bx-log-out"></i></a>
              </li>
              @endif
          </ul>
      </div>

      <a class="__cart-icon" href="{{ url('/gio-hang') }}">
          <i class="bx bx-shopping-bag"></i>
      </a>

      @if (Auth::check())
      <a class="__logout-icon" href="{{ url('/dang-xuat') }}">
          <i class='bx bx-log-out'></i>
      </a>
      @endif

      <div class="__hamburger">
          <i class="bx bx-menu"></i>
      </div>
  </div>
</nav>