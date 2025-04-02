<?php
require "config.php"; 

$sql = "SELECT id, first_name, last_name, phone, email, birthday FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>
    <table>
        <tr>
            <th>Vārds</th>
            <th>Uzvārds</th>
            <th>Telefona Nr.</th>
            <th>E-pasts</th>
            <th>Dzimšanas Diena</th>
            <th>-</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['first_name']}</td>
                        <td>{$row['last_name']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['birthday']}</td>
                        <td>
                            <button class='edit' onclick='editUser({$row['id']})'>Rediģēt</button>
                            <button class='delete' onclick='deleteUser({$row['id']})'>Dzēst</button>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nav datu</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>