require("./bootstrap");

// core version + navigation, pagination modules:
import Swiper, { Navigation, Pagination } from "swiper";
// import Swiper and modules styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

// configure Swiper to use modules
Swiper.use([Navigation, Pagination]);

// init Swiper:
const swiper = new Swiper(".swiper", {
    // Optional parameters
    direction: "horizontal",
    loop: true,
    slidesPerView: 3,
    spaceBetween: 30,
    freeMode: true,

    // If we need pagination
    pagination: {
        el: ".swiper-pagination",
        type: "bullets",
        clickable: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});
