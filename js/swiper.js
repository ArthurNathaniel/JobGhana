var swiper = new Swiper(".mySwiper", {
    autoplay:true,
    loop:true,
    speed:2150,
    slidesPerView: 1,
    spaceBetween: 10,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      440: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 40,
      },
      1024: {
        slidesPerView: 4,
        spaceBetween: 30,
      },
    },
  });