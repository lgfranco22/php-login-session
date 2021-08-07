<?php
require_once "conexao.php";
require_once "funcoes.php";

$email = $_POST['email'] ?? false;
$senha = $_POST['senha'] ?? false;
$lembrar = isset($_POST['lembrar']) ? true : false;

if(!empty($email) && !empty($senha)) {
    
    $logado = logar($conn, $email, $senha, $lembrar);
    
    if($logado == true) {
        header("Location: dashboard.php");
    }
    else{
        flashMsg('warning', "Email e/ou senha inválidos!");
        header("Location: login.php");
    }

}
else{
    flashMsg('danger', "Informe email e senha para acessar!");
    header("Location: login.php");
}