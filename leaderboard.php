<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get leaderboard data
$stmt = $pdo->query("
    SELECT l.*, u.name 
    FROM leaderboard l 
    JOIN users u ON l.user_id = u.id 
    ORDER BY l.submission_time ASC 
    LIMIT 100
");
$leaderboard = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - Depunere cerere</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <div class="navbar-left">
                <div class="navbar-links">
                    <a href="leaderboard.php"><span>🏅</span>Leadertboard</a>
                    <a href="DosarDemo.rar"><span>📁</span>Dosar demo</a>
                    <a href="index.php"><span>🔄</span>Reincercare</a>
                </div>
            </div>
            <div class="navbar-user">
                <div class="navbar-user-icon">👤</div>
                <div class="navbar-user-info">
                    <span>Bună dimineața,<br><strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></span>
                </div>
                <a href="index.php?logout=1" class="btn btn-outline-danger">Deconectare</a>
            </div>
        </nav>
        <h1>Leaderboard</h1>
        <section class="form-section">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nume</th>
                            <th>Timp</th>
                            <th>Data depunerii</th>
                            <th>Valid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leaderboard as $index => $entry): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($entry['name']); ?></td>
                                <td><?php 
                                    $minutes = floor($entry['submission_time'] / 60);
                                    $seconds = $entry['submission_time'] % 60;
                                    echo sprintf("%02d:%02d", $minutes, $seconds);
                                ?></td>
                                <td><?php echo date('d.m.Y H:i:s', strtotime($entry['submission_date'])); ?></td>
                                <td>
                                    <?php if ($entry['validated']): ?>
                                        <span class="badge bg-success">Dosar a fost validat</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Inca nu a fost validat</span>
                                    <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 