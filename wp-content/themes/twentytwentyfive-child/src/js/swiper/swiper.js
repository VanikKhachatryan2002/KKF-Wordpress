import Swiper from 'swiper/bundle';
import '../../../node_modules/swiper/swiper-bundle.min.css';

import '@fancyapps/fancybox/dist/jquery.fancybox.css';
import '@fancyapps/fancybox';

// Initialize Swiper
const swiper = new Swiper('.swiper-container', {
    slidesPerView: 3,
    spaceBetween: 1,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev ',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true,
    },
    autoplay: {
        delay: 3500,
    },
    watchOverflow: true,
    edgeSwipeDetection: true,
    edgeSwipeThreshold: 100,

    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10,
            watchOverflow: true
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 20,
            watchOverflow: true
        },
        1248: {
            slidesPerView: 3,
            watchOverflow: true
        },
    }
});

const category_swiper = new Swiper('.swiper-container-categories', {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true,
    },
    pagination: {
        el: ".swiper-pagination",
    },

});

jQuery(($) => {
    $('[data-fancybox]').fancybox({
        loop: true,
        toolbar: {
            display: {
                left: ['zoom', 'fullScreen'],
                right: ['close'],
            },
            position: 'bottom',
        },
        caption: function (instance, item) {
            return `<div class="fancybox-caption">${item.caption}</div>`;
        },
        buttons: [
            'zoom',
            'fullScreen',
            'close'
        ],
        caption: function (instance, item) {
            return $(this).attr("data-caption") || $(this).find("img").attr("alt");
        },
        arrows: true,
        transitionEffect: 'fade',
        transitionDuration: 600,
    });
});
