<?php
session_start();



if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    
    $db = new mysqli('localhost', 'root', 'Root', 'termin');

    
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }


    
    $sql = "SELECT * FROM likes WHERE user_id = ? AND post_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param('ii', $_SESSION['user_id'], $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        $sql = "DELETE FROM likes WHERE user_id = ? AND post_id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ii', $_SESSION['user_id'], $_GET['id']);
        $stmt->execute();

        
        $sql = "UPDATE posts SET likes = likes - 1 WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
    } else {
        
        $sql = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('ii', $_SESSION['user_id'], $_GET['id']);
        $stmt->execute();

        
        $sql = "UPDATE posts SET likes = likes + 1 WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();
    }

    

    
    header('Location: ../dashboard.php');
    $db->close();
    exit;
}