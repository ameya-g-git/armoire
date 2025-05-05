<!-- 
 Ameya Gupta
 400556266
 Login Page
 -->

<?php
session_start();

$loggedIn = $_SESSION["username"];
$auth = filter_input(INPUT_GET, 'auth', FILTER_SANITIZE_SPECIAL_CHARS);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/login-mode.js"></script>
    <script type="module" src="../js/login-valid.js"></script>
    <title>Login</title>
</head>

<body>
    <nav>
        <a class="navlink" href="../">home</a>
        <a class="navlink" href="../dashboard">dashboard</a>
        <a class="navlink" href="../feed">feed</a>
        <a class="navlink" href="../marketplace">marketplace</a>
        <?php if ($isLoggedIn): ?>
            <a class="navlink" href="../login/logout.php">log-out</a>
        <?php else: ?>
            <a class="navlink" href="../login">log-in</a>
        <?php endif; ?>
    </nav>
    <div id="form">
        <h1 id="heading">log in</h1>
        <?php if ($auth === 'fail') {
            echo "<span>* log-in failed. try again?</span>";
        } else if ($auth === 'wrong') {
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
            <input hidden style="display: none;" type="checkbox" name="create-check" id="create-check">
            <input id="submit" type="submit" value="sign in!">
        </form>
    </div>
</body>

</html>