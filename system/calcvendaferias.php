<?php
session_start(); // Iniciar a sessão

require 'funcoes-calc.php';
require 'conexao.php';

if (!isset($_SESSION['user_id'])) {
    // O usuário está logado, redirecione-o para a página calculadora.php
    header('Location: ../login.php');
    exit;
}

//aqui colocaremos os valores do formulário nas variaveis;
$id_usuario = $_SESSION['user_id']; // Recuperar o id do usuário da sessão
$salario = $_POST['valor'];

list($salario, $terco_ferias, $salario_ferias_inss, $abono_pecuniario, $terco_abono, $salario_com_tercos, $inss_abono, $irrf_abono, $venda_ferias_liquida) = calcular_venda_ferias($salario);


// consulta SQL para enviar os dados retornados da função calcular_ferias;
$sql = "INSERT INTO venda_ferias (id_usuario, valor_salario, terco_ferias, salario_ferias_inss, abono_pecuniario, terco_abono, salario_com_tercos, inss_abono, irrf_abono, venda_ferias_liquida, data_busca_venda) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// essa variavel armazena a data atual da inserção, para adicionar ao banco de dados.
$data_busca = date('Y-m-d H:i:s');

$descontos_totais = $inss_abono + $irrf_abono;


// envia os dados da consulta SQL ao banco de dados.
try {
  $stmt->execute([$id_usuario, $salario, $terco_ferias, $salario_ferias_inss, $abono_pecuniario, $terco_abono, $salario_com_tercos, $inss_abono, $irrf_abono, $venda_ferias_liquida, $data_busca]);

} catch (PDOException $e) {
  echo "Erro ao inserir os dados: " . $e->getMessage();
}

echo'
<h2 class="calculator-titles">Resultado</h2>
<table class="resultado-tabela">
<tr class="cabecalho">
  <th>Eventos</th>
  <th>Proventos</th>
  <th>Descontos</th>
</tr>
<tr>
  <td>Valor das férias</td>
  <td>R$ '. number_format($salario, 2, ',', '.') .' </td>
  <td>-</td>
</tr>
<tr>
  <td>1/3 do salário</td>
  <td>R$ '. number_format($terco_ferias, 2, ',', '.') .' </td>
  <td>-</td>
</tr>
<tr>
  <td>Abono pecuniário</td>
  <td>R$ '. number_format($abono_pecuniario, 2, ',', '.') .' </td>
  <td>-</td>
  
</tr>
<tr>
  <td>1/3 Abono pecuniário</td>
  <td>R$ '. number_format($terco_abono, 2, ',', '.') .' </td>
  <td>-</td>
  
</tr>
<tr>
  <td>INSS</td>
  <td>-</td>
  <td>R$ '. number_format($inss_abono, 2, ',', '.') .' </td>
</tr>
<tr>
  <td>IRRF</td>
  <td>-</td>
  <td>R$ '. number_format($irrf_abono, 2, ',', '.') .' </td>
</tr>
<tr>
  <td>Totais</td>
  <td>R$ '. number_format($salario_com_tercos, 2, ',', '.') .' </td>
  <td>R$ '. number_format($descontos_totais, 2, ',', '.') .' </td>
</tr>
<tr>
  <td>Valor líquido a receber</td>
  <td>R$ '.  number_format($venda_ferias_liquida, 2, ',', '.') . '</td>
  <td>-</td>
</tr>
</table>';



?>
