$(document).ready(function () {
    $(".owl-carousel").length > 0 && $("#ad-featured_owl").owlCarousel({
        rtl: !0,
        loop: !0,
        smartSpeed: 8500,
        margin: 20,
        nav: !0,
        dots: !1,
        navText: ['<i style="float: left; margin-top: -160px;margin-left: -25px;" class="fa fa-chevron-left fa-2x"></i>', '<i style=" float: right; margin-top: -160px;margin-right: -25px;" class="fa fa-chevron-right fa-2x"></i>'],
        autoplay: !0,
        autoplayTimeout: 3e3,
        autoplayHoverPause: !0,
        responsive: {0: {items: 1}, 600: {items: 1}, 1000: {items: 4}}
    }), $(".owl-carousel").length > 0 && $("#wanted_owl").owlCarousel({
        rtl: !0,
        loop: !0,
        smartSpeed: 8500,
        margin: 20,
        nav: !0,
        dots: !1,
        navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        autoplay: !0,
        autoplayTimeout: 3e3,
        autoplayHoverPause: !0,
        responsive: {0: {items: 1}, 600: {items: 1}, 1000: {items: 4}}
    });
    var t, e = !1;
    if ($("#myCarouselProducts").carousel({interval: 4e3}).on("click", ".list-group li", function () {
            e = !0, $(".list-group li").removeClass("active"), $(this).addClass("active")
        }).on("slid.bs.carousel", function (t) {
            if (!e) {
                var a = $(".list-group").children().length - 1, n = $(".list-group li.active");
                n.removeClass("active").next().addClass("active"), a == parseInt(n.data("slide-to")) && $(".list-group li").first().addClass("active")
            }
            e = !1
        }), $(".number-spinner button").mousedown(function () {
            btn = $(this), input = btn.closest(".number-spinner").find("input"), btn.closest(".number-spinner").find("button").prop("disabled", !1), t = "up" == btn.attr("data-dir") ? setInterval(function () {
                null == input.attr("max") || parseInt(input.val()) < parseInt(input.attr("max")) ? input.val(parseInt(input.val()) + 1) : (btn.prop("disabled", !0), clearInterval(t))
            }, 50) : setInterval(function () {
                null == input.attr("min") || parseInt(input.val()) > parseInt(input.attr("min")) ? input.val(parseInt(input.val()) - 1) : (btn.prop("disabled", !0), clearInterval(t))
            }, 50)
        }).mouseup(function () {
            clearInterval(t)
        }), $(".dropdown").hover(function () {
            $(".dropdown-menu", this).not(".in .dropdown-menu").stop(!0, !0).slideDown("400"), $(this).toggleClass("open")
        }, function () {
            $(".dropdown-menu", this).not(".in .dropdown-menu").stop(!0, !0).slideUp("400"), $(this).toggleClass("open")
        }), $("#myTabs a").length > 0) {
        $("#myTabs a").click(function (t) {
            location.reload()
        });
        var a = window.location.hash;
        if (a.length > 0) {
            var n = window.location.hash.substring(1);
            $("#myTabs li").removeClass("active"), $("#myTabs li").find("a[href='" + a + "']").closest("li").addClass("active"), $("#myTabsContent > .tab-pane").removeClass("active"), $("#myTabsContent").find("#" + n).addClass("active")
        } else $("#myTabs li:first-child").addClass("active"), $("#myTabsContent .tab-pane:first-child").addClass("active")
    }
    $("#fileUpload").on("change", function () {
        var t = $(this)[0].files.length, e = $(this)[0].value, a = e.substring(e.lastIndexOf(".") + 1).toLowerCase(), n = $("#image-holder");
        if ($("#image_default").empty(), "gif" == a || "png" == a || "jpg" == a || "jpeg" == a)if ("undefined" != typeof FileReader)for (var i = 0; i < t; i++) {
            var s = new FileReader;
            s.onload = function (t) {
                $("<img />", {src: t.target.result, class: "thumb-image p-1", width: "100"}).appendTo(n)
            }, n.show(), s.readAsDataURL($(this)[0].files[i])
        } else alert("This browser does not support FileReader."); else alert("Pls select only images")
    })
}), $(window).load(function () {
    var t = $("#myCarouselProducts .carousel-inner").innerHeight(), e = $("#myCarouselProducts .item").length, a = Math.round(t / e + 1);
    $("#myCarouselProducts .list-group-item").outerHeight(a)
}), $(document).ready(function () {
    $("#price").keyup(function () {
        var t = $("#price").val(), e = 1 * (t = Number(t)) / 400;
        (e = Number(e)) > 10 ? $("#commission").val(e) : $("#commission").val(10)
    })
});


google.maps.event.addDomListener(window, 'load', initialize);
function initialize() {
    var input = document.getElementById('autocomplete_search');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        // place variable will have all the information you are looking for.
        $('#lat').val(place.geometry['location'].lat());
        $('#long').val(place.geometry['location'].lng());
    });
}