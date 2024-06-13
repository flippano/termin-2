<?php
session_start();

require 'functions/db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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
<?php //posts!
if (isset($posts)): ?>
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
                <a href="functions/like_post.php?id=<?php echo $post['id']; ?>" class="likeButton">
                like<span class="likeCount"></span>
                </a>
                
                <a class="replyButton" data-post-id="<?php echo $post['id']; ?>">Reply</a>
                
                <div class="replyForm" style="display: none;">
                    <form action="functions/post_reply.php" method="post">
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
                        var replyForm = button.nextElementSibling;
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });

    function postdivclick(e, id) {
        if (e.target.classList != "postdiv") {
            return;
        }

        
        window.location = `post_and_replies.php?id=${id}`
    }
</script>

