<?php
session_start();

$loggedIn = $_SESSION["username"];
$auth = filter_input(INPUT_GET, 'auth', FILTER_SANITIZE_SPECIAL_CHARS);

echo $auth;

if ($loggedIn) {
    echo "cool beans";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/login-mode.js"></script>
    <script src="../js/login-valid.js"></script>
    <title>Login</title>
</head>

<body>
    <div id="form">
        <h1 id="heading">log in</h1>
        <?php if ($auth === 'false') {
            echo "<span>* log-in failed. account details are incorrect</span>";
        }
        ?>
        <form action="login.php" method="post">
            <section id="account-btns">
                <div id="login-btn" class="active">
                    <label for="login">log-in</label>
                    <input checked type="radio" name="account-mode" id="login" value="login">
                </div>
                <div id="create-btn">
                    <label for="create">create account</label>
                    <input type="radio" name="account-mode" id="create" value="create">
                </div>
            </section>
            <fieldset>
                <legend for="username">Username</legend>
                <input type="text" name="username" id="username">
            </fieldset>
            <fieldset>
                <legend for="password">Password</legend>
                <input type="password" name="password" id="password">
            </fieldset>
            <input hidden type="checkbox" name="create-check" id="create-check">
            <input id="submit" type="submit" value="sign in!">
        </form>
    </div>
</body>

</html>