<?php
// Inicie a sessão

session_start();

// Verifique se o usuário está logado

if (isset($_SESSION['user_id'])) {

    // O usuário não está logado, redirecione-o para a página de login
    header('Location: home.php');
    exit;
} else {
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="system/css/style.css">

  <title>Login</title>
</head>

<body>
  <div class="main-login">
    <div class="left-login">
      <div class="left-login-logo"><img src="system/css/svglogosolides.svg" alt="calculadora" srcset=""></div>
      <div class="card-left">
        <img class="left-login-image" src="system/css/calc.svg" alt="calculadora" srcset="">
        <h1>Comece a utilizar a calculadora de férias.</h1>
        <h2>Facilite o dia a dia do seu RH.</h2>
      </div>
    </div>
    <div class="right-login">
      <form class="card-login" id="login-form" action="system/verificar-login.php" method="POST">
        <h1 class="title">Login</h1>
        <div class="textfield">
          <label for="usuario">Seu email</label>
          <input type="email" name="email" placeholder="nome@provedor.com">
         
        </div>
        <div class="textfield">
          <label for="usuario">Sua senha</label>
          <input type="password" name="senha" placeholder="******">
          <div class="verifica-login" id="verifica-login"></div>
        </div>
        <button class="btn-login" type="submit-button">Entrar <span class="material-symbols-outlined">
            arrow_forward
          </span></button>
        <strong>Não se registrou ainda? <a class="" href="cadastro.php" target="_blank">Crie uma
            conta</a></strong>
      </form>
    </div>
  </div>
</body>

</html>