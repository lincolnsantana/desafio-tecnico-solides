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
$query = "SELECT fcd.id_usuario, fcd.valor_salario, fcd.salario_ferias, fcd.terco, fcd.valor_com_terco,
fcd.inss, fcd.irrf, fcd.valor_liquido, fcd.quantidade_dias, fcd.data_busca_ferias 
FROM ferias_contando_dias_uteis fcd
WHERE fcd.id_usuario = $user ORDER BY fcd.data_busca_ferias DESC";


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
            <a href="calculadoradiasuteis.php" class="logout"><span class="material-symbols-outlined">
                    arrow_back
                </span>Voltar para a calculadora</a>
            <img src="system/css/svglogosolides.svg" alt="sólides logo" class="logo" />

        </div>
        <div class="calculadora-container">
            <div class="calculator-titles">
                <h1>Histórico Calculadora de Férias por dias úteis</h1>
                <p>Visualize todos os calculos realizados das férias por dias úteis.</p>
            </div>
            <div class="tabelas-historico">
                <?php

                
                foreach ($resultados as $row) {
                    $data = new DateTime($row['data_busca_ferias']);
                    echo "<h2>Consulta realizada em " . $data->format('d/m - H:i');
                    echo '<table class="resultado-tabela">';
                    echo '<tr class="cabecalho"><th>Eventos<th>Proventos</th><th>Descontos</th></tr>';
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