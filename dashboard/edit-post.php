<?php session_start(); ?>
<!DOCTYPE html>
<?php
/**
 * Anita Jiang
 * April 15, 2025
 * Post Editing Form
 */
include "../php/connect_server.php"; // change to appropriate location later.

$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

if (!$isLoggedIn) {
    header("Location: ../login");
    exit;
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$postId = (int)$_GET['id'];

$cmd = "SELECT * FROM posts WHERE post_id = ? AND username = ?";
$stmt = $dbh->prepare($cmd);
$stmt->execute([$postId, $username]);
$post = $stmt->fetch();

if (!$post) {
    header("Location: index.php");
    exit;
}

$cmd = "SELECT image_url FROM images WHERE post_id = ? LIMIT 1";
$stmt = $dbh->prepare($cmd);
$stmt->execute([$postId]);
$image = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/add-market.js"></script>
    <script type="module" src="../js/edit-valid.js"></script>
    <script type="module" src="../js/image-preview.js"></script>
    <title>Edit post</title>
</head>

<body>
    <div id="form">
        <form id="post-details" action="post-actions.php" method="post" enctype="multipart/form-data">
            <span id="post-disc" style="display: none;">* make sure your post has no errors before submitting!</span>

            <input type="hidden" name="action" value="update">
            <input type="hidden" name="post_id" value="<?php echo $postId; ?>">

            <fieldset>
                <legend for="title">title</legend>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($post['title']); ?>">
            </fieldset>

            <fieldset>
                <legend for="content">post content</legend>
                <textarea rows="5" id="content" name="content"><?php echo htmlspecialchars($post['content']); ?></textarea>
            </fieldset>

            <label for="market">
                <input type="checkbox" name="market" id="market" <?php echo ($post['price'] !== null || $post['stock'] !== null) ? 'checked' : ''; ?>>
                list on marketplace?
            </label>

            <fieldset id="upload-field">
                <?php if ($image): ?>
                    <div>
                        <p>current image:</p>
                        <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="Current post image" style="max-height: 200px;">
                    </div>
                <?php else: ?>
                    <input type="file" name="upload" id="upload">
                    <img id="upload-preview" src="" alt="">
                <?php endif; ?>
            </fieldset>

            <div id="marketplace-input" style="<?php echo ($post['price'] !== null || $post['stock'] !== null) ? 'display: flex;' : ''; ?>">
                <fieldset>
                    <legend for="price">price</legend>
                    <input type="number" step="0.01" min="1" name="price" id="price" value="<?php echo htmlspecialchars($post['price'] ?? ''); ?>">
                </fieldset>
                <fieldset>
                    <legend for="stock">stock</legend>
                    <input type="number" step="1" min="1" max="100" name="stock" id="stock" value="<?php echo htmlspecialchars($post['stock'] ?? ''); ?>">
                </fieldset>
            </div>

            <input id="make-post" type="submit" value="update post!">
        </form>
    </div>
</body>

</html>