export const deck = [
  'assets/deck/hearts/two-hearts.png',
  'assets/deck/hearts/three-hearts.png',
  'assets/deck/hearts/four-hearts.png',
  'assets/deck/hearts/five-hearts.png',
  'assets/deck/hearts/six-hearts.png',
  'assets/deck/hearts/seven-hearts.png',
  'assets/deck/hearts/eight-hearts.png',
  'assets/deck/hearts/nine-hearts.png',
  'assets/deck/hearts/ten-hearts.png',
  'assets/deck/hearts/jack-hearts.png',
  'assets/deck/hearts/queen-hearts.png',
  'assets/deck/hearts/king-hearts.png',
  'assets/deck/hearts/ace-hearts.png',

  'assets/deck/spades/two-spades.png',
  'assets/deck/spades/three-spades.png',
  'assets/deck/spades/four-spades.png',
  'assets/deck/spades/five-spades.png',
  'assets/deck/spades/six-spades.png',
  'assets/deck/spades/seven-spades.png',
  'assets/deck/spades/eight-spades.png',
  'assets/deck/spades/nine-spades.png',
  'assets/deck/spades/ten-spades.png',
  'assets/deck/spades/jack-spades.png',
  'assets/deck/spades/queen-spades.png',
  'assets/deck/spades/king-spades.png',
  'assets/deck/spades/ace-spades.png',

  'assets/deck/diamonds/two-diamonds.png',
  'assets/deck/diamonds/three-diamonds.png',
  'assets/deck/diamonds/four-diamonds.png',
  'assets/deck/diamonds/five-diamonds.png',
  'assets/deck/diamonds/six-diamonds.png',
  'assets/deck/diamonds/seven-diamonds.png',
  'assets/deck/diamonds/eight-diamonds.png',
  'assets/deck/diamonds/nine-diamonds.png',
  'assets/deck/diamonds/ten-diamonds.png',
  'assets/deck/diamonds/jack-diamonds.png',
  'assets/deck/diamonds/queen-diamonds.png',
  'assets/deck/diamonds/king-diamonds.png',
  'assets/deck/diamonds/ace-diamonds.png',

  'assets/deck/clubs/two-clubs.png',
  'assets/deck/clubs/three-clubs.png',
  'assets/deck/clubs/four-clubs.png',
  'assets/deck/clubs/five-clubs.png',
  'assets/deck/clubs/six-clubs.png',
  'assets/deck/clubs/seven-clubs.png',
  'assets/deck/clubs/eight-clubs.png',
  'assets/deck/clubs/nine-clubs.png',
  'assets/deck/clubs/ten-clubs.png',
  'assets/deck/clubs/jack-clubs.png',
  'assets/deck/clubs/queen-clubs.png',
  'assets/deck/clubs/king-clubs.png',
  'assets/deck/clubs/ace-clubs.png',
]

export function buildShuffledDeck() {
  // Tworzymy kopię istniejącej listy kart (ścieżek) i tasujemy Fisher-Yates
  const d = [...deck];
  for (let i = d.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [d[i], d[j]] = [d[j], d[i]];
  }
  return d;
}
