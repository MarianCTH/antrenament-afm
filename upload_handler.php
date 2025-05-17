<?php
    session_start();

    header('Content-Type: application/json');

   if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Fișierul nu a fost trimis corect']);
        exit();
    }

    // Save to tmp/ folder
    $tmpDir = 'tmp/';
    if (!is_dir($tmpDir)) {
        mkdir($tmpDir, 0755, true);
    }

    $originalName = basename($_FILES['file']['name']);
    $uniqueName = time() . '-' . uniqid() . '-' . $originalName;
    $targetPath = $tmpDir . $uniqueName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
        $_SESSION['uploaded_pdf'] = $targetPath;
        echo json_encode(['status' => 'success', 'file' => $targetPath]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Salvarea fișierului a eșuat']);
    }
?>