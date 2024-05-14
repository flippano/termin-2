<?php
// Connect to the database
$db = new mysqli('localhost', 'root', 'Root', 'termin');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get the post ID from the URL
$post_id = $_GET['id'];

// Get the post from the database
$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

// Get the replies for the post from the database
$sql = "SELECT replies.*, users.username FROM replies JOIN users ON replies.user_id = users.id WHERE replies.post_id = ? ORDER BY replies.timestamp ASC";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $post_id);
$stmt->execute();
$replies = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Create an array of posts for the template
$posts = array($post);
?>

<!-- Display the post using the provided template -->
<?php if (isset($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="postdiv">
                <h2 class="postusername">
                    <a href="user_posts.php?user_id=<?php echo $post['user_id']; ?>">
                        <?php echo htmlspecialchars($post['username']);; ?>
                    </a>
                </h2>
                <p class="posttimestamp"><?php echo $post['timestamp']; ?></p>
                <p class="postcontent"><?php echo $post['content']; ?></p>
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

<!-- Display the replies -->
<?php foreach ($replies as $reply): ?>
    <div class="reply">
        <h3 class="replyusername"><?php echo htmlspecialchars($reply['username']); ?></h3>
        <p class="replytimestamp"><?php echo $reply['timestamp']; ?></p>
        <p class="replycontent"><?php echo htmlspecialchars($reply['content']); ?></p>
    </div>
<?php endforeach; ?>

<link rel="stylesheet" href="style.css">

<style>
    .postdiv {
        font-size: 1.5rem !important;
    }

    .postdiv:hover {
        font-size: 1.6rem !important;
    }

    .reply {
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .reply:hover {
        font-size: 1.1rem;
    }
</style>