<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"] ?? "";
    $last_name = $_POST["last_name"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $email = $_POST["email"] ?? "";
    $birthday = $_POST["birthday"] ?? "";
    $password = $_POST["password"] ?? "";

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    if (!empty($first_name) && !empty($last_name) && !empty($phone) && !empty($email) && !empty($birthday) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, phone, email, birthday, password) VALUES (:first_name, :last_name, :phone, :email, :birthday, :password)");
            $stmt->bindParam(":first_name", $first_name);
            $stmt->bindParam(":last_name", $last_name);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":birthday", $birthday);
            $stmt->bindParam(":password", $hash_password);

            $stmt->execute();

            echo json_encode(["success" => true, "message" => "User created successfully", "redirect" => "read_users.php"]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
    }
}
?>
