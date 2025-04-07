<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once "config.php";

$alertMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $fileTempName = $file['tmp_name'];
    $fileError = $file['error'];
    $fileSize = $file['size'];

    // atļautie faila extensions
    $allowedFileTypes = [
        'image/jpeg', 'image/png', 'image/gif',
        'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint',
        'application/pdf',
        'audio/mp3',
        'video/mp4',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // doxc
    ];

    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // atļautie MIME tipi priekš validation
    $allowedMimeTypes = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'application/msword' => 'doc',
        'application/vnd.ms-excel' => 'xls',
        'application/vnd.ms-powerpoint' => 'ppt',
        'application/pdf' => 'pdf',
        'audio/mp3' => 'mp3',
        'video/mp4' => 'mp4',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx' // docx
    ];

    $uploadDir = "uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if ($fileError === 0) {
        // pārbauda fila extension
        $fileMimeType = mime_content_type($fileTempName);
        if (!in_array($fileMimeType, $allowedFileTypes)) {
            session_start();
            $_SESSION['alertMessage'] = "❌ Invalid file type! Only image files, Microsoft documents, PDFs, MP3, and MP4 files are allowed.";
            header("Location: upload.php");
            exit();
        }

        $filePath = $uploadDir . $fileName;
        if (move_uploaded_file($fileTempName, $filePath)) {
            $stmt = $pdo->prepare("INSERT INTO upload_paths (file_name, file_path) VALUES (?, ?)");
            $stmt->execute([$fileName, $filePath]);

            session_start();
            $_SESSION['alertMessage'] = "✅ File uploaded successfully!";
            header("Location: upload.php");
            exit();
        } else {
            session_start();
            $_SESSION['alertMessage'] = "❌ Failed to upload file!";
            header("Location: upload.php");
            exit();
        }
    } else {
        session_start();
        $_SESSION['alertMessage'] = "⚠️ There was an error uploading the file!";
        header("Location: upload.php");
        exit();
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
        <a href="read_files.php">Augšupielādētie Faili</a>
    </nav>

    <div class="center">
        <h1>Faila Augšupielāde</h1>

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
    </div>

    <?php
    session_start();
    if (isset($_SESSION['alertMessage'])) {
        echo "<script>alert('" . $_SESSION['alertMessage'] . "');</script>";
        unset($_SESSION['alertMessage']);
    }
    ?>
</body>
</html>