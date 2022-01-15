$(document).ready(function () {
    /*       RATING-STAR    */
    /* 1. Visualizing things on Hover - See next part for action on click */
    $('#stars li').on('mouseover', function () {
      var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

        // Now highlight all the stars that's not after the current hovered star
        $(this).parent().children('li.__star').each(function (e) {
            if (e < onStar) {
                $(this).addClass('__hover');
            }
            else {
                $(this).removeClass('__hover');
            }
        });
    }).on('mouseout', function () {
        $(this).parent().children('li.__star').each(function (e) {
            $(this).removeClass('__hover');
        });
    });

    var ratingValue = 0;
    /* 2. Action to perform on click */
    $('#stars li').on('click', function () {
        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.__star');

        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('__selected');
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('__selected');
        }

        // JUST RESPONSE (Not needed)
        ratingValue = parseInt($('#stars li.__selected').last().data('value'), 10);
    });

    //Show rating modal
    var productId = -1, receiptId = -1;
    let _curRow = null;
    $('#product-table tbody tr').on('click', function () {

        _curRow = $(this);
        const isEnable = $(this).attr('data-enable');
        const isRated = $(this).attr('data-rated');
        if (isEnable && !isRated) {
            $('.__popup-rating').show();
            productId = $(this).attr('data-product')
            receiptId = $(this).attr('data-receipt')
        } 
        else if (isEnable && isRated) {
            // showToast('fail', 'Bạn đã đánh giá sản phẩm này', 'Không hợp lệ')
            $('.__popup-rated').show();
        }
    });

    $('._submit-rating').click(function (e) {
        e.stopImmediatePropagation();
        $('.__popup-rating').hide();
        const url = $('.__popup-rating').attr('data-href');

        if (ratingValue == 0) {
            showToast("fail", "Cần chọn số sao đánh giá.")
            return;
        }

        var formData = {
            productId: productId,
            billId: receiptId,
            rating: ratingValue
        };;

        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            data: formData,
            success: function (data) {
                console.log(data)
                if (data.status == 200) {
                    showToast("success", "Đã lưu đánh giá.")
                    if (_curRow) {
                        _curRow.attr('data-rated', false);
                    }
                } else {    
                    showToast("fail", "Rất tiếc đã xảy ra lỗi. Xin vui lòng thử lại sau.")
                }

                var stars = $("#stars").children('li.__star');
                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('__selected');
                    $(stars[i]).removeClass('__hover');
                }
            }
        });
    });

    $('.__popup-rating-close').click(function () {
        $('.__popup-rating').hide();
    });

    $('.__popup-rated-close').click(function () {
        $('.__popup-rated').hide();
    });

    let x;
    function showToast(mess, toastMess, toastTitle = null) {
        clearTimeout(x);

        if (mess == "success") {
            $("#toast").removeClass("fail");
        } else {
            $("#toast").removeClass("success");
        }

        $("#toast").addClass(mess);
        $("#toast").css("transform", "translateX(0px)");
        x = setTimeout(() => {
            $("#toast").css("transform", "translateX(400px)");
        }, 7000);

        if (mess == "success") {
            $(".toast-sta").text("Thành công");
            $(".toast-msg").text(toastMess);
        } else {
            $(".toast-sta").text("Thất bại");
            $(".toast-msg").text(toastMess);
        }

        if (toastTitle) {
            $(".toast-sta").text(toastTitle);
        }
        window.scrollTo({ top: 0, behavior: "smooth" });
    }

    $("#close").on("click", () => {
        $("#toast").css("transform", "translateX(400px)");
    });
});