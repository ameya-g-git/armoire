<?php
include "../php/connect_local.php";

$accountMode = $_POST["account-mode"];
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

if ($username !== null && $username !== false && $password !== null && $password !== false) {

    if ($accountMode === "login") {
        $command = "SELECT * from `users` WHERE `username`=? AND `password`=?";
        $stmt = $dbh->prepare($command);

        $params = [$username, $password];
        $success = $stmt->execute($params);

        if ($stmt->rowCount()) {
            session_start();
            $_SESSION['username'] = $username;
        } else {
            header("Location: ./index.php?auth=false");
        }
    }
} else {
    header("Location: ./index.php?auth=false");
}
?>
<a href="./index.php">go back</a>