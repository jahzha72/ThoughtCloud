<?php
session_start();
include 'config.php'; // Only needed if you're storing messages in DB

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Simple validation
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Optional: Store in database (example)
        // $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        // $stmt->bind_param("sss", $name, $email, $message);
        // $stmt->execute();
        // $stmt->close();

        // Optional: Email sending (only if you have mail server setup)
        // mail("you@example.com", "New message from $name", $message, "From: $email");

        // Feedback to user
        $_SESSION['success_message'] = "Thank you, your message has been sent!";
        header("Location: contact.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Please fill in all the fields.";
        header("Location: contact.php");
        exit;
    }
} else {
    header("Location: contact.php");
    exit;
}
?>
