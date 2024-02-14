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
// Preparar o query SQL usando inner join
$query = "SELECT fd.id_usuario, fd.valor_salario, fd.quantidade_dias, fd.salario_ferias, fd.terco, fd.valor_com_terco, fd.inss, fd.irrf, fd.valor_liquido, fd.data_busca
FROM ferias_dados fd
WHERE fd.id_usuario = $user ORDER BY fd.data_busca DESC";

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
            <a href="calculadoraferias.php" class="logout"><span class="material-symbols-outlined">
                    arrow_back
                </span>Voltar para a calculadora</a>
            <img src="system/css/svglogosolides.svg" alt="sólides logo" class="logo" />

        </div>
        <div class="calculadora-container">
            <div class="calculator-titles">
                <h1>Histórico Calculadora de Férias Completas</h1>
                <p>Visualize todos os calculos realizados das férias completas.</p>
            </div>
            <div class="tabelas-historico">
                <?php

                
                foreach ($resultados as $row) {
                    $data = new DateTime($row['data_busca']);
                    echo "<h2>Consulta realizada em " . $data->format('d/m - H:i');
                    echo '<table class="resultado-tabela">';
                    echo '<tr class="cabecalho"><th>Eventos</th><th>Proventos</th><th>Descontos</th></tr>';
                    echo '<tr>';
                    echo '<td>Valor do salário</td><td>R$ ' . number_format($row['valor_salario'], 2, ',', '.') . ' </td><td>-</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>1/3 do salário</td><td>R$ ' . number_format($row['terco'], 2, ',', '.') . ' </td><td>-</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>INSS</td><td>-</td><td>R$' . number_format($row['inss'], 2, ',', '.') . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>IRRF</td><td></td>-<td>R$ ' . number_format($row['irrf'], 2, ',', '.') . ' </td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Totais</td><td>R$ ' . number_format($row['valor_com_terco'], 2, ',', '.') . '</td><td>-</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Valor líquido a receber</td><td>R$ ' . number_format($row['valor_liquido'], 2, ',', '.') . ' </td><td>-</td>';
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