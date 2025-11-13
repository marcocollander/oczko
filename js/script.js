import {buildShuffledDeck, deck} from './deck.js';
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

let state = {
  phase: 'idle',
  deck: [],
  player: { hand: [], score: 0 },
  computer: { hand: [], score: 0 },
}

function setButtonsByPhase() {
  const phase = state.phase;
  btnStartGame.disabled = !(phase === 'idle');
  btnResetGame.disabled = (phase === 'idle');
  btnGiveCardPlayer.disabled = !(phase === 'running');
  btnStopCardPlayer.disabled = !(phase === 'running');
}

function updateScoresUI() {
  playerScoreArea.innerText = state.player.score;
  computerScoreArea.innerText = state.computer.score;
}

function drawOne() {
  if (state.deck.length === 0) throw new Error('Pusta talia');
  const cardPath = state.deck.pop();
  const idx = deck.indexOf(cardPath);
  return { idx, src: cardPath };

}

function renderHand(who, container) {
  container.innerHTML = '';
  const hand = state[who].hand;
  hand.forEach((c, i) => {
    const img = document.createElement('img');
    img.src = c.src;
    img.style.width = '60px';
    img.classList.add(`fly${(i % 9) + 1}`);
    container.appendChild(img);
  });
}

function cardValueByIndex(cardIndex) {
  // index w [0..51], wartość 2..10,J/Q/K=10, A=1/11
  const rank = cardIndex % 13; // 0..12 (2..A)
  if (rank <= 8) return rank + 2; // 2..10
  if (rank <= 11) return 10; // J,Q,K
  return 11; // A jako 11 domyślnie, korekta później
}

function scoreHand(indices) {
  let total = 0;
  let aces = 0;
  for (const idx of indices) {
    const v = cardValueByIndex(idx);
    total += v;
    if (v === 11) aces++;
  }
  while (total > 21 && aces > 0) {
    total -= 10; // zamieniamy jeden As 11 -> 1
    aces--;
  }
  return total;
}

const gameEngine = {
  start() {
    state = {
      phase: 'running',
      deck: buildShuffledDeck(),
      player: { hand: [], score: 0 },
    };
    this.drawFor('player');
    this.drawFor('computer');
    setButtonsByPhase();
  },

  drawFor(who) {
    const card = drawOne();
    state[who].hand.push(card);
    state[who].score = scoreHand(state[who].hand.map(c => c.idx));
    if (who === 'player') {
      renderHand('player', playerHand);
    } else {
      renderHand('computer', computerHand);
    }
    updateScoresUI();

    // automatyczne sprawdzenie stanu gracza
    if (who === 'player') {
      if (state.player.score === 21) {
        state.phase = 'computer_turn';
        setButtonsByPhase();
        this.computerTurn();
      } else if (state.player.score > 21) {
        state.phase = 'result';
        setButtonsByPhase();
        alert('Fura — przegrałeś');
      }
    }
  },

  reset() {
    state = {
      phase: 'idle',
      deck: [],
      player: { hand: [], score: 0 },
      computer: { hand: [], score: 0 },
    };
    playerHand.innerHTML = '';
    computerHand.innerHTML = '';
    updateScoresUI();
    setButtonsByPhase();
  },
}

gameEngine.reset();

btnStartGame.addEventListener('click', () => {
  gameEngine.start();
});
