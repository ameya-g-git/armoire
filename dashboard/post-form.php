<!-- 
 Ameya Gupta
 400556266
 Post Creation Form (this is the original file for the form also used in edit-post.php)
 -->

<?php
include "../php/connect_server.php";

session_start();
$loggedIn = $_SESSION["username"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/add-market.js"></script>
    <script type="module" src="../js/post-valid.js"></script>
    <script type="module" src="../js/image-preview.js"></script>
    <title>Dashboard</title>
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
    <div id="form">
        <form id="post-details" action="post.php" method="post" enctype="multipart/form-data">
            <span id="post-disc">* make sure your post has no errors before submitting!</span>
            <fieldset>
                <legend for="title">title</legend>
                <input type="text" name="title" id="title">
            </fieldset>
            <fieldset>
                <legend for="content">post content</legend>
                <textarea rows="5" id="content" name="content"></textarea>
            </fieldset>
            <label for="market">
                <input type="checkbox" name="market" id="market">
                list on marketplace?
            </label>
            <fieldset id="upload-field">
                <input type="file" name="upload" id="upload">
                <p id="ext-disc">file must be a JPG, JPEG, PNG, or GIF</p>
                <img id="upload-preview" src="" alt="">
            </fieldset>
            <div id="marketplace-input">
                <fieldset>
                    <legend for="price">price</legend>
                    <input type="number" step="0.01" min="1" name="price" id="price">
                </fieldset>
                <fieldset>
                    <legend for="stock">stock</legend>
                    <input type="number" step="1" min="1" max="100" name="stock" id="stock">
                </fieldset>
            </div>
            <input id="make-post" type="submit" value="post!">
        </form>
    </div>
</body>

</html>