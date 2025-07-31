<?php
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fifteen Puzzle</title>
  <link rel="stylesheet" href="fifteen.css">
</head>
<body>
  <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>

  <div id="puzzlearea"></div>
  <button id="shuffleButton">Shuffle</button>

  <div id="stats">
    Moves: <span id="moveCount">0</span> |
    Time: <span id="timer">0</span>s
  </div>

  <p>
    <a href="leaderboard.php">Leaderboard</a>
    <?php if ($_SESSION['role'] === 'admin'): ?>
      | <a href="admin.php">Admin Dashboard</a>
    <?php endif ?>
    | <a href="logout.php">Logout</a>
  </p>

  <script src="fifteen.js"></script>
</body>
</html>
