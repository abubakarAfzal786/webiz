function hold_all_scroll_page(fix = false) {
    if (fix) {
        window.addEventListener('wheel', holdScroll, {passive: false});
        window.addEventListener('DOMMouseScroll', holdScroll, {passive: false});
        document.addEventListener('touchmove', holdScroll, {passive: false});
    } else {
        window.removeEventListener('wheel', holdScroll, {passive: false});
        window.removeEventListener('DOMMouseScroll', holdScroll, {passive: false});
        document.removeEventListener('touchmove', holdScroll, {passive: false});
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
        window.addEventListener('wheel', preventDefault, {passive: false});
        window.addEventListener('DOMMouseScroll', preventDefault, {passive: false});
        document.addEventListener('touchmove', preventDefault, {passive: false});
        // $(document).on("touchmove", preventDefault)
    } else {
        window.removeEventListener('wheel', preventDefault, {passive: false});
        window.removeEventListener('DOMMouseScroll', preventDefault, {passive: false});
        document.removeEventListener('touchmove', preventDefault, {passive: false});
    }
}

var ts;
$(document).on('touchstart', function (e) {
    ts = e.originalEvent.touches[0].clientY;
});

function preventDefault(e) {
    e = e || window.event;
    var area;
    if ($(e.target).closest(".modal-wrap .scroll-wrap").length) {
        area = $(e.target).closest(".modal-wrap .scroll-wrap");
    } else if ($(e.target).closest(".iziModal").length) {
        area = $(e.target).closest(".iziModal-wrap");
    } else {
        area = $(e.target);
    }
    var parentPopup = $(e.target).closest(".modal-wrap .scroll-wrap, .iziModal").length || $(e.target).hasClass('.popupContent');
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

function hasLodash(str) {
    str = str || '';
    return !!str.match(/\_/);
}

function inputEffect(elem) {
    /*placeholder-effect*/
    // elem.val("");
    if (!elem.val().length == 0) {
        elem.addClass("has-content");
    }

    elem.focusout(function () {
        // if ($(this).attr("type") == "tel" && $(this).val()[$(this).val().length - 1] == "_") {
        if (elem.attr("type") == "tel" && hasLodash($(this).val())) {
            elem.val("");
        }
        if (elem.val() != "") {
            elem.addClass("has-content");
        } else {
            elem.removeClass("has-content");
        }
    });

    elem.keyup(function () {
        if (elem.parent().hasClass("error")) {
            elem.parent().removeClass("error")
        }
    });
    /*placeholder-effect*/
}

function tableMobData() {
    $(".responsive-table table").each(function () {
        // const th = $(this).find('thead th').slice(1);

        const th = $(this).find('thead td');

        // const title = $(this).find('thead th').first().text();
        $(this).find('tbody tr').each(function () {
            const td = $(this).find("td");
            // const td = $(this).find("td").slice(1);
            td.each(function (index) {
                // $(this).attr("data-label", `${title} ${th.eq(index).text()}`)
                $(this).attr("data-label", `${th.eq(index).text()}`)
            });
        });
    });
}

$(document).ready(function () {

    // $("input[type=tel]").mask("(999) 999-9999");

    $('[data-fancybox]').fancybox({
        closeExisting: true,
        buttons: ['close'],
        afterShow: function () {
            hold_scroll_page(true);
        },
        afterClose: function () {
            hold_scroll_page(false);
        }
    });

    if ($(".responsive-table table").length) {
        tableMobData();
    }

    $(document).on('click', '.open-chat-list button', function () {
        $('.chat-list-wrap').addClass('open')
    });

    $(document).on('click', '.close-chat-list button', function () {
        $('.chat-list-wrap').removeClass('open')
    });

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

    $(document).on('click', '.set-rating p span.icon-empty', function (e) {
        $(this).addClass('active').siblings().removeClass('active');
    });

    $("input.placeholder-effect, textarea.placeholder-effect").each(function () {
        let input = $(this);
        inputEffect(input);
    });
    $("select.placeholder-effect").each(function () {
        let select = $(this);

        if (!select.find('option[hidden]').is(':selected')) {
            select.addClass("has-content");
        }

        select.change(function () {
            if (select.find('option[hidden]').is(':selected')) {
                select.removeClass("has-content");

            } else {
                select.addClass("has-content");
            }
        });
    });

    $(document).on('click', '.tabs-menu ul li', function () {
        if (!$(this).hasClass('open')) {
            let tab = $(this).attr('data-index'),
                showItem = $(this).closest('.tabs-wrap').find('.tabs-content[data-index="' + tab + '"]');
            $(this).addClass('open').siblings().removeClass('open');
            showItem.addClass('open').siblings().removeClass('open');
        }
    });

    $(document).on('click', '.quantity-wrap a', function (e) {
        e.preventDefault();
        let newVal,
            $button = $(this),
            oldValue = $button.closest('.quantity-wrap').find('input').val();

        if ($button.attr('data-act') == '+') {
            newVal = parseInt(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 1) {
                newVal = parseInt(oldValue - 1);
            } else {
                newVal = 1;
            }
        }
        $button.closest('.quantity-wrap').find('input').val(newVal);
    });

    var move_access = false;
    var scrollLeft;

    $('.touch-scroll').on('mousedown touchstart', function (event) {
        move_access = true;
        if (event.type == 'touchstart') {
            var touch = event.originalEvent.touches[0] || event.originalEvent.changedTouches[0];
            var offset = touch.clientX;
        } else {
            //если нажата кнопка мышки:
            var offset = event.clientX;
        }
        touchstart = offset;
        scrollLeft = $(this).find('.scroll-wrap').scrollLeft();
    });
    $(document).on('mouseup touchend', function (event) {
        move_access = false;
        if (event.type == 'touchend') {
            var touch = event.originalEvent.touches[0] || event.originalEvent.changedTouches[0];
            var offset = touch.clientX;
        } else {
            //если нажата кнопка мышки:
            var offset = event.clientX;
        }
        touchstart = offset;
    });
    $('.touch-scroll').on('mousemove touchmove', function (event) {
        if (move_access) {
            if (event.type == 'touchmove') {
                var touch = event.originalEvent.touches[0] || event.originalEvent.changedTouches[0];
                var offset = touch.clientX;
            } else {
                //если нажата кнопка мышки:
                var offset = event.clientX;
            }
            $(this).find('.scroll-wrap').scrollLeft(scrollLeft + (touchstart - offset));
            //отменяем 'всплытие сообщений', чтобы не вызывался клик на тач-устройствах.
            event.stopPropagation();
            event.preventDefault();
        }
    });

});
const Upload = {
    // Handle events it the box
    init: function (upload) {
        let input = upload.find('label.file input');
        upload.on('drag dragstart dragend dragover dragenter dragleave drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
        })
            .on('dragover dragenter', function () {
                if (!upload.hasClass('is-dragover')) {
                    upload.addClass('is-dragover');
                }
            })
            .on('dragleave dragend drop', function () {
                if (upload.hasClass('is-dragover')) {
                    upload.removeClass('is-dragover');
                }
            })
            .on('drop', function (e) {
                files = e.originalEvent.dataTransfer.files;
                Upload.submit(files, input);

            });
        input.change(function () {
            Upload.submit(this.files, input);
        });
    },

    // Check the uploaded file
    submit: function (files, item) {
        // Check file extension and size
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            let type = file['type'].substr(0, file['type'].indexOf('/'));
            if (type != 'image') {
                alert('This file type is not supported. Only images should be uploaded');
                return;
            }
            if (file['size'] > 10485760) {
                alert('This file is too heavy, it weights more than 10M');
                return;
            }
            Upload.display(file, item);
        }
    },

    // Display an uploaded file
    display: function (file, item) {
        let img = item.closest('.upload-item').find('.ready-photo img');
        let reader = new FileReader();
        reader.onloadend = function () {
            let parent = item.closest('.upload-item');
            parent.find('.upload-wrap').hide();
            parent.find('.preview-wrap').show();
            // parent.find('.ready-photo img').attr('src', reader.result);
            let preview = $('<div class="ready-photo"><span class="icon-close"></span><img src="' + reader.result + '" alt=""></div>');
            preview.insertBefore(parent.find('.photo-wrap .add-extra'));
        };
        reader.readAsDataURL(file);
    },
};

function uploadInit() {
    $('.upload-wrap .upload:not(".init")').each(function () {
        $(this).addClass('init');
        Upload.init($(this));
    });
}

function dataURLtoFile(dataurl, filename) {
    var arr = dataurl.split(','),
        mime = arr[0].match(/:(.*?);/)[1],
        bstr = atob(arr[1]),
        n = bstr.length,
        u8arr = new Uint8Array(n);

    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }

    return new File([u8arr], filename, {type: mime});
}

$(document).ready(function () {
    uploadInit();

    $(document).on('change', '.upload-wrap .upload label.camera input', function () {
        Upload.submit(this.files, $(this));
    });


    $(document).on('click', '.ready-photo span.icon-close', function () {
        let parent = $(this).closest('.upload-item'),
            currentItem = $(this).closest('.ready-photo'),
            input = parent.find('.upload-wrap .upload label input');
        if ($(this).closest('.preview-wrap').find('.ready-photo').length === 1) {
            parent.find('.upload-wrap').show();
            parent.find('.preview-wrap').hide();
        }
        let dataId = currentItem.find('img').attr('data-id');
        if (dataId) Room.imgToDelete.push(dataId);
        $(this).closest('.upload-item').find('.photo-wrap .ready-photo').eq(currentItem.index()).remove();
        // input.val(null);
    });

    $(document).on('click', '.preview-wrap .add-extra button', function () {
        $(this).closest('.upload-item').find('.upload-wrap label.file').click();
    });

});
//# sourceMappingURL=maps/common.js.map
