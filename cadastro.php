<?php
// Inicie a sessão

session_start();

// Verifique se o usuário está logado

if (isset($_SESSION['user_id'])) {
  // O usuário não está logado, redirecione-o para a página de login
  header('Location: system/calculadora.php');
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
  <link rel="stylesheet" href="system/css/style.css">

  <title>Login</title>
</head>

<body>
  <div class="main-login">
    <div class="left-login">
      <div class="left-login-logo"><img src="system/css/svglogosolides.svg" alt="calculadora" srcset=""></div>
      <img class="left-login-image" src="system/css/calc.svg" alt="calculadora" srcset="">
      <div class="card-left">
        <h1>Comece a utilizar a calculadora de férias.</h1>
        <h2>Facilite o dia a dia do seu RH.</h2>
      </div>
    </div>
    <div class="right-cadastro" >
      <form class="card-login" id="cadastro-form" action="system/cadastro-usuario.php" method="POST">
        <h1 class="title">Junte-se a plataforma</h1>
        <div class="textfield">
          <label for="usuario">Nome</label>
          <input type="text" name="nome" id="nome" placeholder="Digite seu nome">
        </div>
        <div class="textfield">
          <label for="usuario">Sobrenome</label>
          <input type="text" name="sobrenome" id="sobrenome" placeholder="Digite seu sobrenome">
        </div>
        <div class="textfield">
          <label for="usuario">Seu email</label>
          <input type="email" name="email" id="email" placeholder="nome@provedor.com">
        </div>
        <div class="textfield">
          <label for="usuario">Sua senha</label>
          <input type="password" name="senha" id="senha" placeholder="******">
        </div>
        <div class="textfield">
          <label for="usuario">Confirme sua senha</label>
          <input type="password" name="senha" id="senha" placeholder="******">
        </div>
        <button class="btn-cadastro" type="submit" id="submit-button">Finalizar Cadastro</button>
        <strong>Já tem registro? <a class="" href="login.php" target="_blank">Faça login</a></strong>
    </div>
    </form>
  </div>
  <script src="system/js/verificarsenha.js"></script>
</body>

</html>