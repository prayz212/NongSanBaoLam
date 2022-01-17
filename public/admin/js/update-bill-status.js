$(document).ready(function () {
  
    $('#update-bill-btn').click(function(e) {
      e.preventDefault();
      e.stopImmediatePropagation();
  
      let form = $('#update-bill-status');
      let url = form.attr("data-action");
      let data = $('#update-bill-status').find(":input").serialize();
      let id = $('#update-bill-btn').attr("data-bill-id");
  
      $.ajax({
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: url,
        data:  data + "&id=" + id, 
        success: function (data) {
          if (data.status == 200) {
            showNotifyPopup('success', 'Thành công', 'Trạng thái đơn hàng đã được cập nhật');
            updateBillStatus(data.delivery_at, data.bill_status);
          } else {
            showNotifyPopup('fail', 'Thất bại', 'Đã có lỗi xảy ra trong quá trình cập nhật tình trạng đơn hàng, vui lòng thử lại sau', 'fas fa-exclamation-triangle fa-3x');
          }
        },
        error: function () {
          showNotifyPopup('fail', 'Thất bại', 'Đã có lỗi xảy ra trong quá trình cập nhật tình trạng đơn hàng, vui lòng thử lại sau', 'fas fa-exclamation-triangle fa-3x');
        },
      });
    });
  
});

function updateBillStatus(delivery_at, bill_status) {
    $('#delivery-at').html(delivery_at ? delivery_at : bill_status);
    $('#status').html(bill_status);
}