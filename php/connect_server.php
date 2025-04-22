<?php
try {
    $dbh =  new PDO("mysql:host=localhost;dbname=jianga42_db", "jianga42_local", "B:UhdCru");
} catch (Exception $e) {
    die("It's so over. {$e->getMessage()}");
}
