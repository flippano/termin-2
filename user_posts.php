<?php
// Connect to the database
// Replace with your own database connection code
$db = new mysqli('localhost', 'root', 'Root', 'termin');

// Get the user ID from the query string
$user_id = $_GET['user_id'];

// Query the database for the username and posts of the user
$sql = "SELECT users.username, posts.* FROM users JOIN posts ON users.id = posts.user_id WHERE users.id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Display the username and posts
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
                <a class="likeButton" href="like_post.php?id=<?php echo $post['id']; ?>">
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

<link rel="stylesheet" href="style.css">

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
