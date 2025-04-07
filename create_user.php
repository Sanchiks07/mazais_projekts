<?php
require "config.php";
require "validation.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validateUserData($_POST, $pdo);

    if (!empty($errors)) {
        $_SESSION["message"] = $errors;
        $_SESSION["message_type"] = "error";
        header("Location: index.php");
        exit();
    }

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $birthday = $_POST["birthday"];
    $password = $_POST["password"];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, phone, email, birthday, password) 
                               VALUES (:first_name, :last_name, :phone, :email, :birthday, :password)");
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":birthday", $birthday);
        $stmt->bindParam(":password", $hash_password);
        $stmt->execute();

        $_SESSION["message"] = "User created successfully!";
        $_SESSION["message_type"] = "success";
    } catch (PDOException $e) {
        $_SESSION["message"] = ["Database error: " . $e->getMessage()];
        $_SESSION["message_type"] = "error";
    }

    header("Location: index.php");
    exit();
}