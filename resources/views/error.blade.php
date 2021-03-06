<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>Đã xảy ra lỗi!</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>
<body>
    <div class="__page pt-5">
        <div class="__content-wrap py-0 py-sm-5">
            <main role="main">
                <div class="ex-page-content bootstrap snippets bootdeys">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <svg class="svg-box" width="380px" height="500px" viewBox="0 0 837 1045" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                        <path d="M353,9 L626.664028,170 L626.664028,487 L353,642 L79.3359724,487 L79.3359724,170 L353,9 Z" id="Polygon-1" stroke="#3bafda" stroke-width="6" sketch:type="MSShapeGroup"></path>
                                        <path d="M78.5,529 L147,569.186414 L147,648.311216 L78.5,687 L10,648.311216 L10,569.186414 L78.5,529 Z" id="Polygon-2" stroke="#7266ba" stroke-width="6" sketch:type="MSShapeGroup"></path>
                                        <path d="M773,186 L827,217.538705 L827,279.636651 L773,310 L719,279.636651 L719,217.538705 L773,186 Z" id="Polygon-3" stroke="#f76397" stroke-width="6" sketch:type="MSShapeGroup"></path>
                                        <path d="M639,529 L773,607.846761 L773,763.091627 L639,839 L505,763.091627 L505,607.846761 L639,529 Z" id="Polygon-4" stroke="#00b19d" stroke-width="6" sketch:type="MSShapeGroup"></path>
                                        <path d="M281,801 L383,861.025276 L383,979.21169 L281,1037 L179,979.21169 L179,861.025276 L281,801 Z" id="Polygon-5" stroke="#ffaa00" stroke-width="6" sketch:type="MSShapeGroup"></path>
                                    </g>
                                </svg>
                            </div>

                            <div class="col-sm-6">
                                <div class="message-box">
                                    <h1 class="text-center text-sm-start">500</h1>
                                    <p style="color: white">Opps!! Đã xảy ra lỗi, vui lòng thử lại sau.</p>
                                    <p style="color: white; font-size: 12px; font-weight: 200;">Thông báo lỗi: {{ $errorMessages ?? '' }}</p>
                                    <div class="buttons-con d-sm-block d-flex justify-content-center mt-4">
                                        <div class="action-link-wrap">
                                            <a href="{{ $returnUrl }}" class="btn btn-custom btn-info waves-effect waves-light m-t-20">Trở về trang trước</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

<style>
    body {
        background: #444141;
        font-family: 'Noto Sans', sans-serif;
        margin: 0;
        color: #4c5667;
        overflow-x: hidden !important;
        height: 100vh;
    }

    .message-box h1 {
        color: #ad9c9c;
        font-size: 98px;
        font-weight: 700;
        line-height: 98px;
        text-shadow: rgba(61, 61, 61, 0.3) 1px 1px, rgba(61, 61, 61, 0.2) 2px 2px, rgba(61, 61, 61, 0.3) 3px 3px;
    }

    .btn-info {
        background-color: #a4abad;
        border-color: #667274;
    }
</style>