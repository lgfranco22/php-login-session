<?php

require_once "Assets/php/Class/config.php";
require_once "Assets/php/Class/Db.php";

$db = new Db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

$nome = "Meliante Cabuloso";
$email = "meliante@gmail.com";
$senha = password_hash("meme", PASSWORD_DEFAULT);
$token = md5(uniqid());

$db->cadNewUser($nome, $email, $senha, $token);

echo "Usuário cadastrado com sucesso!";
