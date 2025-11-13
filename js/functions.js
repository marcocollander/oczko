import {deck} from "./deck.js";

let img;
let cardRandom;
let fly = [];

export const getCard = function (hand, counterCards, score, area) {
  cardRandom = Math.floor(Math.random() * 52);
  img = document.createElement('img');
  img.src = deck[cardRandom];
  img.style.width = '60px';

  fly = ['fly1', 'fly2', 'fly3', 'fly4', 'fly5', 'fly6', 'fly7', 'fly8', 'fly9']

  img.classList.add(`${fly[counterCards]}`);
  hand.appendChild(img);

  if (cardRandom % 13 <= 8) {
    score += cardRandom % 13 + 2;
  } else if (cardRandom % 13 > 8 && cardRandom % 13 <= 11) {
    score += (cardRandom % 13) - 8;
  } else if (cardRandom % 13 === 12) {
    score += 11;
  }
  area.innerText = score;
  return score;
}


