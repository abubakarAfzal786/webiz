function hold_all_scroll_page(fix = false) {
    if (fix) {
        window.addEventListener('wheel', holdScroll, { passive: false });
        window.addEventListener('DOMMouseScroll', holdScroll, { passive: false });
        document.addEventListener('touchmove', holdScroll, { passive: false });
    } else {
        window.removeEventListener('wheel', holdScroll, { passive: false });
        window.removeEventListener('DOMMouseScroll', holdScroll, { passive: false });
        document.removeEventListener('touchmove', holdScroll, { passive: false });
    }
}

function holdScroll(e) {
    e = e || window.event;
    if (e.preventDefault)
        e.preventDefault();
    e.returnValue = false;
    return false;
}


function hold_scroll_page(fix = false) {
    if (fix) {
        window.addEventListener('wheel', preventDefault, { passive: false });
        window.addEventListener('DOMMouseScroll', preventDefault, { passive: false });
        document.addEventListener('touchmove', preventDefault, { passive: false });
        // $(document).on("touchmove", preventDefault)
    } else {
        window.removeEventListener('wheel', preventDefault, { passive: false });
        window.removeEventListener('DOMMouseScroll', preventDefault, { passive: false });
        document.removeEventListener('touchmove', preventDefault, { passive: false });
    }
}
var ts;
$(document).on('touchstart', function (e) {
    ts = e.originalEvent.touches[0].clientY;
});

function preventDefault(e) {
    e = e || window.event;
    var area;
    if ($(e.target).closest(".popupContent").length) {
        area = $(e.target).closest(".popupContent");
    } else if ($(e.target).closest(".main-nav").length) {
        area = $(e.target).closest(".main-nav .nav-list");
    }else if ($(e.target).closest(".iziModal").length) {
        area = $(e.target).closest(".iziModal-wrap");
    } else {
        area = $(e.target);
    }
    var parentPopup = $(e.target).closest(".popupContent, .main-nav, .iziModal").length || $(e.target).hasClass('.popupContent');
    if (!parentPopup) {
        e.preventDefault();
        e.returnValue = false;
        return false;
    }
    /*if ($(e.target).closest(".chosen-container").length) {
        e.preventDefault();
        e.returnValue = false;
        return false;
    }*/
    var delta = e.deltaY || e.detail || e.wheelDelta;
    if (e.type == "touchmove") {
        var tob = e.changedTouches[0], // reference first touch point for this event
         offset = parseInt(tob.clientY);
        if (ts < offset - 5) {
            delta = -100;
        } else if (ts > offset + 5) {
            delta = 100;
        }
    }
    if (delta <= 0 && area[0].scrollTop <= 0) {
        e.preventDefault();
    }
    if (delta > 0 && area[0].scrollHeight - area[0].clientHeight - area[0].scrollTop <= 1) {
        e.preventDefault();
    }
}
const reviewsMass = [];

let reviewsSlider;

$(document).ready(function () {
    $('.reviews-slider .swiper-container').each(function (index, element) {
        let $this = $(this);
        reviewsSlider = new Swiper($this, {
            slidesPerView: 1,
            spaceBetween: 10,
            grabCursor: true,
            loop: true,
            loopAdditionalSlides: 1,
            mousewheelControl: true,
            watchSlidesVisibility: true,
            lazyLoading: true,
            lazy: {
                preloadImages: true,
                loadPrevNext: true,
                loadPrevNextAmount: 1,
                elementClass: 'lazy',
            },
            navigation: {
                nextEl: $this.closest('.reviews-slider').find('.next-slide span')[0],
                prevEl: $this.closest('.reviews-slider').find('.prev-slide span')[0],
                disabledClass: 'disabled'
            }
        });
        reviewsMass.push(reviewsSlider);

    });

});
$(document).ready(function () {

    $(document).on('click', '.toolbar-menu .open-menu button', function () {
        $('.page-menu .menu-list').addClass('open')
    });
    $(document).on('click', '.page-menu .menu-list .close-list button', function () {
        $('.page-menu .menu-list').removeClass('open')
    });

    $(document).on('click', function (e) {
        if (!$(e.target).closest('.page-menu .menu-list, .toolbar-menu .open-menu').length && $('.page-menu .menu-list').hasClass('open')) {
            $('.page-menu .menu-list').removeClass('open')
        }
        e.stopPropagation();
    });

});
//# sourceMappingURL=maps/common.js.map
