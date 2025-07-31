<?php
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leaderboard</title>
  <link rel="stylesheet" href="fifteen.css">
</head>
<body>
  <h2>Top 10 Fastest Solves</h2>
  <table>
    <tr><th>Rank</th><th>Player</th><th>Moves</th><th>Time (s)</th><th>Date</th></tr>
    <?php
    $stmt = $pdo->query(
      'SELECT u.username, g.moves, g.time_taken, g.date_played
       FROM game_stats g
       JOIN users u ON g.user_id = u.user_id
       ORDER BY g.time_taken ASC, g.moves ASC
       LIMIT 10'
    );
    $rank = 1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
    ?>
    <tr>
      <td><?= $rank++ ?></td>
      <td><?= htmlspecialchars($row['username']) ?></td>
      <td><?= $row['moves'] ?></td>
      <td><?= $row['time_taken'] ?></td>
      <td><?= $row['date_played'] ?></td>
    </tr>
    <?php endwhile ?>
  </table>
  <p><a href="puzzle.php">Back to Game</a></p>
</body>
</html>
