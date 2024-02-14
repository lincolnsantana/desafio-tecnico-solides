<?php
// Inicie a sessão

session_start();

// Verifique se o usuário está logado

if (!isset($_SESSION['user_id'])) {

    // O usuário não está logado, redirecione-o para a página de login
    header('Location: home.php');
    exit;
} else {
}

$user = $_SESSION['user_id'];


// Criar a conexão com o banco de dados
require 'system/conexao.php';

$query = "SELECT fp.id_usuario, fp.valor_salario, fp.ferias_proporcionais, fp.terco_ferias, fp.valor_bruto_ferias, fp.ferias_liquida, fp.quantidade_dias, fp.data_busca_proporcionais
FROM ferias_proporcionais fp
WHERE fp.id_usuario = $user ORDER BY fp.data_busca_proporcionais DESC";

$stmt = $conn->prepare($query);

// Executar o query
$stmt->execute();

// Obter os resultados da busca
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="system/css/stylehome.css">
    <link rel="stylesheet" href="system/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <script>

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Calculadora de Férias - Sólides</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="feriasproporcionais.php" class="logout"><span class="material-symbols-outlined">
                    arrow_back
                </span>Voltar para a calculadora</a>
            <img src="system/css/svglogosolides.svg" alt="sólides logo" class="logo" />

        </div>
        <div class="calculadora-container">
            <div class="calculator-titles">
                <h1>Histórico Calculadora de Férias Proporcionais</h1>
                <p>Visualize todos os calculos realizados das férias proporcionais.</p>
            </div>
            <div class="tabelas-historico">
                <?php

                
                foreach ($resultados as $row) {
                    $data = new DateTime($row['data_busca_proporcionais']);
                    echo "<h2>Consulta realizada em " . $data->format('d/m - H:i');
                    echo '<table class="resultado-tabela">';
                    echo '<tr class="cabecalho"><th>Eventos</th><th>Valor</th></tr>';
                    echo '<tr>';
                    echo '<td>Número de dias de férias</td><td>' . $row['quantidade_dias'] . ' </td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Valor férias proporcionais</td><td>R$ ' . number_format($row['ferias_proporcionais'], 2, ',', '.') . ' </td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>1/3 de férias</td><td>R$' . number_format($row['terco_ferias'], 2, ',', '.') . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Valor total das férias proporcionais</td><td>R$ ' . number_format($row['valor_bruto_ferias'], 2, ',', '.') . ' </td>';
                    echo '</tr>';
                    echo '</table>';
                }

                ?>
            </div>

        </div>

    </div>
    <script src="system/js/ajax-ferias.js"></script>
</body>

</html>