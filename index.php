<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Sign Up</a>
        <a href="read_users.php">Lietotāji</a>
        <a href="upload.php">Faila Agšupielāde</a>
        <a href="read_files.php">Augšupielādētie Faili</a>
    </nav>

    <?php if (isset($_SESSION["message"])): ?>
        <div class="message <?= $_SESSION["message_type"] ?? 'info' ?>">
            <?php if (is_array($_SESSION["message"])): ?>
                <ul>
                    <?php foreach ($_SESSION["message"] as $msg): ?>
                        <li><?= htmlspecialchars($msg) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <?= htmlspecialchars($_SESSION["message"]) ?>
            <?php endif; ?>
            <?php unset($_SESSION["message"], $_SESSION["message_type"]); ?>
        </div>
    <?php endif; ?>

    <div class="center">
        <h1>Sign Up</h1>
        <form method="POST" action="create_user.php" id="signup" onsubmit="return validateForm()">
            <div class="input-group">
                <label>Vārds
                    <input name="first_name" id="first_name" required>
                </label><br><br>

                <label>
                    Uzvārds
                    <input name="last_name" id="last_name" required>
                </label><br><br>
                
                <label>
                    Telefona Nr.
                    <input name="phone" id="phone" required>
                </label><br><br>
                
                <label>
                    E-pasts
                    <input name="email" type="email" id="email" required>
                </label><br><br>
                
                <label>
                    Dzimšanas Diena
                    <input name="birthday" type="date" id="birthday" required>
                </label><br><br>
                
                <label>
                    Parole
                    <input name="password" type="password" id="password" required>
                </label><br><br>
            </div>
            
            <button type="submit">Sign Up</button>
        </form>
    </div>

    <script src="validation.js"></script>
</body>
</html>