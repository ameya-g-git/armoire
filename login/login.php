<?php
include "../php/connect_server.php";

//  Ameya Gupta
//  400556266
//  Login Functionality

$accountMode = filter_input(INPUT_POST, "account-mode", FILTER_SANITIZE_SPECIAL_CHARS);
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
$hash = password_hash($password, PASSWORD_DEFAULT);

if ($username !== null && $username !== false && $password !== null && $password !== false) {
    $command = "SELECT * from `users` WHERE `username`=?";

    $stmt = $dbh->prepare($command);

    $params = [$username];
    $user_success = $stmt->execute($params);

    if ($accountMode === "login") { // login
        if ($row = $stmt->fetch()) {
            if (password_verify($password, $row["password"])) {
                // login and redirect to homepage
                session_start();
                $_SESSION['username'] = $username;
                header("Location: ../index.php");
            } else {
                // redirect back w/ special GET param to login page informing that password is incorrect
                header("Location: ./index.php?auth=wrong");
            }
        } else {
            // redirect back w/ special GET param to login page informing that account details are incorrect
            header("Location: ./index.php?auth=fail");
        }
    } else if ($accountMode == "create") { // create account
        if ($row = $stmt->fetch()) { // make sure account name doesn't already exist
            header("Location: ./index.php?auth=wrong");
        }

        $command = "INSERT INTO `users` (`username`,`password`) VALUES (?,?)";

        $stmt = $dbh->prepare($command);

        $params = [$username, $hash];
        $success = $stmt->execute($params);

        echo "hi";

        if ($success) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: ../index.php");
        } else {
            header("Location: ./index.php?auth=fail");
        }
    } else {
        header("Location: ./index.php?auth=fail");
    }
} else {
    header("Location: ./index.php?auth=fail");
}
