<?php
// Enable error reporting
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "config.php"; // Assuming config.php handles DB connection

// Handle file download
if (isset($_GET['fileId'])) {
    $fileId = $_GET['fileId'];

    // Get file path from the database
    $stmt = $pdo->prepare("SELECT file_path FROM upload_paths WHERE id = ?");
    $stmt->execute([$fileId]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file && file_exists($file['file_path'])) {
        // Set headers for download
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file['file_path']) . '"');
        readfile($file['file_path']);
        exit();
    } else {
        echo "File not found!";
    }
}
?>