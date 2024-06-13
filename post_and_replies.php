<?php
require 'functions/db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$post_id = $_GET['id'];
//henter replies
$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
//henter replies pt.2
$sql = "SELECT replies.*, users.username FROM replies JOIN users ON replies.user_id = users.id WHERE replies.post_id = ? ORDER BY replies.timestamp ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $post_id);
$stmt->execute();
$replies = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$posts = array($post);
?>


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