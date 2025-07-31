<?php
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$moves = isset($_GET['moves']) ? (int)$_GET['moves'] : 0;
$time  = isset($_GET['time'])  ? (int)$_GET['time']  : 0;

// Record the result
$stmt = $pdo->prepare('INSERT INTO game_stats (user_id, moves, time_taken) VALUES (?, ?, ?)');
$stmt->execute([$_SESSION['user_id'], $moves, $time]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Congratulations!</title>
  <link rel="stylesheet" href="fifteen.css">
</head>
<body>
  <h2>Congratulations, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
  <p>You solved the puzzle in <strong><?= $moves ?></strong> moves and <strong><?= $time ?></strong> seconds.</p>
  <p>
    <a href="puzzle.php">Play Again</a> |
    <a href="leaderboard.php">View Leaderboard</a>
  </p>
</body>
</html>
