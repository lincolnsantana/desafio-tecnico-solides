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
// Preparar o query SQL 


$query = "SELECT vf.id_usuario, vf.valor_salario, vf.terco_ferias, vf.abono_pecuniario, vf.salario_com_tercos, vf.terco_abono, vf.inss_abono, vf.irrf_abono, vf.venda_ferias_liquida, vf.data_busca_venda
FROM venda_ferias vf
WHERE vf.id_usuario = $user ORDER BY vf.data_busca_venda DESC";

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
            <a href="vendaferias.php" class="logout"><span class="material-symbols-outlined">
                    arrow_back
                </span>Voltar para a calculadora</a>
            <img src="system/css/svglogosolides.svg" alt="sólides logo" class="logo" />

        </div>
        <div class="calculadora-container">
            <div class="calculator-titles">
                <h1>Histórico Calculadora de Venda de Férias </h1>
                <p>Visualize todos os calculos realizados oara venda de férias.</p>
            </div>
            <div class="tabelas-historico">
                <?php

                
                foreach ($resultados as $row) {
                    $data = new DateTime($row['data_busca_venda']);
                    echo "<h2>Consulta realizada em " . $data->format('d/m - H:i');
                    echo '<table class="resultado-tabela">';
                    echo '<tr class="cabecalho"><th>Eventos</th><th>Proventos</th><th>Descontos</th></tr>';
                    echo '<tr>';
                    echo '<td>Valor do salário</td><td>R$ ' . number_format($row['valor_salario'], 2, ',', '.') . ' </td><td>-</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>1/3 do salário</td><td>R$ ' . number_format($row['terco_ferias'], 2, ',', '.') . ' </td><td>-</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Abono pecuniário</td><td>R$ ' . number_format($row['abono_pecuniario'], 2, ',', '.') . ' </td><td>-</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>1/3 do abono</td><td>R$ ' . number_format($row['terco_abono'], 2, ',', '.') . ' </td><td>-</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>INSS</td><td>-</td><td>R$' . number_format($row['inss_abono'], 2, ',', '.') . '</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>IRRF</td><td></td>-<td>R$ ' . number_format($row['irrf_abono'], 2, ',', '.') . ' </td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Totais</td><td>R$ ' . number_format($row['salario_com_tercos'], 2, ',', '.') . '</td><td>-</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>Valor líquido a receber</td><td>R$ ' . number_format($row['venda_ferias_liquida'], 2, ',', '.') . ' </td><td>-</td>';
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