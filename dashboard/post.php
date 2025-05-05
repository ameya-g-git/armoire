<!-- 
 Ameya Gupta
 400556266
 Post Creation Logic
 -->

<?php
include "../php/connect_server.php";

session_start();

$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_SPECIAL_CHARS);
$listOnMarket = isset($_POST["market"]);

$username = $_SESSION["username"];

$img = $_FILES["upload"];
$imgUploaded = isset($img['tmp_name']);
echo $imgUploaded;
print_r($img);

if ($title !== null && $title !== false && $content !== null && $content !== false) {
    if ($listOnMarket) {
        $price = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $stock = filter_input(INPUT_POST, "stock", FILTER_SANITIZE_NUMBER_INT);

        $command = "INSERT INTO `posts` (`username`,`title`,`content`,`price`,`stock`) VALUES (?,?,?,?,?)";
        $params = [$username, $title, $content, $price, $stock];
    } else {
        $command = "INSERT INTO `posts` (`username`,`title`,`content`) VALUES (?,?,?)";
        $params = [$username, $title, $content];
    }

    $stmt = $dbh->prepare($command);
    $success = $stmt->execute($params);

    if ($success) {
        if ($imgUploaded && $img["size"] <= 25000000) { // if user chose to upload image, make sure it's below 25 MB
            $lastId = $dbh->lastInsertId();
            $img_cmd = "INSERT INTO `images` (`post_id`, `image_url`) VALUES (?,?)";
            $img_params = [$lastId, file_get_contents($img["tmp_name"])];

            $img_stmt = $dbh->prepare($img_cmd);
            $img_success = $img_stmt->execute($img_params);
        }
    }
}
header("Location: ./index.php");
?>