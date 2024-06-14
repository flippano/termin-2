<?php
require 'functions/db_connect.php';
include 'functions/post.php';

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

$user_id = $_GET['user_id'];

$sql = "SELECT users.username, posts.* FROM users JOIN posts ON users.id = posts.user_id WHERE users.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo "<h1>" . htmlspecialchars($posts[0]['username']) . "'s Posts</h1>";
?>

<?php render_posts($posts, $is_admin); ?>

<link rel="stylesheet" href="style.css">

