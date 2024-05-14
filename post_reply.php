<?php
session_start();

// Connect to the database
$db = new mysqli('localhost', 'root', 'Root', 'termin');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if form data is set
if (isset($_POST['post_id']) && isset($_POST['content'])) {
    // Insert the reply into the database
    $sql = "INSERT INTO replies (user_id, post_id, content) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('iis', $_SESSION['user_id'], $_POST['post_id'], $_POST['content']);
    $stmt->execute();
}

// Redirect back to the dashboard page
header('Location: dashboard.php');
exit;
