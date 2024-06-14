<?php
session_start();

require 'functions/db_connect.php';
include 'functions/post.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content']) && isset($_SESSION['user_id'])) {
    $content = htmlspecialchars($_POST['content']);
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $content);
    if ($stmt->execute()) {
        header('Location: ../dashboard.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.timestamp DESC";
$result = $conn->query($sql);
$posts = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

$sql = "SELECT * FROM likes WHERE user_id = ? AND post_id = ?";
$stmt = $conn->prepare($sql);




?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <a href="liked_posts.php" class="button">View Liked Posts</a>
    <h2 class="title">Create a new post</h2>
    <form class="postform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <textarea class="posttextarea" name="content" required></textarea>
        <input class="postinput" type="submit" value="Submit">
    </form>
    <h2>Existing posts</h2>
        <?php render_posts($posts, $is_admin); ?>
    <a href="functions/logout.php"><button>Log Out</button></a>

<footer>
    <a href="FAQ.html">FAQ</a>
</footer>
</body>
</html>
