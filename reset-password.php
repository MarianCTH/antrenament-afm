<?php
session_start();
require_once 'config/database.php';

$token = $_GET['token'] ?? '';
$error = null;
$success = null;

if (empty($token)) {
    echo '<meta http-equiv="refresh" content="0;url=login.php">';
    echo '<script>window.location.href = "login.php";</script>';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($password)) {
        $error = "Password is required";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Verify token and check expiration
        $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Update password and clear reset token
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
            if ($stmt->execute([$hashed_password, $user['id']])) {
                $success = "Password has been reset successfully. You can now login with your new password.";
            } else {
                $error = "Failed to reset password. Please try again.";
            }
        } else {
            $error = "Invalid or expired reset token";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetare parolă - Program Rabla pentru Tractoare</title>
    <meta name="description" content="Resetează parola contului pentru Programul Rabla pentru Tractoare și mașini agricole autopropulsate.">
    <meta name="keywords" content="resetare parolă rabla tractoare, recuperare cont program rabla">
    <meta name="author" content="AFM">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Resetare parolă - Program Rabla pentru Tractoare">
    <meta property="og:description" content="Resetează parola contului pentru Programul Rabla pentru Tractoare.">
    <meta property="og:type" content="website">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="auth-container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Reset Password</h2>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                <?php echo $success; ?>
                                <div class="mt-3">
                                    <a href="login.php" class="btn btn-primary">Go to Login</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Reset Password</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 