<?php
// Enable error reporting
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "config.php"; // Assuming config.php handles DB connection

// Fetch all uploaded files from the database
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
    </nav>

    <div class="center">
        <h1>Uploaded Files</h1>

        <div class="file-cards">
            <?php
            // Loop through and display files as cards
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "
                <div class='file-card'>
                    <h3>" . htmlspecialchars($row['file_name']) . "</h3>
                    <div class='file-actions'>
                        <a href='download_file.php?fileId=" . $row['id'] . "' class='button download-btn'>Download</a>
                        <a href='delete_file.php?fileId=" . $row['id'] . "' class='button delete-btn' onclick='return confirm(\"Are you sure you want to delete this file?\");'>Delete</a>
                    </div>
                </div>
                ";
            }
            ?>
        </div>
    </div>
</body>
</html>
