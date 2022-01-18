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
  }
}

$(document).ready(function () {
    /*      remove image        */
    $('.__remove-image').on('click', function () {
        /* hide remove button */
        $(this).hide();

        /* remove main pic if showing */
        const img = $(this).closest('.__thumbnail-input-pic').find('img')
        const mainImg = $('.__main-pic img')
        if (mainImg.attr('src') == img.attr('src')) {
            mainImg.attr('src', '')
            mainImg.hide()
            $('.__main-pic p').show()
        }

        // /* add remove img to input */
        // var imgVal = $('#removeImg').val();
        // var t = img.attr('src').split('/')
        // $('#removeImg').val(imgVal + "|" + t[t.length - 1])

        /* remove src value and hide */
        img.removeAttr("src")
        img.hide()

        /* show button again */
        const btn = $(this).closest('.__thumbnail-input-pic').find('button')
        btn.show()
    })

    $('.__thumbnail-input-pic img').click(function () {
        var imgSrc = $(this).attr('src')
        $('.__main-pic p').attr("style", "display: none !important")

        const mainImg = $('.__main-pic img')
        mainImg.attr('src', imgSrc)
        mainImg.show()
    });
})