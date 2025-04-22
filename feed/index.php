<!-- 
    Irene Chen
    14/04/2025
    Feed Main Page
-->

<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Azeen's Armoire</title>

    <link rel="stylesheet" href="../css/styles.css" />
    <script src="../js/load-feed.js"></script>
</head>

<body>
    <nav>
        <a class="navlink" href="../">home</a>
        <a class="navlink" href="../dashboard">dashboard</a>
        <a class="navlink" href="../feed">feed</a>
        <a class="navlink" href="../marketplace">marketplace</a>
        <?php if ($isLoggedIn): ?>
            <a class="navlink" href="logout.php">log-out</a>
            <!-- TODO add logout path -->
        <?php else: ?>
            <a class="navlink" href="../login">log-in</a>
        <?php endif; ?>
    </nav>
    <div id="beige">
        <div id="background-svg">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="1280"
                height="506"
                viewBox="0 0 1280 506"
                fill="none">
                <path
                    opacity="0.1"
                    d="M-63 374.674C-58.5155 342.386 -23.8229 311.928 -2.21715 291.28C72.6262 219.758 163.009 161.324 257.679 119.679C316.515 93.7964 380.605 73.1527 445.358 71.7057C464.392 71.2803 495.142 70.8321 500.466 95.0903C503.519 108.995 497.854 123.193 491.439 135.154C470.786 173.661 438.355 206.258 408.561 237.633C354.985 294.056 293.987 346.603 249.941 411.299C238.261 428.456 207.299 476.58 231.715 496.24C248.01 509.36 275.477 503.255 292.756 496.842C344.709 477.56 387.612 435.659 425.67 397.027C509.77 311.658 581.672 215.019 648.856 116.068C657.606 103.18 666.144 90.1425 675.078 77.3799C677.707 73.6228 683.552 62.6206 684.277 67.1491C685.457 74.5272 683.766 84.42 683.073 91.4794C679.725 125.592 674.514 159.493 671.209 193.615C668.467 221.915 666.509 250.288 666.308 278.728C666.162 299.475 663.616 329.872 677.571 347.507C688.695 361.565 708.713 360.436 724.34 355.932C787.94 337.6 843.548 286.983 890.612 243.136C934.838 201.932 974.944 156.679 1015.19 111.683C1043.75 79.7467 1071.9 45.6746 1105.8 19.0902C1114.45 12.3059 1129.42 0.143551 1142 2.23954C1161.02 5.4097 1164.18 40.5873 1166.93 53.9952C1173.96 88.2325 1177.25 129.673 1196.85 159.742C1240.22 226.302 1335.41 229.334 1402.49 252.421"
                    stroke="#220026"
                    stroke-width="3"
                    stroke-linecap="round" />
            </svg>
        </div>
    </div>

    <div id="feed"></div>

    <footer>&copy; 2025 - Azeen's Armoire</footer>
</body>

</html>