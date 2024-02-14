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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script>

    </script>
    <title>Calculadora de Férias Sólides</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="system/css/svglogosolides.svg" alt="sólides logo" class="logo" />
            <a href="logout.php" class="logout"><span class="logout-text">Sair da plataforma</span> <span class="material-symbols-outlined">
                    logout
                </span></a>
        </div>
        <form action="verificar-opcoes.php" method="POST" class="content">
            <div class="content-text">
                <h1 class="name-user">Olá, <?php echo  $_SESSION['nome']; ?>!</h1>
                <h1 class="subtitle">O que você deseja calcular hoje?</h1>
                <p class="description">Explore as possibilidades e selecione a opção desejada.</p>
            </div>

            <div class="options">
                <label class="option">
                    <input type="radio" value="calculadoraferias.php" name="pagina" id="ferias-completas">
                    <div class="border-icon"><img src="system/css/beach-access.svg" alt="Férias completas icon" class="icon" /></div>
                    <div class="option-text">
                        <h2>Férias completas</h2>
                        <p>Calcule o valor das suas férias com base no seu salário e nos seus dias de descanso.</p>
                    </div>
                </label>
                <label class="option">
                    <input type="radio" value="calculadoradiasuteis.php" name="pagina" id="ferias-completas">
                    <div class="border-icon"><img src="system/css/calendar-range.svg" alt="Férias por dias úteis icon" class="icon" /></div>
                    <div class="option-text">
                        <h2>Férias por dias úteis</h2>
                        <p>Calcule o valor das suas férias com base no seu salário e dias uteis do intervalo estipulado.</p>
                    </div>
                </label>
                <label class="option">
                    <input type="radio" value="feriasproporcionais.php" name="pagina" id="ferias-completas">
                    <div class="border-icon">
                        <img src="system/css/table-view.svg" alt="Férias proporcionais icon" class="icon" />
                    </div>
                    <div class="option-text">
                        <h2>Férias proporcionais</h2>
                        <p>Calculo proporcional do valor do salário de férias com base nos meses trabalhados.</p>
                    </div>
                </label>
                <label class="option">
                    <input type="radio" value="vendaferias.php" name="pagina" id="ferias-completas">
                    <div class="border-icon">
                        <img src="system/css/money.svg" alt="Venda de férias icon" class="icon" />
                    </div>
                    <div class="option-text">

                        <h2>Venda de férias</h2>
                        <p>Calcule o valor da venda de 1/3 de suas férias, além do cálculo de impostos e INSS.</p>
                    </div>
                </label>
            </div>
            <div class="botao-conteudo">
                <button id="continue-button" class="continue" type="submit">Continuar</button>
            </div>
        </form>
    </div>

    <script src="system/js/ativar-botoes.js"></script>
</body>

</html>