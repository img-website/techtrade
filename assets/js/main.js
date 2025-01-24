
var swiper = new Swiper(".testimonialsSwiper", {
});
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('.testimonialsSwiper').forEach(swiperEl => {
    const config = JSON.parse(swiperEl.getAttribute('data-swiper'));
    new Swiper(swiperEl, config);
  });
});
