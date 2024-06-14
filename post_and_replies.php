<?php
require 'functions/db_connect.php';
include 'functions/post.php';

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];

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


<?php render_posts($posts, $is_admin); ?>


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