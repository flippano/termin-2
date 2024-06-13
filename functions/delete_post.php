<?php
require 'db_connect.php';

$post_id = $_GET['id'];

$sql = "DELETE FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $post_id);
$stmt->execute();

header('Location: ../dashboard.php');
