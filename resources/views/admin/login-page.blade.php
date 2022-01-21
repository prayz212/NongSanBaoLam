<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập - Trang quản trị website</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body class="bg-dark">
    <div class="d-flex">
        <div class="container mt-5 pt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-11 col-sm-8 col-md-7 col-lg-5 col-xl-4">
                    <div class="card p-sm-2">
                        <div class="card-body">
                            <h2 class="d-flex justify-content-center">Đăng nhập</h2>
                            <form method="POST" action="{{route('adminLoginRequest')}}">
                                @csrf
                                <div class="mb-2 mt-3">
                                    <label for="username">Tên tài khoản:</label>
                                    <input name="username" type="text" class="form-control mt-2 shadow-none" id="Username" placeholder="Tên tài khoản" value="{{ old('username') }}">
                                    <div class="__notify-msg ml-2" style="font-size: smaller; color: red; margin-left: 4px; margin-top:2px;">{{ $errors->login->first('username') ?? '' }}</div>
                                </div>
                                <div class="mb-3">
                                    <label for="password">Mật khẩu:</label>
                                    <input name="password" type="password" class="form-control mt-2 enter-event shadow-none" id="pwd" placeholder="Mật khẩu">
                                    <div class="__notify-msg ml-2" style="font-size: smaller; color: red; margin-left: 4px; margin-top:2px;">{{ $errors->login->first('password') ?? '' }}</div>
                                </div>
                                <div class="text-danger">{{ Session::get('login-error') ?? '' }}</div>
                                <div class="d-flex justify-content-center py-2">
                                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>