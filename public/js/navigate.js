const btnHamburger = document.querySelector('.hamburger');
const [hamburgerLine1, hamburgerLine2, hamburgerLine3] = document.querySelectorAll('.hamburger__line');
const menu = document.querySelector('.menu');

btnHamburger.addEventListener('click', () => {
  menu.classList.toggle('active');
  menu.classList.toggle('inactive');
  hamburgerLine1.classList.toggle('rotate');
  hamburgerLine2.classList.toggle('hidden');
  hamburgerLine3.classList.toggle('reverse-rotate');
})
