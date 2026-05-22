<?php
// Include database connection
include "db.php";

// Check if email is posted
if(isset($_POST['email'])) {
    $email = trim($_POST['email']);

    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM newsletter WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if($stmt->num_rows > 0){
            echo "You are already subscribed!";
        } else {
            // Insert new subscriber
            $insert = $conn->prepare("INSERT INTO newsletter (email) VALUES (?)");
            $insert->bind_param("s", $email);

            if($insert->execute()){
                echo "Thank you for subscribing!";
            } else {
                echo "Error! Please try again later.";
            }

            $insert->close();
        }

        $stmt->close();

    } else {
        echo "Please enter a valid email address!";
    }
} else {
    echo "Email is required!";
}
?>
