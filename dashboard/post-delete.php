<?php
session_start();
/**
 * Anita Jiang
 * April 12, 2025
 * Post Actions - Delete
 */
include "../php/connect_server.php";

$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

$response = [
    'success' => false,
    'message' => 'nothing was specified as what to do'
];

if (!$isLoggedIn) {
    $response['message'] = 'you have to be logged in';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id']) && is_numeric($_POST['post_id'])) {
    $postId = (int)$_POST['post_id'];
    $cmd = "SELECT * FROM posts WHERE post_id = ? AND username = ?";
    $stmt = $dbh->prepare($cmd);
    $stmt->execute([$postId, $username]);
    $post = $stmt->fetch();

    if (!$post) {
        $response['message'] = 'post was not found or you do not have the perms to delete it';
        echo json_encode($response);
        exit;
    }

    try {
        $dbh->beginTransaction();
        $cmd = "SELECT image_url FROM images WHERE post_id = ?";
        $stmt = $dbh->prepare($cmd);
        $stmt->execute([$postId]);
        $images = $stmt->fetchAll();

        foreach ($images as $image) {
            if (file_exists($image['image_url'])) {
                unlink($image['image_url']);
            }
        }

        $cmd = "DELETE FROM images WHERE post_id = ?";
        $stmt = $dbh->prepare($cmd);
        $stmt->execute([$postId]);

        $cmd = "DELETE FROM posts WHERE post_id = ? AND username = ?";
        $stmt = $dbh->prepare($cmd);
        $stmt->execute([$postId, $username]);

        $dbh->commit();

        $response['success'] = true;
        $response['message'] = 'post deleted :)))'; // :)
    } catch (Exception $e) {
        $dbh->rollBack();
        $response['message'] = 'database error: ' . $e->getMessage();
    }
}

echo json_encode($response);
