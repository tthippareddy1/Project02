// fifteen.js

"use strict";
let currentBg = "background1.jpg";
window.onload = function() {
  setupPuzzle();
  applyBackground(currentBg);
  
  document.getElementById("shuffleButton").onclick = function() {
    shufflePuzzle();
    resetStats();
  };
  document.getElementById("bg-selector")
    .addEventListener("change", e => {
      currentBg = e.target.value;
      applyBackground(currentBg);
    });
  startTimer();
};

const GRID_SIZE = 4;
const TILE_SIZE = 100;      // including 2px borders
let blankRow = 3, blankCol = 3;
let moveCount = 0;
let timerInterval, startTime;

/** Create and place 15 tiles in solved order */
function setupPuzzle() {
  const area = document.getElementById("puzzlearea");
  area.innerHTML = "";
  let num = 1;
  for (let r = 0; r < GRID_SIZE; r++) {
    for (let c = 0; c < GRID_SIZE; c++) {
      if (r === GRID_SIZE - 1 && c === GRID_SIZE - 1) break;
      const tile = document.createElement("div");
      tile.className = "puzzlepiece";
      tile.textContent = num;
      tile.style.top  = (r * TILE_SIZE) + "px";
      tile.style.left = (c * TILE_SIZE) + "px";
      tile.style.backgroundPosition = (-c * TILE_SIZE) + "px " + (-r * TILE_SIZE) + "px";
      tile.dataset.row = r;
      tile.dataset.col = c;

      tile.addEventListener("click", onTileClick);
      tile.addEventListener("mouseover", onTileHover);
      tile.addEventListener("mouseout",  onTileHoverOut);

      area.appendChild(tile);
      num++;
    }
  }
  applyBackground(currentBg);
}

/** Can this tile move into the blank? */
function canMove(tile) {
  const r = +tile.dataset.row, c = +tile.dataset.col;
  return (r === blankRow && Math.abs(c - blankCol) === 1) ||
         (c === blankCol && Math.abs(r - blankRow) === 1);
}

/** Slide the tile into the blank */
function moveTile(tile) {
  const r = +tile.dataset.row, c = +tile.dataset.col;
  tile.style.top  = (blankRow * TILE_SIZE) + "px";
  tile.style.left = (blankCol * TILE_SIZE) + "px";
  tile.dataset.row = blankRow;
  tile.dataset.col = blankCol;
  blankRow = r;
  blankCol = c;
}

/** Click handler */
function onTileClick(e) {
  const tile = e.currentTarget;
  if (canMove(tile)) {
    moveTile(tile);
    incrementMove();
    if (isSolved()) finishGame();
  }
}

/** Hover handlers */
function onTileHover(e) {
  if (canMove(e.currentTarget)) {
    e.currentTarget.classList.add("movablepiece");
  }
}
function onTileHoverOut(e) {
  e.currentTarget.classList.remove("movablepiece");
}

/** Shuffle by doing 100 random legal moves */
function shufflePuzzle() {
  let last = null;
  for (let i = 0; i < 100; i++) {
    const nbrs = [];
    if (blankRow > 0)              nbrs.push(tileAt(blankRow-1, blankCol));
    if (blankRow < GRID_SIZE - 1)  nbrs.push(tileAt(blankRow+1, blankCol));
    if (blankCol > 0)              nbrs.push(tileAt(blankRow, blankCol-1));
    if (blankCol < GRID_SIZE - 1)  nbrs.push(tileAt(blankRow, blankCol+1));
    const opts = nbrs.filter(t => t && t !== last);
    const choice = opts[Math.floor(Math.random() * opts.length)];
    moveTile(choice);
    last = choice;
  }
}

/** Utility: find tile by data-row/col */
function tileAt(r, c) {
  return document.querySelector(`.puzzlepiece[data-row='${r}'][data-col='${c}']`);
}

function applyBackground(url) {
    document.querySelectorAll(".puzzlepiece").forEach(tile => {
      tile.style.backgroundImage = `url('${url}')`;
    });
  }

/** Stats: moves & timer */
function resetStats() {
  moveCount = 0;
  document.getElementById("moveCount").textContent = moveCount;
  clearInterval(timerInterval);
  startTimer();
}
function incrementMove() {
  moveCount++;
  document.getElementById("moveCount").textContent = moveCount;
}
function startTimer() {
  startTime = Date.now();
  timerInterval = setInterval(() => {
    const secs = Math.floor((Date.now() - startTime) / 1000);
    document.getElementById("timer").textContent = secs;
  }, 1000);
}

/** Check if solved (tiles in numeric order) */
function isSolved() {
  let count = 1;
  for (let r = 0; r < GRID_SIZE; r++) {
    for (let c = 0; c < GRID_SIZE; c++) {
      if (r === GRID_SIZE - 1 && c === GRID_SIZE - 1) continue;
      const tile = tileAt(r, c);
      if (!tile || +tile.textContent !== count) return false;
      count++;
    }
  }
  return true;
}

/** On win: stop timer & redirect to success page */
function finishGame() {
  clearInterval(timerInterval);
  const totalTime = Math.floor((Date.now() - startTime) / 1000);
  window.location.href = `success.php?moves=${moveCount}&time=${totalTime}`;
}

