<?php
// Irene Chen
// 14/04/2025
// Marketplace - Post Loading Functionality

header('Content-Type: application/json');
include "../php/connect_server.php";

// grab post data
$posts = array();
$command1 = "SELECT `username`, `title`, `content`, `date`, `post_id`, `ovation`, `price`, `stock` FROM `posts` WHERE `price` IS NOT NULL AND `stock` IS NOT NULL ORDER BY `date` DESC";
$stmt1 = $dbh->prepare($command1);
$success1 = $stmt1->execute();
if ($success1) {
    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        $posts[] = $row1;
    }
}

// grab image data for posts that have images
$images = array();
$command2 = "SELECT A.post_id, A.image_url FROM `images` A JOIN `posts` B ON A.post_id = B.post_id WHERE B.price IS NOT NULL AND B.stock IS NOT NULL ORDER BY B.date DESC";
$stmt2 = $dbh->prepare($command2);
$success2 = $stmt2->execute();
if ($success2) {
    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $newUrl = "data:image;base64," . htmlspecialchars(base64_encode($row2["image_url"]));
        $images[] = ["post_id" => $row2["post_id"], "image_url" => $newUrl];
    }
}

$response = [
    "posts" => $posts,
    "images" => $images
];

echo json_encode($response);
