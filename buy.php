<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $product_name = $_POST['product_name'] ?? '';
    $quantity     = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $price        = isset($_POST['price']) ? floatval($_POST['price']) : 0;

    $full_name = trim(($_POST['first_name'] ?? '') . ' ' . ($_POST['last_name'] ?? ''));
    $phone     = $_POST['phone'] ?? '';
    $address   = $_POST['address'] ?? '';

    if ($product_name && $quantity > 0 && $price > 0 && $full_name && $phone && $address) {

        $stmt = $conn->prepare("INSERT INTO orders (product_name, quantity, price) VALUES (?, ?, ?)");
        $stmt->bind_param("sid", $product_name, $quantity, $price);

        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;

            $stmt2 = $conn->prepare("INSERT INTO customers (id, full_name, phone, address) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("isss", $order_id, $full_name, $phone, $address);

            if ($stmt2->execute()) {
                echo "success"; // 🔥 IMPORTANT
            } else {
                echo "error";
            }
            $stmt2->close();
        } else {
            echo "error";
        }
        $stmt->close();

    } else {
        echo "invalid";
    }
}
?>
