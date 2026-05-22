<?php
include "db.php";

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($name == "" || $email == "" || $password == "") {
    echo "error";
    exit;
}

$sql = "INSERT INTO users (name, email, password)
        VALUES ('$name', '$email', '$password')";

if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "error";
}
?>
