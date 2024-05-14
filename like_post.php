<?php
session_start();

// echo "piss";die();

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    // Connect to the database
    $db = new mysqli('localhost', 'root', 'Root', 'termin');

    // Check connection
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }


    // Check if the user has already liked the post
    $sql = "SELECT * FROM likes WHERE user_id = ? AND post_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ii', $_SESSION['user_id'], $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // The user has already liked the post, so remove their like
        $sql = "DELETE FROM likes WHERE user_id = ? AND post_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ii', $_SESSION['user_id'], $_GET['id']);
        $stmt->execute();

        // Decrement like count
        $sql = "UPDATE posts SET likes = likes - 1 WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
    } else {
        // The user has not liked the post, so add their like
        $sql = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ii', $_SESSION['user_id'], $_GET['id']);
        $stmt->execute();

        // Increment like count
        $sql = "UPDATE posts SET likes = likes + 1 WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
    }

    // Close the database connection

    // Redirect back to the dashboard page
    header('Location: dashboard.php');
    $db->close();
    exit;
}