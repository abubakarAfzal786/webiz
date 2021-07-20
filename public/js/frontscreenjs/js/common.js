document.addEventListener( 'DOMContentLoaded', function () {
    new Splide( '.company-splide', {
        direction: 'ttb',
        type   : 'loop',
        height   : '542px',
        perPage: 2,
        arrows: false,
        pagination: false,
        autoplay: true,
        interval: 3000,
        pauseOnHover: false,
        pauseOnFocus: false,
        easing: 'cubic-bezier(.17,.67,.83,1.00)',
    } ).mount();
} );

//# sourceMappingURL=maps/common.js.map
