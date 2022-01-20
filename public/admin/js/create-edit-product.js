function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      $(input).closest('.__thumbnail-input-pic').find('button').css('display', 'none')

      const img = $(input).closest('.__thumbnail-input-pic').find('img')
      reader.onload = function (e) {
          img.attr('src', e.target.result);
          img.css('display', 'block');
          $(input).closest('.__thumbnail-input-pic').find('.__remove-image').css('display', 'block')
      };

      reader.readAsDataURL(input.files[0]);

      /* change input status */
      $(input).attr('data-hasValue', 'true');
  }
}

$(document).ready(function () {
    /*      remove image        */
    $('.__remove-image').on('click', function () {
        /* hide remove button */
        $(this).hide();

        /* remove input value and change input status */
        const _input = $(this).closest('.__thumbnail-input-pic').find('input')
        _input.val('');
        _input.attr('data-hasValue', false);

        /* remove main pic if showing */
        const img = $(this).closest('.__thumbnail-input-pic').find('img')
        const mainImg = $('.__main-pic img')
        if (mainImg.attr('src') == img.attr('src')) {
            mainImg.attr('src', '')
            mainImg.hide()
            $('.__main-pic p').show()
        }

        /* add removed images to hidden input */
        if ($('#removed-images').length && img.attr('src').startsWith('https', 0)) {
            let removeArrays = $('#removed-images').val();
            let removedElement = img.attr('src');
            $('#removed-images').val(removeArrays + "|" + removedElement);
        }

        /* remove src value and hide */
        img.removeAttr("src");
        img.hide();

        /* show button again */
        const btn = $(this).closest('.__thumbnail-input-pic').find('button');
        btn.show();
    })

    $('.__thumbnail-input-pic img').click(function () {
        var imgSrc = $(this).attr('src')
        $('.__main-pic p').attr("style", "display: none !important")

        const mainImg = $('.__main-pic img')
        mainImg.attr('src', imgSrc)
        mainImg.show()
    });

    //show loading animation
    $('#create-product-btn').click(function () {
        $(this).hide();
        $('#create-product-loading-btn').show();
        $('#create-product-form').submit();
    });

    $('#update-product-btn').click(function (e) {
        e.preventDefault();
        //check have at least one images of product
        const imagesCount = $("input[name='images[]']").map(function() {return $(this).attr('data-hasValue')})
            .get()
            .filter(el => el == 'true' );

        if (imagesCount.length <= 0) {
            $('#update-error-msg').html('Sản phẩm phải có ít nhất một hình ảnh');
        }
        else {
            $(this).hide();
            $('#update-product-loading-btn').show();
            $('#update-product-form').submit();
        }
    });
})