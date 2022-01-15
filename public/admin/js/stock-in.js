$(document).ready(function () {
  $('#category-selector').on('change', function (e) {
    const selectedValue = this.value;
    const href = $(this).attr('data-href');
    
    if (selectedValue && href) {
      const data = getProductByCategoryId(selectedValue, href);
    }
  });

  $('#stock-in-form').keypress(function (e) {
      if (e.which == '13') {
          e.preventDefault();
          $('#stock-in-btn').click()
      }
  });

  $('#stock-in-btn').click(function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    const validation = validateStockInForm();
    if (!validation.isValid) {
      $('#validation-error-msg').html(validation.messages[0]);
      return;
    }

    let form = $('#stock-in-form');
    let url = form.attr("data-action");
    let data = $('#stock-in-form').find(":input").serialize();

    $.ajax({
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: url,
      data: data,
      success: function (data) {
        if (data.status == 200) {
          showNotifyPopup('success', 'Thành công', 'Nhập kho đã được lưu vào hệ thống');
          $('#stock-in-form')[0].reset();
        } else {
          showNotifyPopup('fail', 'Thất bại', 'Đã có lỗi xảy ra trong quá trình nhập kho, vui lòng thử lại sau', 'fas fa-exclamation-triangle fa-3x');
        }
      },
      error: function () {
        showNotifyPopup('fail', 'Thất bại', 'Đã có lỗi xảy ra trong quá trình nhập kho, vui lòng thử lại sau', 'fas fa-exclamation-triangle fa-3x');
      },
    });
  });

});

function getProductByCategoryId(id, href) {
  var url = href + `?category=${id}`;

  $.ajax({
    type: "GET",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: url,
    success: function (data) {
      if (data.status == 200) {
        const products = data.products;

        let htmlContent = '';
        if (products.length > 0) {
          htmlContent = '<option value="" selected disabled hidden>Chọn sản phẩm</option>';
          products.forEach(el => {
            htmlContent += `<option value="${el.id}">${el.name}</option>`;
          });
          $('#product-selector').prop('disabled', false);
        } else {
          htmlContent = '<option value="" selected disabled hidden>Không có sản phẩm</option>';
          $('#product-selector').prop('disabled', true);
        }

        $('#product-selector').empty();
        $('#product-selector').append(`${htmlContent}`);
      } else {
        console.log('khong co du lieu');
      }
    },
    error: function () {
      console.error("Loi roi");
    },
  });
}

function validateStockInForm() {
  const isCategoryNull = $('#category-selector').val() == null;
  const isProductNull = $('#product-selector').val() == null;
  const isQuantityNull = $('#product-quantity').val() == '';
  const isQuantityInvalid = $('#product-quantity').val() <= 0;

  const errors =  [
    isCategoryNull ? 'Vui lòng chọn thể loại sản phẩm' : null,
    isProductNull ? 'Vui lòng chọn sản phẩm' : null,
    isQuantityNull ? 'Vui lòng nhập số lượng sản phẩm' : null,
    isQuantityInvalid ? 'Số lượng sản phẩm không hợp lệ' : null,
  ]

  const result = errors.filter(function (el) {
    return el != null;
  });

  return {
    isValid: result.length == 0,
    messages: result
  }
}