<?php

include "conexao.php";

$nome = "Luiz Gonzaga Franco Michelmann";
$email = "lgfranco22@live.com";
$senha = password_hash("root", PASSWORD_DEFAULT);
$token = md5(uniqid());

$sql = "insert into usuarios (nome, email, senha, token) values (:nome, :email, :senha, :token);";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":nome", $nome);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":senha", $senha);
$stmt->bindParam(":token", $token);
$stmt->execute();