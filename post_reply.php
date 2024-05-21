<?php
session_start();


$db = new mysqli('localhost', 'root', 'Root', 'termin');


if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


if (isset($_POST['post_id']) && isset($_POST['content'])) {
    
    $sql = "INSERT INTO replies (user_id, post_id, content) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('iis', $_SESSION['user_id'], $_POST['post_id'], $_POST['content']);
    $stmt->execute();
}


header('Location: dashboard.php');
exit;
