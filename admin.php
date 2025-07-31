<?php
require 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: puzzle.php');
    exit;
}

// Handle leaderboard reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_scores'])) {
    $pdo->exec('TRUNCATE TABLE game_stats');
    $message = 'Leaderboard has been reset.';
}

// Handle user deletion
if (isset($_GET['delete_user'])) {
    $delId = (int)$_GET['delete_user'];
    $pdo->prepare('DELETE FROM users WHERE user_id = ?')->execute([$delId]);
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="fifteen.css">
</head>
<body>
  <h2>Admin Dashboard</h2>

  <?php if (!empty($message)): ?>
    <p class="notice"><?= htmlspecialchars($message) ?></p>
  <?php endif ?>

  <h3>Manage Users</h3>
  <table>
    <tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>
    <?php
    $stmt = $pdo->query('SELECT user_id, username, role FROM users');
    while ($u = $stmt->fetch(PDO::FETCH_ASSOC)):
    ?>
    <tr>
      <td><?= $u['user_id'] ?></td>
      <td><?= htmlspecialchars($u['username']) ?></td>
      <td><?= $u['role'] ?></td>
      <td>
        <?php if ($u['role'] !== 'admin'): ?>
          <a href="?delete_user=<?= $u['user_id'] ?>"
             onclick="return confirm('Delete this user?');">Delete</a>
        <?php endif ?>
      </td>
    </tr>
    <?php endwhile ?>
  </table>

  <h3>Manage Leaderboard</h3>
  <form method="post">
    <button name="reset_scores" onclick="return confirm('Reset all scores?');">
      Reset Leaderboard
    </button>
  </form>

  <p><a href="puzzle.php">Back to Game</a></p>
</body>
</html>
