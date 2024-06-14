<?php
function render_posts($posts, $is_admin) {
    if (!empty($posts)): ?>
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
    <?php endif;
}
?>
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