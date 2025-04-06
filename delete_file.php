<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "config.php";

if (isset($_GET['fileId'])) {
    $fileId = $_GET['fileId'];

    $stmt = $pdo->prepare("SELECT file_path FROM upload_paths WHERE id = ?");
    $stmt->execute([$fileId]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        $filePath = $file['file_path'];

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $stmt = $pdo->prepare("DELETE FROM upload_paths WHERE id = ?");
        $stmt->execute([$fileId]);

        header("Location: read_files.php?successMessage=File deleted successfully!");
        exit();
    } else {
        echo "File record not found!";
    }
}
?>