<!DOCTYPE html>
<?php
/**
 * Anita Jiang
 * April 12, 2025
 * Dashboard Main Page
 */
include "../php/connect_server.php"; // change to appropriate location later.
session_start();

$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

// get user stats.
if ($isLoggedIn) {
    // get post count, total ovation count.
    $cmd = "SELECT COUNT(*) as post_count, SUM(ovation) as total_ovation FROM posts WHERE username = ?";
    $stmt = $dbh->prepare($cmd);
    $stmt->execute([$username]);
    $stats = $stmt->fetch();

    $totalPosts = $stats['post_count'];
    $totalOvation = $stats['total_ovation'] ? $stats['total_ovation'] : 0;

    // get all of user's posts.
    $cmd = "SELECT p.*, (SELECT COUNT(*) FROM `images` i where i.post_id = p.post_id) as has_image FROM posts p WHERE p.username = ? ORDER BY p.date DESC";
    $stmt = $dbh->prepare($cmd);
    $stmt->execute([$username]);
    $userPosts = $stmt->fetchAll();

    // get images for posts with images.
    $postImages = [];
    foreach ($userPosts as $post) {
        if ($post['has_image'] > 0) {
            $imageQuery = "SELECT `image_url` FROM `images` WHERE `post_id`=? LIMIT 1";
            $stmt = $dbh->prepare($imageQuery);
            $stmt->execute([$post['post_id']]);
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($image) {
                $postImages[$post['post_id']] = "data:image;base64," . htmlspecialchars(base64_encode($image["image_url"]));
            }
        }
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/dashboard-btns.js"></script>
    <script src="../js/delete-post.js"></script>
</head>

<body>
    <nav>
        <a class="navlink" href="../">home</a>
        <a class="navlink" href="../dashboard">dashboard</a>
        <a class="navlink" href="../feed">feed</a>
        <a class="navlink" href="../marketplace">marketplace</a>
        <?php if ($isLoggedIn): ?>
            <a class="navlink" href="../login/logout.php">log-out</a>
        <?php else: ?>
            <a class="navlink" href="../login">log-in</a>
        <?php endif; ?>
    </nav>

    <div id="container">
        <h1 id="pageTitle"><?php echo $isLoggedIn ? htmlspecialchars($username) . "'s armoire" : ""; ?></h1>

        <main>
            <?php if (!$isLoggedIn): ?>
                <div id="notLoggedIn">
                    <h2>welcome to your armoire.</h2>
                    <p>please sign in or create an account to view your dashboard.</p>
                    <div>
                        <a href="../login/" class="btn">sign in / create account</a> <!-- change to appropriate location later. -->
                    </div>
                </div>
            <?php else: ?>
                <!-- user stats -->
                <section>
                    <div id="userStats">
                        <div class="stat-box">
                            <span class="stat-number"><?php echo $totalPosts; ?></span>
                            <span>posts created</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-number"><?php echo $totalOvation; ?></span>
                            <span>ovations received</span>
                        </div>
                    </div>
                </section>

                <!-- user's posts -->
                <section>
                    <div id="postsHeader">
                        <h2>your posts</h2>
                        <a href="../dashboard/post-form.php" class="btn">create new post</a>
                    </div>

                    <?php if (empty($userPosts)): ?>
                        <div id="noPosts">
                            <p>you haven't created any posts yet.</p>
                            <a href="../dashboard/post-form.php" class="btn">create your first post</a>
                        </div>
                    <?php else: ?>
                        <div id="postsList">
                            <?php foreach ($userPosts as $post): ?>
                                <div class="post-item" id="post<?php echo $post['post_id']; ?>">
                                    <div class="post-header">
                                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                        <span><?php echo date('M d, Y', strtotime($post['date'])); ?></span>
                                    </div>

                                    <div class="post-link">
                                        <div class="post-content">
                                            <?php
                                            $content = htmlspecialchars($post['content']);
                                            echo strlen($content) > 150 ? substr($content, 0, 150) . '...' : $content;
                                            ?>

                                            <?php if (isset($postImages[$post['post_id']])): ?>
                                                <div class="post-images">
                                                    <img src="<?= $postImages[$post['post_id']] ?>" alt="Post image" class="post-thumbnail">
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="post-stats">
                                            <span>ovations: <?php echo $post['ovation']; ?></span>

                                            <?php if ($post['has_image'] > 0): ?>
                                                <span>images: <?php echo $post['has_image']; ?></span>
                                            <?php endif; ?>

                                            <?php if (isset($post['price']) && $post['price'] !== null): ?>
                                                <span>price: $<?php echo number_format($post['price'], 2); ?></span>
                                            <?php endif; ?>

                                            <?php if (isset($post['stock']) && $post['stock'] !== null): ?>
                                                <span>stock: <?php echo $post['stock']; ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="post-actions">
                                        <button class="btn delete-btn" data-post-id="<?php echo $post['post_id']; ?>" data-post-title="<?php echo htmlspecialchars($post['title']); ?>">delete</button>
                                        <a href="edit-post.php?id=<?php echo $post['post_id']; ?>" class="btn">edit</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endif; ?>
        </main>
    </div>

    <!-- little dialog for confirming delete -->
    <div id="confirmDialog" class="delete-dialog">
        <div id="confirmBox">
            <h3>are you sure?</h3>
            <p id="confirmMessage">this action cannot be undone.</p>
            <div id="confirmButtons">
                <button id="cancelDelete" class="btn">cancel</button>
                <form id="deleteForm" method="post">
                    <input type="hidden" id="deletePostId" name="post_id">
                    <button type="submit" id="confirmDelete" class="btn">delete</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>