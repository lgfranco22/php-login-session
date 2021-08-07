<?php

require_once 'verifica_logado.php';

if(isset($_SESSION['usuario']) && !empty($_SESSION['usuario']))
{
    header("Location: dashboard.php");
}

?>