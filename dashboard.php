<?php
// Start the session
session_start();

// Debug: print out all session variables

// Connect to the database
$db = new mysqli('localhost', 'root', 'Root', 'termin');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header('Location: login.php');
    exit;
}



// Check if user is admin
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];


// If form is submitted, insert new post into the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content']) && isset($_SESSION['user_id'])) {
    $content = $_POST['content'];
    $content = htmlspecialchars($content);
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO posts (user_id, content) VALUES (?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("is", $user_id, $content);
    if ($stmt->execute()) {
        echo "posted!";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {

}


// Fetch all posts from the database and join with users table to get username
$sql = "SELECT posts.*, users.id FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.timestamp DESC";
$result = $db->query($sql);

// Fetch all posts from the database and sort them by time
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.timestamp DESC";
    $result = $db->query($sql);
    $posts = $result->fetch_all(MYSQLI_ASSOC);
}

$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.timestamp DESC";
$result = $db->query($sql);

$posts = array();
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

$sql = "SELECT posts.*, users.id FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.timestamp DESC";
$result = $db->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data
    
    // Redirect to the same page
    header('Location: dashboard.php');
    exit;
}

// Query the database for a like from the current user on the current post
$sql = "SELECT * FROM likes WHERE user_id = ? AND post_id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('ii', $current_user_id, $post['id']);
$stmt->execute();
$like = $stmt->get_result()->fetch_assoc();



?>

<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">

<body>

    <a href="liked_posts.php" class="button">View Liked Posts</a>

    <h2 class="title">Create a new post</h2>
    <form class="postform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <textarea class="posttextarea" name="content" required></textarea>
        <input class="postinput" type="submit" value="Submit">
    </form>

    <!-- Refresh button -->
    <form method="POST">
        <button class="refresh" type="submit">Refresh Posts</button>
    </form>

    <h2>Existing posts</h2>

    <!-- Display posts -->
    <?php 

if (isset($posts)): 
    foreach ($posts as $post): ?>
        <div class="postdiv" onclick="postdivclick(event, <?php echo $post['id'] ?>)">
            <h2 class="postusername">
                <a href="user_posts.php?user_id=<?php echo $post['user_id']; ?>">
                    <?php echo htmlspecialchars($post['username']); ?>
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
            <!-- Delete button for admin users -->
            <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="deleteButton" style="<?php echo $is_admin ? '' : 'display: none;'; ?>">Delete</a>
        </div>
    <?php endforeach; 
endif; ?>
    <!-- Logout button -->
    <a href="logout.php">
        <button>Log Out</button>
    </a>
</body>

</html>



<script>
    function postdivclick(e, id) {
        if (e.target.classList != "postdiv") {
            return;
        }

        // piss

        window.location = `post_and_replies.php?id=${id}`
    }


    document.querySelectorAll('.likeButton').forEach(function (button) {
        button.addEventListener('click', function () {
            var postId = this.dataset.postId;

            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'like_post.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + postId);

            // Update like count
            xhr.onload = function () {
                if (xhr.status == 200) {
                    var likeCount = button.querySelector('.likeCount');
                    likeCount.textContent = parseInt(likeCount.textContent) + 1;
                }
            };
        });
    });

    document.querySelectorAll('.showRepliesButton').forEach(function (button) {
        button.addEventListener('click', function () {
            // Toggle the display of the replies and the reply form
            var replies = button.nextElementSibling;
            var replyForm = replies.nextElementSibling;
            replies.style.display = replies.style.display === 'none' ? 'block' : 'none';
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });

    document.querySelectorAll('.replyButton').forEach(function (button) {
        button.addEventListener('click', function () {
            // Toggle the display of the reply form
            var replyForm = button.nextElementSibling;
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });
</script>


