let companySlider = $(".company-list .list-slider");

if (companySlider.length) {
    companySlider.slick({
        rows: 2,
        slidesToShow: 2,
        infinite: true,
        arrows: false,
        dots: false,
        vertical: true,
        verticalSwiping: true,
        autoplay: true,
        autoplaySpeed: 3000,
        pauseOnHover: false,
        pauseOnFocus: false,
        adaptiveHeight: true,
    });
}
//# sourceMappingURL=maps/common.js.map
