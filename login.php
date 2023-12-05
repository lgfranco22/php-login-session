<?php 

require_once "Assets/php/Class/config.php";
require_once "Assets/php/Class/Db.php";

$db = new Db(DB_NAME, DB_HOST, DB_USER, DB_PASS);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Sistema de Login</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="Assets/css/style.css">
    <!-- Custom styles for this template -->
    <link href="Assets/css/signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
    <form class="form-signin" method="post" action="logar.php">
      <img class="mb-4" src="Assets/images/logo-fi.svg" alt="logo" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Identifique-se!</h1>
      <?php //flashMsg("warning");?>
      <?php //flashMsg("danger");?>

      <div id="mensagens">

      </div>

      <label for="email" class="sr-only">E-mail</label>
      <input type="email" id="email" name="email" class="form-control" placeholder="Endereço de e-mail" autofocus>
      <label for="senha" class="sr-only">Senha</label>
      <input type="password" name="senha" id="senha" class="form-control" placeholder="Informa a senha">
      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="1" id="check" name="lembrar"> Lembrar de mim
        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="button" id="bt_login">Entrar</button>
      <p class="mt-5 mb-3 text-muted">Copyright &copy; Franco Informática <?php echo date('Y'); ?></p>
    </form>

<script src="Assets/js/script.js"></script>
</body>
</html>