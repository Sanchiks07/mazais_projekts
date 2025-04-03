<?php
require "config.php";

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['first_name']) && isset($data['last_name']) && isset($data['phone']) && isset($data['email']) && isset($data['birthday'])) {
    $id = $data['id'];
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $phone = $data['phone'];
    $email = $data['email'];
    $birthday = $data['birthday'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, phone = :phone, email = :email, birthday = :birthday WHERE id = :id");
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":birthday", $birthday);
        $stmt->bindParam(":id", $id);

        $stmt->execute();

        echo json_encode(["success" => true, "message" => "User updated successfully"]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid input"]);
}
?>