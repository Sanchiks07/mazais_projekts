<?php
require "config.php";

try {
    $sql = "SELECT id, first_name, last_name, phone, email, birthday FROM users";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Sign Up</a>
        <a href="read_users.php">Lietotāji</a>
        <a href="upload.php">Faila Agšupielāde</a>
    </nav>

    <div class="center">
        <h1>Visi Lietotāji</h1>
        <table>
            <tr>
                <th>Id</th>
                <th>Vārds</th>
                <th>Uzvārds</th>
                <th>Telefona Nr.</th>
                <th>E-pasts</th>
                <th>Dzimšanas Diena</th>
                <th>-</th>
            </tr>

            <?php
            if (count($users) > 0) {
                foreach ($users as $row) {
                    echo "<tr data-id='{$row['id']}'>
                            <td>{$row['id']}</td>
                            <td>{$row['first_name']}</td>
                            <td>{$row['last_name']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['birthday']}</td>
                            <td>
                                <button class='edit' onclick='editUser(this)'>Rediģēt</button>
                                <button class='delete' onclick='deleteUser(this)'>Dzēst</button>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Nav datu</td></tr>";
            }
            ?>
        </table>
    </div>

    <script src="actions.js"></script>
</body>
</html>