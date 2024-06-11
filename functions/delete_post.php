<?php
$db = new mysqli('localhost', 'root', 'Root', 'termin');

$post_id = $_GET['id'];

$sql = "DELETE FROM posts WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $post_id);
$stmt->execute();

header('Location: ../dashboard.php');
