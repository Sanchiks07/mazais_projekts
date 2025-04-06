<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "config.php";

$stmt = $pdo->query("SELECT * FROM upload_paths");

?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Uploaded Files</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Sign Up</a>
        <a href="read_users.php">Lietotāji</a>
        <a href="upload.php">Faila Agšupielāde</a>
        <a href="read_files.php">Augšupielādētie Faili</a>
    </nav>

    <div class="center">
        <h1>Augšupielādētie Faili</h1>

        <div class="file-cards">
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $filePath = htmlspecialchars($row['file_path']);
                $fileName = htmlspecialchars($row['file_name']);
                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                // Check if it's an image
                $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
            
                echo "
                <div class='file-card'>
                    <div class='file-preview'>";
                
                if ($isImage) {
                    echo "<img src='" . $filePath . "' alt='" . $fileName . "' />";
                } else {
                    echo "<div class='file-icon'>📄</div>";
                }
            
                echo "</div>
                    <h3>$fileName</h3>
                    <div class='file-actions'>
                        <a href='download_file.php?fileId=" . $row['id'] . "' class='download'>Lejupielādēt</a>
                        <a href='delete_file.php?fileId=" . $row['id'] . "' class='delete-file' onclick='return confirm(\"Are you sure you want to delete this file?\");'>Dzēst</a>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>