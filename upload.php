<?php
// Enable error reporting
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "config.php"; // Assuming config.php handles DB connection

$successMessage = '';
$errorMessage = '';

// Handle file upload
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $fileTempName = $file['tmp_name'];
    $fileError = $file['error'];

    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
    }

    // Check if there was no error with the file upload
    if ($fileError === 0) {
        $filePath = $uploadDir . $fileName;
        if (move_uploaded_file($fileTempName, $filePath)) {
            $successMessage = "✅ File uploaded successfully!";
            
            // Save file path in the database (optional)
            $stmt = $pdo->prepare("INSERT INTO upload_paths (file_name, file_path) VALUES (?, ?)");
            $stmt->execute([$fileName, $filePath]);
        } else {
            $errorMessage = "Failed to upload file!";
        }
    } else {
        $errorMessage = "There was an error uploading the file!";
    }
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faila Augšupielāde</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Sign Up</a>
        <a href="read_users.php">Lietotāji</a>
        <a href="upload.php">Faila Agšupielāde</a>
    </nav>

    <div class="center">
        <h1>Faila Augšupielāde</h1>

        <?php if ($successMessage) echo "<p class='success'>$successMessage</p>"; ?>
        <?php if ($errorMessage) echo "<p class='error'>$errorMessage</p>"; ?>

        <!-- File Upload Form -->
        <form method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <label>
                    Izvēlēties Failu
                    <input name="file" id="file" type="file" required />
                </label><br><br>
            </div>

            <button type="submit">Upload</button>
        </form>

        <a href="read_files.php">
            <button>View Uploaded Files</button>
        </a>
    </div>
</body>
</html>