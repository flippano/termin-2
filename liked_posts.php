<?php
session_start();

require 'functions/db_connect.php';
include 'functions/post.php';

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

//henter alle liked posts
$sql = "SELECT posts.*, users.username FROM likes JOIN posts ON likes.post_id = posts.id JOIN users ON posts.user_id = users.id WHERE likes.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$posts = [];
while ($post = $result->fetch_assoc()) {
    $posts[] = $post;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<?php render_posts($posts, $is_admin); ?>
</body>

</html>


