<?php

date_default_timezone_set( 'America/Sao_Paulo' );

require_once "Assets/php/Class/config.php";
require_once "Assets/php/Class/Db.php";


$db = new Db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

$dados = json_decode(file_get_contents('php://input', true)); // true no final faz com que ele venha com associativo (ASSOC)

$email = $dados->email ?? false;
$senha = $dados->senha ?? false;
$lembrar = $dados->lembrar;

$retorno = array();

if(!empty($email) && !empty($senha)) {
    
    $logado = $db->logar($email, $senha, $lembrar);
    
    $ultima_tentativa = $db->getUltimoAcesso($email);

    if(!empty($ultima_tentativa)){
        
        $data_ultima = strtotime($ultima_tentativa['data_hora']);
        $data_atual = strtotime(date('Y-m-d H:i:s'));
        $minutos = floor(($data_atual - $data_ultima) / 60);

        if($ultima_tentativa['tentativas'] > TENTATIVAS_LOGIN_FAIL) {
            $retorno = [
                'status' => 'danger',
                'message' => 'Seu login esta bloqueado. Tente novamente em '
                    . (MINUTOS_LIMITE_LOGIN - $minutos)." minutos"
            ];
            $logado = false;
            $db->sair();
        }
        else{
            if($logado == true) {
                $retorno = [
                    'status' => 'success',
                    'message' => 'Bem vindo ' . $_SESSION['usuario']['nome'] . '!'
                ];
            }
            else{
                $retorno = [
                    'status' => 'warning',
                    'message' => 'Email e/ou senha inválidos!'
                ];
            }
        }
    }
    else{
        $retorno = [
            'status' => 'success',
            'message' => 'Bem vindo ' . $_SESSION['usuario']['nome'] . '!'
        ];
    }
}
else{
    $retorno = [
        'status' => 'danger',
        'message' => 'Informe email e senha para acessar!'
    ];
}

header("Content-Type: application/json");
echo json_encode($retorno);
