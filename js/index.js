import {deck, buildShuffledDeck } from './deck.js';
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
  phase: 'idle', // idle | running | player_stand | computer_turn | result
  deck: [],
  player: { hand: [], score: 0 },
  computer: { hand: [], score: 0 },
}

function cardValueByIndex(cardIndex) {
  // index w [0..51], wartość 2..10,J/Q/K=10, A=1/11
  const rank = cardIndex % 13; // 0..12 (2..A)
  if (rank <= 8) return rank + 2; // 2..10
  if (rank <= 11) return 10; // J,Q,K
  return 11; // A jako 11 domyślnie, korekta później
}

function scoreHand(indices) {
  // liczymy sumę, Asy jako 11 i zmniejszamy do 1 gdy trzeba
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

function drawOne() {
  if (state.deck.length === 0) throw new Error('Pusta talia');
  // element deck to string ścieżki, potrzebujemy indeksu oryginalnej karty:
  // jeśli oryginalny deck jest tablicą ścieżek, bierzemy indeks względem bazowej tablicy "deck"
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

function updateScoresUI() {
  playerScoreArea.innerText = state.player.score;
  computerScoreArea.innerText = state.computer.score;
}

function setButtonsByPhase() {
  const p = state.phase;
  btnStartGame.disabled = !(p === 'idle');
  btnResetGame.disabled = (p === 'idle');
  btnGiveCardPlayer.disabled = !(p === 'running');
  btnStopCardPlayer.disabled = !(p === 'running');
}

const gameEngine = {
  start() {
    state = {
      phase: 'running',
      deck: buildShuffledDeck(),
      player: { hand: [], score: 0 },
      computer: { hand: [], score: 0 },
    };
    // po jednej karcie na start
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

  playerStand() {
    if (state.phase !== 'running') return;
    state.phase = 'computer_turn';
    setButtonsByPhase();
    this.computerTurn();
  },

  computerTurn() {
    // prosty algorytm: dobiera do przebicia gracza i min. 17
    while (state.computer.score < 17 || state.computer.score < state.player.score) {
      const prev = state.computer.score;
      this.drawFor('computer');
      if (state.computer.score === prev) break; // safeguard
      if (state.computer.score > 21) break;
    }
    state.phase = 'result';
    setButtonsByPhase();
    this.resolve();
  },

  resolve() {
    const ps = state.player.score;
    const cs = state.computer.score;
    if (ps > 21) {
      alert('Wygrał komputer (gracz > 21)');
    } else if (cs > 21) {
      alert('Wygrałeś (komputer > 21)');
    } else if (ps === 21 && cs !== 21) {
      alert('Oczko! Wygrałeś');
    } else if (cs === 21 && ps !== 21) {
      alert('Oczko komputera — przegrana');
    } else if (ps > cs) {
      alert('Wygrałeś z komputerem');
    } else if (ps < cs) {
      alert('Wygrał komputer');
    } else {
      alert('Remis');
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
};

// Inicjalizacja UI
gameEngine.reset();

// Handlers
btnStartGame.addEventListener('click', () => {
  gameEngine.start();
});

btnGiveCardPlayer.addEventListener('click', () => {
  if (state.phase !== 'running') return;
  gameEngine.drawFor('player');
});

btnStopCardPlayer.addEventListener('click', () => {
  gameEngine.playerStand();
});

btnResetGame.addEventListener('click', () => {
  gameEngine.reset();
});

