<?php
function validateUserData($data, $pdo) {
    $errors = [];

    $first_name = trim($data["first_name"] ?? "");
    $last_name = trim($data["last_name"] ?? "");
    $phone = trim($data["phone"] ?? "");
    $email = trim($data["email"] ?? "");
    $birthday = trim($data["birthday"] ?? "");
    $password = $data["password"] ?? "";

    if (!preg_match("/^[A-Za-zĀ-ž\s]+$/u", $first_name)) {
        $errors[] = "First name should contain only letters.";
    }

    if (!preg_match("/^[A-Za-zĀ-ž\s]+$/u", $last_name)) {
        $errors[] = "Last name should contain only letters.";
    }

    if (!preg_match("/^\d{8}$/", $phone)) {
        $errors[] = "Phone number should contain only digits and needs to be 8 digits long.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if (strtotime($birthday) > time()) {
        $errors[] = "Birthday cannot be in the future.";
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*\-_.]).{15,}$/", $password)) {
        $errors[] = "Password must be at least 15 characters, include uppercase, lowercase, a number, and a special character.";
    }

    // pārbauda vai šāds email jau ir reģistrēts
    $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $checkStmt->bindParam(":email", $email);
    $checkStmt->execute();
    $emailExists = $checkStmt->fetchColumn();

    if ($emailExists) {
        $errors[] = "This email is already registered.";
    }

    return $errors;
}
?>