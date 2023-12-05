<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=devtube_loginphp", "root", "");
    $conn->exec("SET NAMES utf8");
} catch(PDOException $e) {
    echo $e->getMessage();
    exit;
}
