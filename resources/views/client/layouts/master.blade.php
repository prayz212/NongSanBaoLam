<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Homepage - CoolMate thời trang của mọi nhà</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />


    <!-- Box icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js" integrity="sha512-eP6ippJojIKXKO8EPLtsUMS+/sAGHGo1UN/38swqZa1ypfcD4I0V/ac5G3VzaHfDaklFmQLEs51lhkkVaqg60Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="__page pt-5">
        <div class="__content-wrap py-5">
            @if (Request::route()->getName() == "homepage")
            <header id="home" class="__header">
              <!-- Navigation -->
              <nav class="__nav __nav-shadow">
                  <div class="__navigation __container">
                      <div class="__logo">
                          <a style="display: flex; align-items: center;" href="{{ url('') }}">
                            <img src="{{ asset('images/logo.png') }}" width="50px" height="50px">
                            <h1 class="__brand-name mx-2" style="margin-bottom: 0">Nông sản Bảo Lâm</h1>
                          </a>
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
                                  <a class="__nav-link" href="{{ url('') }}">Trang chủ</a>
                              </li>
                              <li class="__nav-item">
                                  <a class="__nav-link">Sản phẩm</a>
                              </li>
                              <li class="__nav-item">
                                  <a class="__nav-link ">Tài khoản</a>
                              </li>
                              <li class="__nav-item">
                                  <a class="__nav-link icon" href="{{ url('/gio-hang') }}"><i class="bx bx-shopping-bag"></i></a>
                              </li>

                              {{-- <li class="__nav-item">
                                  <a class="__nav-link icon"><i class="bx bx-log-out"></i></a>
                              </li> --}}
                          </ul>
                      </div>

                      <a class="__cart-icon" href="{{ url('/gio-hang') }}">
                          <i class="bx bx-shopping-bag"></i>
                      </a>

                      {{-- <a class="__cart-icon">
                          <i class='bx bx-log-out'></i>
                      </a> --}}

                      <div class="__hamburger">
                          <i class="bx bx-menu"></i>
                      </div>
                  </div>
              </nav>


              <!-- Hero -->
              <img src="{{ asset('images/banner.png') }}" alt="" class="__hero-img" />

              <div class="__hero-content">
                  <h2>Giảm giá <span class="__discount">20% </span></h2>
                  <h1>
                      <span>Sản phẩm hữu cơ</span>
                      <span>dành cho mọi nhà</span>
                  </h1>
                  <a class="__btn">Mua ngay</a>
              </div>
          </header>
        @else
            <nav class="__nav __nav-shadow" )">
                <div class="__navigation __container">
                    <div class="__logo">
                        <a style="display: flex; align-items: center;" href="{{ url('') }}">
                          <img src="{{ asset('images/logo.png') }}" width="50px" height="50px">
                          <h1 class="__brand-name mx-2" style="margin-bottom: 0">Nông sản Bảo Lâm</h1>
                        </a>
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
                                <a class="__nav-link" href="{{ url('') }}">Trang chủ</a>
                            </li>
                            <li class="__nav-item">
                                <a class="__nav-link">Sản phẩm</a>
                            </li>
                            <li class="__nav-item">
                                <a class="__nav-link">Tài khoản</a>
                            </li>
                            <li class="__nav-item">
                                <a class="__nav-link icon" href="{{ url('/gio-hang') }}"><i class="bx bx-shopping-bag"></i></a>
                            </li>
                            {{-- <li class="__nav-item">
                                <a class="__nav-link icon"><i class="bx bx-log-out"></i></a>
                            </li> --}}
                        </ul>
                    </div>

                    <a class="__cart-icon">
                        <i class="bx bx-shopping-bag"></i>
                    </a>
                    {{-- <a class="__cart-icon">
                        <i class='bx bx-log-out'></i>
                    </a> --}}
                    <div class="__hamburger">
                        <i class="bx bx-menu"></i>
                    </div>
                </div>
            </nav>
        @endif
            <main role="main">
              @yield('main')
            </main>
        </div>

        <!-- Footer -->
        <footer id="footer" class="__section __footer">
            <div class="__container">
                <div class="__footer-center">
                    Copyright © NSBL | Develop by Chi Vi & Quang Huy.
                </div>
            </div>
        </footer>
    </div>
    <!-- End Footer -->

    <script src="{{ asset('js/site.js') }}"></script>
</body>
</html>
