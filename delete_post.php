<?php
// Connect to the database
// Replace with your own database connection
$db = new mysqli('localhost', 'root', 'Root', 'termin');

// Get the post ID from the query string
$post_id = $_GET['id'];

// Delete the post from the database
$sql = "DELETE FROM posts WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $post_id);
$stmt->execute();

// Redirect back to the dashboard
header('Location: dashboard.php');
