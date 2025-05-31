<?php
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["user_id"];
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO diary_entries (user_id, title, content, date_created) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("iss", $user_id, $title, $content);

        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Failed to save your entry. Please try again.";
        }
    } else {
        echo "Title and content are required.";
    }
} else {
    header("Location: dashboard.php");
    exit;
}
?>
