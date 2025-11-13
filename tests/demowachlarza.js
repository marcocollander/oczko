const cards = [
    '../assets/deck/hearts/two-hearts.png',
    '../assets/deck/hearts/three-hearts.png',
    '../assets/deck/hearts/four-hearts.png',
    '../assets/deck/hearts/five-hearts.png',
    '../assets/deck/hearts/six-hearts.png',
    '../assets/deck/hearts/seven-hearts.png',
    '../assets/deck/hearts/eight-hearts.png',
    '../assets/deck/hearts/nine-hearts.png',
    '../assets/deck/hearts/ten-hearts.png',
    '../assets/deck/hearts/jack-hearts.png',
    '../assets/deck/hearts/queen-hearts.png',
    '../assets/deck/hearts/king-hearts.png',
    '../assets/deck/hearts/ace-hearts.png',
]


const hand = document.querySelector('.hand');
const btnGiveCard = document.querySelector('.btnGiveCard');
let counterCards = -1;
let shiftX = [];
let shiftY = [];
let angle = [];

btnGiveCard.addEventListener('click', () => {
    counterCards++;
    if (counterCards < 8) {

        angle = [320, 330, 340, 350, 360, 10, 20, 30];
        shiftX = [0, 80, 160, 240, 320, 400, 480, 560]
        shiftY = [20, 20, 20, 20, 20, 20, 20, 20]
        const cardRandom = Math.floor(Math.random() * 13);
        const img = document.createElement('img');
        img.src = cards[cardRandom];
        img.style.width = '100px';
        img.style.transform =
            `
            translateX(${-shiftX[counterCards]}px) 
            translateY(${shiftY[counterCards]}px) 
            rotate(${angle[counterCards]}deg)
            `
        hand.appendChild(img);

    } else {

        hand.innerText = 'Game is over'
    }
})