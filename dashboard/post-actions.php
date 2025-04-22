<?php
session_start();
/**
 * Anita Jiang
 * April 12, 2025
 * Post Actions - Edit 
 */
include "../php/connect_server.php";

$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

$response = [
    'success' => false,
    'message' => 'nothing was specified'
];

if (!$isLoggedIn) {
    $response['message'] = 'you have to be logged in to do this';
    echo json_encode($response);
    exit;
}

$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    echo json_encode($response);
    exit;
}

if ($action === 'update') {
    if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
        $response['message'] = 'invalid post id';
        echo json_encode($response);
        exit;
    }

    $postId = (int)$_POST['post_id'];
    $cmd = "SELECT * FROM posts WHERE post_id = ? AND username = ?";
    $stmt = $dbh->prepare($cmd);
    $stmt->execute([$postId, $username]);
    $post = $stmt->fetch();

    if (!$post) {
        $response['message'] = 'post was not found, or you do not have the perms to edit it';
        echo json_encode($response);
        exit;
    }
    if (empty($_POST['title']) || empty($_POST['content'])) {
        $response['message'] = 'title and content are required';
        echo json_encode($response);
        exit;
    }

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    $isMarketplace = isset($_POST['market']) && $_POST['market'] === 'on';
    $price = $isMarketplace && isset($_POST['price']) ? floatval($_POST['price']) : null;
    $stock = $isMarketplace && isset($_POST['stock']) ? intval($_POST['stock']) : null;

    try {
        $dbh->beginTransaction();
        $cmd = "UPDATE posts SET title = ?, content = ?, price = ?, stock = ? WHERE post_id = ?";
        $stmt = $dbh->prepare($cmd);
        $stmt->execute([$title, $content, $price, $stock, $postId]);
        if (isset($_FILES['upload']) && $_FILES['upload']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileType = finfo_file($fileInfo, $_FILES['upload']['tmp_name']);
            finfo_close($fileInfo);

            if (!in_array($fileType, $allowedTypes)) {
                $dbh->rollBack();
                $response['message'] = 'invalid file type.';
                echo json_encode($response);
                exit;
            }

            $extension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
            $newFilename = 'post_' . $postId . '_' . uniqid() . '.' . $extension;
            $uploadDir = 'uploads/';

            // make new directory if doesn't exist.
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $destination = $uploadDir . $newFilename;

            if (move_uploaded_file($_FILES['upload']['tmp_name'], $destination)) {
                $cmd = "SELECT image_id, image_url FROM images WHERE post_id = ? LIMIT 1";
                $stmt = $dbh->prepare($cmd);
                $stmt->execute([$postId]);
                $existingImage = $stmt->fetch();

                if ($existingImage) {
                    $cmd = "UPDATE images SET image_url = ? WHERE image_id = ?";
                    $stmt = $dbh->prepare($cmd);
                    $stmt->execute([$destination, $existingImage['image_id']]);

                    if (file_exists($existingImage['image_url'])) {
                        unlink($existingImage['image_url']);
                    }
                } else {
                    $cmd = "INSERT INTO images (post_id, image_url) VALUES (?, ?)";
                    $stmt = $dbh->prepare($cmd);
                    $stmt->execute([$postId, $destination]);
                }
            } else {
                $dbh->rollBack();
                $response['message'] = 'failed to move uploaded file';
                echo json_encode($response);
                exit;
            }
        }
        $dbh->commit();

        $response['success'] = true;
        $response['message'] = 'post updated successfully yahoooo';
        header("Location: index.php");
        exit;
    } catch (Exception $e) {
        $dbh->rollBack();
        $response['message'] = 'database error: ' . $e->getMessage();
        echo json_encode($response);
        exit;
    }
}

// just some error handling.
$response['message'] = 'unknown action ???';
echo json_encode($response);
