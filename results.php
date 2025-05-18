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
    LIMIT 10
");
$leaderboard = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depunere cerere nouă</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <span>Bună dimineața,<br><strong>User</strong></span>
                    <a href='#'><small>TIMPI DUMNEAVOASTRĂ</small></a>
                </div>
                <button>Deconectare</button>
            </div>
        </nav>
        <h1>Timpul tau: <span id="timer">--</span></h1>
        <section class="form-section">
            <div class="d-flex  justify-content-center">
                <h2 class="my-5">🏆Top 10 timpuri vailate🏆</h2>
            </div>
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
    <script>
        const timer = document.getElementById('timer');
        var sTime = localStorage.getItem('timer-start');
        sTime = parseInt(sTime, 10);
        eTime = localStorage.getItem('timer-end');
        eTime = parseInt(eTime, 10);
        function updateTimer() {
            if (sTime !== null) {
                const elapsedTime = Math.floor((eTime - sTime) / 1000);
                const minutes = Math.floor(elapsedTime / 60);
                const seconds = elapsedTime % 60;
                if(minutes < 1){
                    if(seconds < 10){
                        timer.textContent = `00:0${seconds}`;
                    } else {
                        timer.textContent = `00:${seconds}`;
                    }
                }
                else if(minutes < 10){
                    if(seconds < 10){
                        timer.textContent = `0${minutes}:0${seconds}`;
                    } else {
                        timer.textContent = `0${minutes}:${seconds}`;
                    }
                } else {
                    if(seconds < 10){
                        timer.textContent = `${minutes}:0${seconds}`;
                    } else {
                        timer.textContent = `${minutes}:${seconds}`
                    }
                }
            }
        }
        $(document).ready(function() {
            updateTimer();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
