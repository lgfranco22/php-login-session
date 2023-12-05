<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// require_once 'verifica_logado.php';

if(isset($_SESSION['usuario']) && !empty($_SESSION['usuario']))
{
    header("Location: dashboard.php");
}
else{
    header("Location: login.php");
}

?>