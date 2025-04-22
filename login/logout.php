<!-- 
 Ameya Gupta
 400556266
 Logout Functionality (wow, really that simple)
 -->

<?php
session_start();
session_destroy();
header("Location: ../index.php");
