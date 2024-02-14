<?php
// Inicie a sessão

session_start();

// Verifique se o usuário está logado

if (!isset($_SESSION['user_id'])) {
    // O usuário não está logado, redirecione-o para a página de login
    header('Location: login.php');
    exit;
} else {
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Calculadora de Férias: Férias Proporcionais - Sólides</title>
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
                <h1>Calculadora de Férias Proporcionais</h1>
                <p>Calcule o valor das suas férias com base no seu salário e nos meses que você trabalhou.</p>
            </div>

            <div class="calculadora-form">
                <form id="feriasproporcionais-form" action="system/calcferiasproporcionais.php" method="POST">
                    <div class="textfield-calculadora">
                        <label for="valor">Salário bruto</label>
                        <input type="number" id="valor" name="valor" placeholder="R$" min="0" required>
                    </div>
                    <div class="textfield-calculadora"><label for="quantidade_dias">Meses trabalhados (máx 12)</label>
                    <input type="number" id="mesestrabalhados" name="mesestrabalhados" placeholder="Ex: 6" max="12" required>
                    </div>
            </div>
            <button class="btn-calculadora" type='submit'>Calcular férias</button>
            </form>

            <hr class="separador">
            
            <div class="resultado-feriasproporcionais" id="resultado-feriasproporcionais">
              
            </div>

            <div class="historico">
                <a href="historicoproporcionais.php" class="btn-historico">Exibir histórico</a>
            </div>
            
        </div>

    </div>
    <script src="system/js/ajax-proporcionais.js"></script>
</body>

</html>