<?php
session_start();


require 'db_connect.php';




if (isset($_POST['post_id']) && isset($_POST['content'])) {
    
    $sql = "INSERT INTO replies (user_id, post_id, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iis', $_SESSION['user_id'], $_POST['post_id'], $_POST['content']);
    $stmt->execute();
}


header('Location: ../dashboard.php');
exit;
