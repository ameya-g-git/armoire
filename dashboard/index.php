<?php
// TODO: work on form logic, updating database, etc
include "../php/connect_local.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/add-market.js"></script>
    <script type="module" src="../js/post-valid.js"></script>
    <title>Dashboard</title>
</head>

<body>
    <div id="form">
        <form id="post-details" action="post.php" method="post">
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