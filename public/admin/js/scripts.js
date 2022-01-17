$(document).ready(function () {
    /*      Trigger enter event     */
    $(".enter-event").keyup(function (e) {
        if (e.keyCode == 13) {
            $("#loginBtnAdmin").click();
        }
    });

    /*      image click     */
    $(".__thumbnails .__thumbnail-pic img").on("click", function () {
        const selectedImage = $(this).attr("src");
        $(".__main-pic img").attr("src", selectedImage);
    });

    /*      delete popup        */
    $("#deleteButton").on("click", function () {
        const redirectUrl = $(this).attr("data-href");
        showConfirmPopup('Xác nhận xoá', 'Bạn có chắc chắn xoá sản phẩm này?', redirectUrl, 'fa fa-exclamation-circle fa-3x');
    });

    /*      cancel popup        */
    $("#cancelButton").on("click", function () {
        const redirectUrl = $(this).attr("data-href");
        showConfirmPopup('Xác nhận huỷ thao tác', 'Bạn có chắc chắn huỷ bỏ thao tác vừa nhập này?', redirectUrl, 'fa fa-exclamation-circle fa-3x');
    });

    $("#pop-up-close-btn").click(function () {
        $(".__popup").hide();
    });

    $("#pop-up-confirm-btn").click(function () {
        const redirectUrl = $(this).attr('data-href');
        if (redirectUrl) {
            window.location.replace(redirectUrl);
        }
    });
});

function showConfirmPopup(title, messages, href, icon = null) {
    const _this = $(".__popup-confirm");

    _this.find('#pop-up-title').html(title);
    _this.find('#pop-up-message').html(messages);

    $('#pop-up-confirm-btn').attr('data-href', href);
    $('#pop-up-icon')
        .removeClass()
        .addClass(icon);

    _this.show();
}

function showNotifyPopup(status, title, messages, icon = null) {
    const _this = $(".__popup-notify");

    _this.find('#pop-up-title').html(title);
    _this.find('#pop-up-message').html(messages);

    if (icon) {
        $('#pop-up-icon')
            .removeClass()
            .addClass(icon);
    }

    let styles = '';
    switch(status) {
        case 'success': 
            styles = 'color: #28a745; margin-bottom: 1rem';
            break;
        case 'fail':
            styles = 'color: #dc3545; margin-bottom: 1rem';
            break;
        default:
            styles = 'margin-bottom: 1rem';
    }

    $('#pop-up-icon').removeAttr("style");
    $('#pop-up-icon').attr('style', styles);

    _this.show();
}

window.addEventListener("DOMContentLoaded", (event) => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector("#sidebarToggle");
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener("click", (event) => {
            event.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.setItem(
                "sb|sidebar-toggle",
                document.body.classList.contains("sb-sidenav-toggled")
            );
        });
    }
});
