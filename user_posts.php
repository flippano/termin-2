<?php
require 'functions/db_connect.php';

$user_id = $_GET['user_id'];

$sql = "SELECT users.username, posts.* FROM users JOIN posts ON users.id = posts.user_id WHERE users.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

echo "<h1>" . htmlspecialchars($posts[0]['username']) . "'s Posts</h1>";
?>

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
                <a class="likeButton" href="functions/like_post.php?id=<?php echo $post['id']; ?>">
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

<link rel="stylesheet" href="style.css">

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
