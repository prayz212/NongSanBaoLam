<section class="__advert __section">
  <div class="__advert-center __container">
      <div class="__advert-box">
          <a>
              <div class="__dotted">
                  <div class="__content">
                      <h2>
                          Rau củ hữu cơ
                      </h2>
                      <h4>"Made in VietNam"</h4>
                  </div>
              </div>
              <img src="{{ asset('images/advert1.png') }}" alt="">
          </a>
      </div>

      <div class="__advert-box">
          <a asp-controller="Product" asp-action="Index" asp-route-filter="Quần">
              <div class="__dotted">
                  <div class="__content">
                      <h2>
                          Trái cây tươi
                      </h2>
                      <h4>"Made in VietNam"</h4>
                  </div>
              </div>
              <img src="{{ asset('images/advert2.png') }}" alt="">
          </a>
      </div>

      <div class="__advert-box">
          <a asp-controller="Product" asp-action="Index" asp-route-filter="Áo sơ mi">
              <div class="__dotted">
                  <div class="__content">
                      <h2>
                          Combo sản phẩm
                      </h2>
                      <h4>"Made in VietNam"</h4>
                  </div>
              </div>
              <img src="{{ asset('images/advert3.png') }}" alt="">
          </a>
      </div>
  </div>
</section>