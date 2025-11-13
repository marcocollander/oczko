const btnHamburger = document.querySelector('.hamburger');
const [hamburgerLine1, hamburgerLine2, hamburgerLine3] = document.querySelectorAll('.hamburger-line');
const menu = document.querySelector('.menu');

btnHamburger.addEventListener('click', () => {
  menu.classList.toggle('active');
})
