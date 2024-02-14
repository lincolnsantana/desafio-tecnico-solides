<?php

session_start(); // Iniciar a sessão

require 'system/funcoes-calc.php';
require 'system/conexao.php';

if (!isset($_SESSION['user_id'])) {
  // O usuário está logado, redirecione-o para a página calculadora.php
  header('Location: login.php');
  exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="system/css/stylehome.css">
    <link rel="stylesheet" href="system/css/style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script>

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Calculadora de Férias - Sólides</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="home.php" class="logout"><span class="material-symbols-outlined">
                    arrow_back
                </span><span class="logout-text">Voltar para o início</span></a>
            <img src="system/css/svglogosolides.svg" alt="sólides logo" class="logo" />

        </div>
        <div class="calculadora-container">
            <div class="calculator-titles">
                <h2>Calculadora de Férias Completas</h2>
                <p>Calcule o valor das suas férias com base no seu salário e nos seus dias de descanso.</p>
            </div>

            <div class="calculadora-form">
                <form id="ferias-form" action="system/calcferias.php" method="POST">
                    <div class="textfield-calculadora">
                        <label for="valor">Salário bruto</label>
                        <input type="number" id="valor" name="valor" placeholder="R$" min="0" required>
                    </div>
                    <div class="textfield-calculadora"><label for="quantidade_dias">Dias de férias</label>
                    <input type="number" id="quantidade_dias" name="quantidade_dias" placeholder="30 dias" min="1" required>
                    </div>
            </div>
            <button class="btn-calculadora" type='submit'>Calcular férias</button>
            </form>

            <hr class="separador">
            
            <div class="resultado-ferias" id="resultado-ferias"></div>

            <div class="historico">
                <a href="historicoferias.php" class="btn-historico">Exibir histórico</a>
            </div>
            
        </div>

    </div>
    <script src="system/js/ajax-ferias.js"></script>
</body>

</html>