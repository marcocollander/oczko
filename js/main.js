import {getCard} from './functions.js';
import {
  btnStartGame,
  btnGiveCardPlayer,
  btnStopCardPlayer,
  btnResetGame,
  playerHand,
  computerHand,
  playerScoreArea,
  computerScoreArea,
} from './init.js';

let scoreComputer = 0;
let scorePlayer = 0;
let counterCardsPlayer = 0;
let counterCardsComputer = 0;
let flag = false;

const startGame = function () {
  scorePlayer = getCard(playerHand, counterCardsPlayer, scorePlayer, playerScoreArea);
  scoreComputer = getCard(computerHand, counterCardsComputer, scoreComputer, computerScoreArea);
}

btnStartGame.addEventListener('click', () => {
  startGame();
  if (!flag) {
    btnStartGame.disabled = true;
    btnResetGame.disabled = false;
    btnGiveCardPlayer.disabled = false;
    btnStopCardPlayer.disabled = false;
  }
})


btnResetGame.addEventListener('click', () => {
  scorePlayer = 0;
  scoreComputer = 0;
  playerScoreArea.innerText = scorePlayer;
  computerScoreArea.innerText = scoreComputer;
  playerHand.innerHTML = '';
  computerHand.innerHTML = '';
  counterCardsPlayer = 0;
  counterCardsComputer = 0;
  flag = false;
  if (!flag) {
    btnStartGame.disabled = false;
    btnResetGame.disabled = true;
    btnGiveCardPlayer.disabled = true;
    btnStopCardPlayer.disabled = true;
  }
})

btnGiveCardPlayer.addEventListener('click', () => {
  counterCardsPlayer++;
  scorePlayer = getCard(playerHand, counterCardsPlayer, scorePlayer, playerScoreArea);
  if (scorePlayer === 21) {
    alert('Oczko, wygrałeś');
  } else if (scorePlayer > 21) {
    alert('Fura przegrałeś');
  }
})

btnStopCardPlayer.addEventListener('click', () => {
  while (scoreComputer <= scorePlayer) {
    counterCardsComputer++;
    scoreComputer = getCard(computerHand, counterCardsComputer, scoreComputer, computerScoreArea);
  }

  if (scoreComputer > 21) {
    alert('Wygrałeś z komputerem')
  } else if (scoreComputer === 21) {
    alert('Oczko wygrał komputer')
  } else if (scorePlayer < scoreComputer) {
    alert('Wygrałeś z komputerem')
  } else {
    alert('Wygrał komputer');
  }
})
