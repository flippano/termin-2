<?php
session_start();

// Connect to the database
$db = new mysqli('localhost', 'root', 'Root', 'termin');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get all posts liked by the current user
$sql = "SELECT posts.*, users.username FROM likes JOIN posts ON likes.post_id = posts.id JOIN users ON posts.user_id = users.id WHERE likes.user_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the posts into an array
$posts = [];
while ($post = $result->fetch_assoc()) {
    $posts[] = $post;
}

// Close the database connection

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
<?php if (isset($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="postdiv" onclick="postdivclick(event, <?php echo $post['id'] ?>)">
                <h2 class="postusername">
                    <a href="user_posts.php?user_id=<?php echo $post['user_id']; ?>">
                        <?php echo htmlspecialchars($post['username']); ?>
                    </a>
                </h2>
                <p class="posttimestamp"><?php echo $post['timestamp']; ?></p>
                <p class="postcontent"><?php echo htmlspecialchars($post['content']); ?></p>
                <p class="likeCount">Likes: <?php echo $post['likes']; ?></p>
                <a href="like_post.php?id=<?php echo $post['id']; ?>" class="likeButton">
                like<span class="likeCount"></span>
                </a>
                <!-- Reply button -->
                <a class="replyButton" data-post-id="<?php echo $post['id']; ?>">Reply</a>
                <!-- Hidden reply form -->
                <div class="replyForm" style="display: none;">
                    <form action="post_reply.php" method="post">
                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                        <textarea name="content"></textarea>
                        <input type="submit" value="Post Reply">
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>

<script>
    document.querySelectorAll('.replyButton').forEach(function (button) {
        button.addEventListener('click', function () {
            // Toggle the display of the reply form
            var replyForm = button.nextElementSibling;
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });

    function postdivclick(e, id) {
        if (e.target.classList != "postdiv") {
            return;
        }

        // piss

        window.location = `post_and_replies.php?id=${id}`
    }
</script>

