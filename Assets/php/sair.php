<?php


require_once "Class/config.php";
require_once "Class/Db.php";

$db = new Db(DB_NAME, DB_HOST, DB_USER, DB_PASS);
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }

$db->sair("../../login.php");