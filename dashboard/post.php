<?php
include "../php/connect_local.php";

$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_SPECIAL_CHARS);
$listOnMarket = isset($_POST["market"]);

if ($title !== null && $title !== false && $content !== null && $content !== false) {
    if ($listOnMarket) {
        $price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT);
        $stock = filter_input(INPUT_POST, "stock", FILTER_SANITIZE_NUMBER_INT);

        $command = "INSERT INTO `posts` (`title`,`content`,`price`,`stock`) VALUES (?,?,?,?)";
        $params = [$title, $content, $price, $stock];
    } else {
        $command = "INSERT INTO `posts` (`title`,`content`) VALUES (?,?)";
        $params = [$title, $content];
    }

    $stmt = $dbh->prepare($command);
    $success = $stmt->execute($params);
}
