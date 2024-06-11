<?php
session_start();

$db = new mysqli('localhost', 'root', 'Root', 'termin');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content']) && isset($_SESSION['user_id'])) {
    $content = htmlspecialchars($_POST['content']);
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $content);
    if ($stmt->execute()) {
        header('Location: ../dashboard.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.timestamp DESC";
$result = $db->query($sql);
$posts = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

$sql = "SELECT * FROM likes WHERE user_id = ? AND post_id = ?";
$stmt = $db->prepare($sql);

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
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="postdiv" onclick="postdivclick(event, <?php echo $post['id']; ?>)">
                <h2 class="postusername">
                    <a href="user_posts.php?user_id=<?php echo $post['user_id']; ?>">
                        <?php echo htmlspecialchars($post['username']); ?>
                    </a>
                </h2>
                <p class="posttimestamp"><?php echo $post['timestamp']; ?></p>
                <p class="postcontent"><?php echo htmlspecialchars($post['content']); ?></p>
                <p class="likeCount">Likes: <?php echo $post['likes']; ?></p>
                <a href="functions/like_post.php?id=<?php echo $post['id']; ?>" class="likeButton">like<span class="likeCount"></span></a>
                <a class="replyButton" data-post-id="<?php echo $post['id']; ?>">Reply</a>
                <div class="replyForm" style="display: none;">
                    <form action="functions/post_reply.php" method="post">
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                        <textarea name="content"></textarea>
                        <input type="submit" value="Post Reply">
                    </form>
                </div>
                <a href="functions/delete_post.php?id=<?php echo $post['id']; ?>" class="deleteButton" style="<?php echo $is_admin ? '' : 'display: none;'; ?>">Delete</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <a href="functions/logout.php"><button>Log Out</button></a>
    <script>
        function postdivclick(e, id) {
            if (e.target.classList != "postdiv") {
                return;
            }
            window.location = `post_and_replies.php?id=${id}`;
        }

        document.querySelectorAll('.likeButton').forEach(function(button) {
            button.addEventListener('click', function() {
                var postId = this.dataset.postId;
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'functions/like_post.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + postId);
                xhr.onload = function() {
                    if (xhr.status == 200) {
                        var likeCount = button.querySelector('.likeCount');
                        likeCount.textContent = parseInt(likeCount.textContent) + 1;
                    }
                };
            });
        });

        document.querySelectorAll('.replyButton').forEach(function(button) {
            button.addEventListener('click', function() {
                var replyForm = button.nextElementSibling;
                replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>
<footer>
    <a href="FAQ.html">FAQ</a>
</footer>
</body>
</html>
