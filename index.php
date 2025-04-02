<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="validator.js"></script>
</head>
<body>
    <nav>
        <a href="index.php">Sign Up</a>
        <a href="read_users.php">Users</a>
        <a href="upload.php">Faila Agšupielāde</a>
    </nav>

    <h1>Sign Up</h1>
    <form method="POST" action="create_user.php" id="signup">
        <label>
            Vārds<br>
            <input name="first_name" id="first_name" required>
        </label><br><br>

        <label>
            Uzvārds<br>
            <input name="last_name" id="last_name" required>
        </label><br><br>

        <label>
            Telefona Nr.<br>
            <input name="phone" id="phone" required>
        </label><br><br>

        <label>
            E-pasts<br>
            <input name="email" type="email" id="email" required>
        </label><br><br>

        <label>
            Dzimšanas Diena<br>
            <input name="birthday" type="date" id="date" required>
        </label><br><br>

        <label>
            Parole<br>
            <input name="password" type="password" id="passowrd" required>
        </label><br><br>

        <button type="submit">Sign Up</button>
    </form>
</body>
</html>