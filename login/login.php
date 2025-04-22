<!-- 
 Ameya Gupta
 400556266
 Login Functionality
 -->

<?php
include "../php/connect_server.php";

$accountMode = $_POST["account-mode"];
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
$hash = password_hash($password, PASSWORD_DEFAULT);

if ($username !== null && $username !== false && $password !== null && $password !== false) {

    if ($accountMode === "login") { // login
        $command = "SELECT * from `users` WHERE `username`=?";

        $stmt = $dbh->prepare($command);

        $params = [$username];
        $success = $stmt->execute($params);

        if ($row = $stmt->fetch()) {
            if (password_verify($password, $row["password"])) {
                session_start();
                $_SESSION['username'] = $username;
                header("Location: ../index.php");
            } else {
                header("Location: ./index.php?auth=wrong");
            }
        } else {
            header("Location: ./index.php?auth=fail");
        }
    } else if ($accountMode == "create") {
        $command = "INSERT INTO `users` (`username`,`password`) VALUES (?,?)";

        $stmt = $dbh->prepare($command);

        $params = [$username, $hash];
        $success = $stmt->execute($params);

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
?>