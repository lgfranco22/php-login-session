<?php
require_once "conexao.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define("LOG_STATUS_FAIL", 0);
define("LOG_STATUS_OK", 1);

define("TENTATIVAS_LOGIN_FAIL", 3);
define("MINUTOS_LIMITE_LOGIN", 30);

function flashMsg($id, $msg = null) // id é o tipo de mensagem (warning, success....) // msg é o texto
{
    if (is_null($msg)) {
        echo temFlashMsg($id) ? "<div class='alert alert-$id'>{$_SESSION['flashMsg'][$id]}</div>" : "";
        unset($_SESSION['flashMsg'][$id]);
    } else {
        $_SESSION['flashMsg'][$id] = $msg;
    }
}

function temFlashMsg($id)
{
    return isset($_SESSION['flashMsg'][$id]) ? true : false;
}

function logar($conn, $email, $senha, $lembrar, $token = null)
{
    if(is_null($token)){
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $condicao = $row && password_verify($senha, $row[0]['senha']);

        if($lembrar == true){
            setcookie('lembrar', $row[0]['token'], time() + (60 * 60 * 24 * 30));
        }
    }
    else{
        $sql = "SELECT * FROM usuarios WHERE token = :token";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":token", $token);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $condicao = !empty($row);
    }

    if($condicao == true){
        unset($row[0]['senha']);
        $_SESSION['usuario'] = $row[0];
        logAcesso($conn, $email, LOG_STATUS_OK);
        return true;
    }
    else{
        logAcesso($conn, $email, LOG_STATUS_FAIL);
        return false;
    }
}

function logAcesso($conn, $email, $tipo)
{
    $sql = "insert into logs (email, tipo) values (:email, :tipo);";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":tipo", $tipo);
    return $stmt->execute();
}

function getUltimoAcesso($conn, $email)
{
    $sql = "SELECT 
        COUNT(id) AS tentativas, email, data_hora
        FROM
            logs
        WHERE
            email = :email
                AND data_hora > (SELECT MAX(NOW()) - INTERVAL 30 MINUTE)
                AND tipo = 0
        GROUP BY email limit 1;";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function sair($redirecionar = null) 
{
    setcookie('lembrar', null, time() - 100);

    session_destroy();
    if(!is_null($redirecionar)){
        header("Location:$redirecionar");
    }
}