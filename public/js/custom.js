$(window).on("load scroll", function (e) {
    var scroll = $(window).scrollTop();

    if (scroll >= 100) {
        $("body").addClass("scrolling");
    } else {
        $("body").removeClass("scrolling");
    }
});

$(document).ready(function () {
    $("a.target").on("click", function (event) {
        event.preventDefault();
        var hash = this.hash;

        $("html, body").animate(
            {
                scrollTop: $(hash).offset().top,
            },
            800,
            function () {}
        );
    });

    $(".totop").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1300);
    });

    $(".navbar-toggle").click(function () {
        $("html").toggleClass("nav-opened");
    });

    AOS.init({
        duration: 1200,
        offset: 0,
        once: true,
    });

    $("form .icon-eye").click(function () {
        var $pw_input = $(this).closest(".form-group").find(".pw");

        if ($pw_input.attr("type") === "password") {
            $pw_input.attr("type", "text");
            $(this).addClass("on");
        } else {
            $pw_input.attr("type", "password");
            $(this).removeClass("on");
        }
    });

    /*------------[Start] form-effect ------------*/

    $(".form .form-control, .form .form-select").each(function (index) {
        if ($(this).val().length != 0) {
            $(this).parents(".form-group").addClass("has-value");
        }
    });

    $(".form-select:not(.custom)").each(function (i) {
        var $dropdownList = $(this).find(".dropdown-menu").find("li");
        $dropdownList.on("click", function () {
            var dropdownListValue = $(this).html();
            $dropdownList
                .parents(".form-select")
                .find("[data-bs-toggle]")
                .html(dropdownListValue)
                .addClass("selected");

            $dropdownList.removeClass("active");
            $(this).addClass("active");
        });
    });

    $("select")
        .on("change", function () {
            if (this.value) {
                $(this).addClass("selected");
            } else {
                $(this).removeClass("selected");
            }
        })
        .change();

    (function () {
        "use strict";
        $(".input-file").each(function () {
            var $input = $(this),
                $label = $input.next(".js-labelFile"),
                labelVal = $label.html();

            $input.on("change", function (element) {
                var fileName = "";
                if (element.target.value)
                    fileName = element.target.value.split("\\").pop();
                fileName
                    ? $label
                          .addClass("has-file")
                          .find(".js-fileName")
                          .html(fileName)
                    : $label.removeClass("has-file").html(labelVal);
            });
        });
    })();

    /*------------[Start] qty ------------*/
    $(".qty-item .add").click(function () {
        var qtyValue = $(this).closest(".qty-item").find(".count");
        qtyValue.val(+qtyValue.val() + 1);
    });
    $(".qty-item .sub").click(function () {
        var qtyValue = $(this).closest(".qty-item").find(".count");
        if (qtyValue.val() > 0) qtyValue.val(+qtyValue.val() - 1);
    });

    /*------------[Start] Cookie Policy  ------------*/

    setTimeout(function () {
        $(".cookie-policy").addClass("cookie-show");
    }, 700);

    $(".cookie-policy .btn").click(function () {
        $(".cookie-policy").removeClass("cookie-show");
    });
});

$(window).on("load", function () {
    var swiperBanner = new Swiper(".swiper-banner", {
        speed: 1500,
        loop: true,
        effect: "slide",
        observer: true,
        observeParents: true,
        watchOverflow: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },

        pagination: {
            el: ".swiper-pagination.banner",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next.banner",
            prevEl: ".swiper-button-prev.banner",
        },
    });

    $(".swiper-card").each(function (index, element) {
        var $this = $(this);
        var swiper = new Swiper(this, {
            speed: 700,
            effect: "slide",

            spaceBetween: 10,
            slidesPerView: "auto",
            slidesPerGroup: 1,
            loop: false,

            observer: true,
            observeParents: true,
            watchOverflow: true,
            pagination: {
                el: $this.parent().find(".swiper-pagination"),
                clickable: true,
            },
            navigation: {
                nextEl: $this.parent().find(".swiper-button-next")[0],
                prevEl: $this.parent().find(".swiper-button-prev")[0],
            },
        });
    });

    $(".swiper-highlight").each(function (index, element) {
        var $this = $(this);
        var swiper = new Swiper(this, {
            speed: 700,
            effect: "slide",

            spaceBetween: 0,
            slidesPerView: 1,
            slidesPerGroup: 1,
            loop: false,

            observer: true,
            observeParents: true,
            watchOverflow: true,
            pagination: {
                el: $this.parent().find(".swiper-pagination"),
                clickable: true,
            },
            navigation: {
                nextEl: $this.parent().find(".swiper-button-next")[0],
                prevEl: $this.parent().find(".swiper-button-prev")[0],
            },
        });
    });

    $(".swiper-news").each(function (index, element) {
        var $this = $(this);
        var swiper = new Swiper(this, {
            speed: 700,
            effect: "slide",

            spaceBetween: 0,
            slidesPerView: 3,
            slidesPerGroup: 1,
            loop: false,

            observer: true,
            observeParents: true,
            watchOverflow: true,
            breakpoints: {
                670: {
                    slidesPerView: 3,
                },
                0: {
                    slidesPerView: 2,
                },
            },
            pagination: {
                el: $this.parent().parent().find(".swiper-pagination"),
                clickable: true,
            },
            navigation: {
                nextEl: $this.parent().parent().find(".swiper-button-next")[0],
                prevEl: $this.parent().parent().find(".swiper-button-prev")[0],
            },
        });
    });

    $(".swiper-testimonial").each(function (index, element) {
        var $this = $(this);
        var swiper = new Swiper(this, {
            speed: 700,
            effect: "slide",

            spaceBetween: 26,
            slidesPerView: 2,
            slidesPerGroup: 1,
            loop: false,

            observer: true,
            observeParents: true,
            watchOverflow: true,
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 26,
                },
                0: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
            },
            pagination: {
                el: $this.parent().parent().find(".swiper-pagination"),
                clickable: true,
            },
            navigation: {
                nextEl: $this.parent().parent().find(".swiper-button-next")[0],
                prevEl: $this.parent().parent().find(".swiper-button-prev")[0],
            },
        });
    });

    $(".preload").fadeOut();

    setTimeout(function () {
        $("html").addClass("page-loaded");
    }, 200);

    var isMobile = {
        Android: function () {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function () {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function () {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function () {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function () {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function () {
            return (
                isMobile.Android() ||
                isMobile.BlackBerry() ||
                isMobile.iOS() ||
                isMobile.Opera() ||
                isMobile.Windows()
            );
        },
    };

    if (isMobile.any()) {
        $("html").addClass("device");
    } else {
        $("html").addClass("pc");
    }

    $("img.svg-js").each(function () {
        var $img = jQuery(this);
        var imgURL = $img.attr("src");
        var attributes = $img.prop("attributes");

        $.get(
            imgURL,
            function (data) {
                // Get the SVG tag, ignore the rest
                var $svg = jQuery(data).find("svg");

                // Remove any invalid XML tags
                $svg = $svg.removeAttr("xmlns:a");

                // Loop through IMG attributes and apply on SVG
                $.each(attributes, function () {
                    $svg.attr(this.name, this.value);
                });

                // Replace IMG with SVG
                $img.replaceWith($svg);
            },
            "xml"
        );
    });
});
