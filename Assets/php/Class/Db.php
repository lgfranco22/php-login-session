<?php
 if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "config.php";

class Db
{

    private $pdo;

    //Construtor
    public function __construct($dnmae, $host, $usuario, $senha)
    {
        try {
            $this->pdo = new PDO("mysql:dbname=" . $dnmae . ";host=" . $host, $usuario, $senha);
        } catch (PDOException $e) {
            echo "Erro no banco de dados: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }

    public function flashMsg($id, $msg = null)
    {
        if (is_null($msg)) {
            echo $this->temFlashMsg($id) ? "<div class='alert alert-$id'>{$_SESSION['flashMsg'][$id]}</div>" : "";
            unset($_SESSION['flashMsg'][$id]);
        } else {
            $_SESSION['flashMsg'][$id] = $msg;
        }
    }

    public function temFlashMsg($id)
    {
        return isset($_SESSION['flashMsg'][$id]) ? true : false;
    }


    public function logar($email, $senha, $lembrar, $token = null)
    {
        if (is_null($token)) {
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $condicao = $row && password_verify($senha, $row[0]['senha']);

            if ($lembrar == true) {
                setcookie('lembrar', $row[0]['token'], time() + (60 * 60 * 24 * 30));
            }
        } else {
            $sql = "SELECT * FROM usuarios WHERE token = :token";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":token", $token);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $condicao = !empty($row);
        }

        if ($condicao == true) {
            unset($row[0]['senha']);
            $_SESSION['usuario'] = $row[0];
            $this->logAcesso($email, LOG_STATUS_OK);
            return true;
        } else {
            $this->logAcesso($email, LOG_STATUS_FAIL);
            return false;
        }
    }


    public function logAcesso($email, $tipo)
    {
        $sql = "insert into logs (email, tipo) values (:email, :tipo);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":tipo", $tipo);
        return $stmt->execute();
    }

    public function getUltimoAcesso($email)
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

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function sair($redirecionar = null)
    {
        setcookie('lembrar', null, time() - 100);

        session_destroy();
        unset($_SESSION);
        if (!is_null($redirecionar)) {
            header("Location:$redirecionar");
        }
    }

    public function cadNewUser($nome, $email, $senha, $token)
    {
        $sql = $this->pdo->prepare("INSERT INTO usuarios (nome, email, senha, token) VALUES (:nome, :email, :senha, :token)");

        $sql->bindParam(":nome", $nome);
        $sql->bindParam(":email", $email);
        $sql->bindParam(":senha", $senha);
        $sql->bindParam(":token", $token);
        $sql->execute();
    }
}
