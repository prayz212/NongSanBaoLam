@extends('client.layouts.master')
@section('main')
<style>
    p.lead {
        padding-top: 20px;
        font-weight: 400;
        line-height: 40px;
        font-size: 1.7rem;
    }
</style>

<div class="container __section marketing">
    <div class="row py-4">
        <div class="col-sm-4 text-center mb-sm-4 mb-5">
            <img class="rounded-circle" src="{{ asset('images/intro-1.jpg') }}" alt="Generic placeholder image" width="140" height="140">
            <h3 class="mt-3" style="line-height: 2.5rem">Top cửa hàng nông sản <br> hàng đầu VN</h3>
        </div>
        <div class="col-sm-4 text-center mb-sm-4 mb-5">
            <img class="rounded-circle" src="{{ asset('images/intro-2.jpg') }}" alt="Generic placeholder image" width="140" height="140">
            <h3 class="mt-3" style="line-height: 2.5rem">Dễ dàng đặt hàng <br> Giao hàng nhanh chóng</h3>
        </div>
        <div class="col-sm-4 text-center mb-sm-4 mb-5">
            <img class="rounded-circle" src="{{ asset('images/intro-3.jpg') }}" alt="Generic placeholder image" width="180" height="140">
            <h3 class="mt-3" style="line-height: 2.5rem">Mạng lưới phủ sóng 100% <br> 63 tỉnh thành</h3>
        </div>
    </div>

    <hr class="featurette-divider">
    <div class="row featurette py-5 px-2">
        <div class="col-md-6">
            <h1 class="featurette-heading"><span class="text-muted">| Câu chuyện cửa hàng nông sản Bảo Lâm</span></h1>
            <p class="lead text-dark text-justify">Nông sản Bảo Lâm hướng đến là thương hiệu cung cấp nông sản hữu cơ, tươi ngon và quà tặng nông sản chuyên nghiệp tại Việt Nam, phân phối nông sản Việt đặc sản an toàn từ khắp mọi vùng miền và nông sản nhập khẩu cao cấp. Sứ mệnh của chúng tôi là mang lại sức khoẻ, hạnh phúc của khách hàng qua những sản phẩm, dịch vụ tận tâm. Nông sản Bảo Lâm ra đời để khẳng định giá trị của các loại rau củ, trái cây chất lượng, cũng như sự phong phú, đa dạng về các mặt hàng tại nông sản Bảo Lâm.</p>
        </div>
        <div class="col-md-6">
            <img class="featurette-image img-fluid mx-auto" alt="Câu chuyện cửa hàng nông sản Bảo Lâm" src="{{ asset('images/intro-4.png') }}" style="width: 100%; height: 100%;">
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette py-5 px-1">
        <div class="col-md-6 order-md-2">
            <h1 class="featurette-heading"><span class="text-muted">| Tầm nhìn</span></h1>
            <div class="space20">&nbsp;</div>
            <p class="text-dark" style="font-size: 1.7rem;text-align:justify;line-height: 32px;">
                (*) Với tầm nhìn là thương hiệu bán lẻ sản phẩm nông nghiệp chất lượng số 1 Việt Nam, mang sản phẩm an toàn từ nơi sản xuất đến người tiêu dùng nhanh nhất, chúng tôi mang trong mình 3 giá trị cốt lõi (3C):                                </P>
            </P>
                <i style="font-size: 1.55rem;text-align:justify;line-height: 30px;" class="text-dark">
                    1. Chất lượng sản phẩm: luôn luôn là ưu tiên số 1, là yếu tố tiên quyết bắt buộc, cũng là mục tiêu mà đội ngũ chúng tôi đang nỗ lực cải tiến và hoàn thiện từng ngày.                                </P>
                </i>
                <i style="font-size: 1.55rem;text-align:justify;line-height: 30px;" class="text-dark">
                2. Công nghệ cập nhật: là yếu tố "nhanh" trong tầm nhìn của chúng tôi. Công nghệ luôn được chúng tôi chú trọng cập nhật thường xuyên để gia tăng tốc độ xử lý đơn hàng, mang sản phẩm đến tay khách hàng nhanh nhất có thể.                                </P>
                </i>
                <i style="font-size: 1.55rem;text-align:justify;line-height: 30px;" class="text-dark">
                3. Cộng đồng tử tế: là cộng đồng trong đó mọi mối quan hệ được kết nối với nhau bởi sự tử tế: Đồng nghiệp tử tế, Đối tác tử tế, Khách hàng tử tế.                                <div class="space20">&nbsp;</div>
                </i>
        </div>
        <div class="col-md-6 order-md-1">
            <img class="featurette-image img-fluid mx-auto" src="{{ asset('images/intro-5.jpeg') }}" alt="500x500" style="width: 100%; height: 100%;">
        </div>
    </div>

    <hr class="featurette-divider">

    <div class="row featurette pt-3 px-1">
        <div class="col-md-7">
            <h1 class="featurette-heading"><span class="text-muted">| Thông tin liên hệ của cửa hàng</span></h1>
            <div class="space20">&nbsp;</div>
            <p class="text-dark" style="font-size: 1.5rem;text-align:justify;">
                Địa chỉ: 90-92 Lê Thị Riêng, Bến Thành, TP.HCM<br>
                Số điện thoại: +01 23.456.789<br>
                Email: nongsanbaolam@gmail.com
            </p>     
        </div>
        <div class="col-md-5">
          <div class="d-none d-sm-flex justify-content-end">
            <img class="featurette-image img-fluid" data-src="holder.js/500x500/auto" alt="500x500" src="{{ asset('images/logo.png') }}" width="150px" height="150px" data-holder-rendered="true" >
          </div>
        </div>
    </div>

@endsection