<?php
session_start();
include "db.php";

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['email'] = $email;

            echo json_encode([
                "status" => "success",
                "message" => "Login successful"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid email or password"
            ]);
        }

        $stmt->close();

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Email & password required"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request"
    ]);
}
?>
