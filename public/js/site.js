// Please see documentation at https://docs.microsoft.com/aspnet/core/client-side/bundling-and-minification
// for details on configuring this project to bundle and minify static web assets.

// Write your JavaScript code.
// @ts-nocheck

$(document).ready(function () {
    const menu = document.querySelector(".__menu");
    const navOpen = document.querySelector(".__hamburger");
    const navClose = document.querySelector(".__close");

    navOpen.addEventListener("click", () => {
        menu.classList.add("__show");
        document.body.classList.add("__show");
    });

    navClose.addEventListener("click", () => {
        menu.classList.remove("__show");
        document.body.classList.remove("__show");
    });

    // Scroll To
    const links = [...document.querySelectorAll(".__scroll-link")];
    links.map((link) => {
        if (!link) return;
        link.addEventListener("click", (e) => {
            e.preventDefault();

            const id = e.target.getAttribute("href").slice(1);

            const element = document.getElementById(id);
            const fixNav = navBar.classList.contains("__fix-nav");
            let position = element.offsetTop - navHeight;

            window.scrollTo({
                top: position,
                left: 0,
            });

            navBar.classList.remove("__show");
            menu.classList.remove("__show");
            document.body.classList.remove("__show");
        });
    });

    $("#sortBy").on("change", function (e) {
        //get selected value
        var optionSelected = $(this).find("option:selected");
        var valueSelected = optionSelected.val();
        
        redirectUrl = `${location.protocol}//${location.host + location.pathname}?filter=${valueSelected}`;
        window.location.href = redirectUrl;
    });

    /*      image click     */
    $(".__thumbnails .__thumbnail img").on("click", function () {
        const selectedImage = $(this).attr("src");
        $(".__main img").attr("src", selectedImage);
    });

    const registerErrMsg = $("#error-msg-reg").html();
    if (registerErrMsg != "") {
        $("#_RegForm").css("transform", "translateX(-300px)");
        $("#_LoginForm").css("transform", "translateX(-300px)");
        $("#_Indicator").css("transform", "translateX(110px)");
    }

    $("#signin_span").click(() => {
        $("#_RegForm").css("transform", "translateX(0px)");
        $("#_LoginForm").css("transform", "translateX(0px)");
        $("#_Indicator").css("transform", "translateX(0px)");
    });

    $("#signup_span").click(() => {
        $("#_RegForm").css("transform", "translateX(-300px)");
        $("#_LoginForm").css("transform", "translateX(-300px)");
        $("#_Indicator").css("transform", "translateX(110px)");
    });

    let x;
    function showToast(mess, toastMess) {
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
        window.scrollTo({ top: 0, behavior: "smooth" });
    }

    $("#close").on("click", () => {
        $("#toast").css("transform", "translateX(400px)");
    });

    // add product to cart
    $("#addToCartForm").submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var form = $(this);
        var url = form.attr("action");
        var data = $(this).find(":input").serialize();

        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            data: data,
            success: function (data) {
                if (data.status == 200) {
                    showToast("success", "Sản phẩm đã được thêm vào giỏ hàng");
                } else {
                    showToast(
                        "fail",
                        "Rất tiếc đã xảy ra lỗi. Xin vui lòng thử lại sau."
                    );
                }
            },
            error: function () {
                showToast(
                    "fail",
                    "Rất tiếc đã xảy ra lỗi. Xin vui lòng thử lại sau."
                );
            },
        });
    });

    $(".__reply-button").click(function () {
        var isShow =
            $(this).closest("li").find("ul form").css("display") == "none"
                ? false
                : true;
        if (isShow) {
            $(this).find("small").html("Trả lời");
            $(this).closest("li").find("ul form").hide();
        } else {
            $(this).find("small").html("Ẩn trả lời");
            $(this).closest("li").find("ul form").show();
        }
    });

    $(".replyCommentSubmit").click(function () {
        var content = $(this).closest(".row").find("div input").val();
        console.log(content);
        if (content) {
            $(this).closest("form").submit();
        } else {
            $(this)
                .closest(".row")
                .find(".replyCommentError")
                .text("Yêu cầu nhập nội dung bình luận");
        }
    });

    /*      Trigger enter event     */
    $(".enter-event").keyup(function (e) {
        if (e.keyCode == 13) {
            $(this).closest(".row").find("div button").click();
        }
    });

    $(".remove-item-from-cart").click(function () {
        const trElement = $(this).closest(".items_tr");
        var id = trElement.attr("data-id");
        var url = $(this).attr("data-href");
        var data = { id };

        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url,
            data,
            success: function (data) {
                if (data.status == 200) {
                    var newTotalPrice = 0;
                    const isEmpty = $("tbody tr").length == 2;

                    if (isEmpty) {
                        trElement.remove();
                        $("tbody").append(
                            '<tr><td colspan="6" class="text-center border h4">Giỏ hàng rỗng, bạn chưa chọn mua sản phẩm nào.</td></tr>'
                        );
                    } else {
                        const quantity = parseInt(
                            trElement.find("input[name='items_quantity[]']").val()
                        );
                        const unitPrice = parseInt(
                            trElement.find("input[name='items_quantity[]']").attr("data-unit-price")
                        );
                        const preTotal = quantity * unitPrice;

                        const preTotalPrice = parseInt(
                            $("#total-price").attr("data-total")
                        );
                        newTotalPrice = preTotalPrice - preTotal;
                        trElement.remove();
                    }
                    $("#total-price").attr("data-total", newTotalPrice);
                    $("#total-price").text(
                        newTotalPrice.toLocaleString("it-IT", {
                            currency: "VND",
                        }) + "đ"
                    );
                    showToast("success", "Sản phẩm đã được xoá khỏi giỏ hàng");
                } else {
                    showToast(
                        "fail",
                        "Rất tiếc đã xảy ra lỗi. Xin vui lòng thử lại sau."
                    );
                }
            },
            error: function () {
                showToast(
                    "fail",
                    "Rất tiếc đã xảy ra lỗi. Xin vui lòng thử lại sau."
                );
            },
        });
    });
});

gsap.from(".__logo", { opacity: 0, duration: 1, delay: 0.6, x: -20 });
gsap.from(".__hamburger", { opacity: 0, duration: 1, delay: 0.6, x: 20 });
gsap.from(".__cart-icon", { opacity: 0, duration: 1, delay: 0.6, y: -10 });
gsap.from(".__logout-icon", { opacity: 0, duration: 1, delay: 0.6, y: -10 });
gsap.from(".__hero-img", { opacity: 0, duration: 1, delay: 1.5, x: -200 });
gsap.from(".__hero-content h2", { opacity: 0, duration: 1, delay: 2, y: -50 });
gsap.from(".__hero-content h1", {
    opacity: 0,
    duration: 1,
    delay: 2.5,
    y: -45,
});
gsap.from(".__hero-content a", { opacity: 0, duration: 1, delay: 3.5, y: 50 });
