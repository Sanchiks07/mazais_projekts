<?php
// Enable error reporting
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "config.php"; // Assuming config.php handles DB connection

// Handle file delete
if (isset($_GET['fileId'])) {
    $fileId = $_GET['fileId'];

    // Get file path from the database
    $stmt = $pdo->prepare("SELECT file_path FROM upload_paths WHERE id = ?");
    $stmt->execute([$fileId]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file && file_exists($file['file_path'])) {
        // Delete the file from the server
        unlink($file['file_path']);

        // Delete file entry from the database
        $stmt = $pdo->prepare("DELETE FROM upload_paths WHERE id = ?");
        $stmt->execute([$fileId]);

        header("Location: view_files.php?successMessage=File deleted successfully!");
        exit();
    } else {
        echo "File not found or already deleted!";
    }
}
?>