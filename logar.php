<?php

require_once "Assets/php/Class/config.php";
require_once "Assets/php/Class/Db.php";

$email = $_POST['email'] ?? false;
$senha = $_POST['senha'] ?? false;
$lembrar = isset($_POST['lembrar']) ? true : false;

$db = new Db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

if(!empty($email) && !empty($senha)) {
    
    $logado = $db->logar($email, $senha, $lembrar);
    
    if($logado == true) {
        header("Location: dashboard.php");
    }
    else{
        $db->flashMsg('warning', "Email e/ou senha inválidos!");
        header("Location: login.php");
    }

}
else{
    $db->flashMsg('danger', "Informe email e senha para acessar!");
    header("Location: login.php");
}