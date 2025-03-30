<?php
include "../php/connect_local.php";

session_start();

$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_SPECIAL_CHARS);
$listOnMarket = isset($_POST["market"]);

$username = $_SESSION["username"];

if ($title !== null && $title !== false && $content !== null && $content !== false) {
    if ($listOnMarket) {
        $price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT);
        $stock = filter_input(INPUT_POST, "stock", FILTER_SANITIZE_NUMBER_INT);

        $command = "INSERT INTO `posts` (`username`,`title`,`content`,`price`,`stock`) VALUES (?,?,?,?,?)";
        $params = [$username, $title, $content, $price, $stock];
    } else {
        $command = "INSERT INTO `posts` (`username`,`title`,`content`) VALUES (?,?,?)";
        $params = [$username, $title, $content];
    }

    $stmt = $dbh->prepare($command);
    $success = $stmt->execute($params);
} else {
    header("Location: ./index.php?auth=false");
}

// header() redirect user back to post dashboard, once this is implemented
