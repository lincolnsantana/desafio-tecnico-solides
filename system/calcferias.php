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
$quantidade_dias = $_POST['quantidade_dias'];

//essa parte chama a função limpa_dados que tira os espaços em brancos e deixa as informações livres de ataques.
$salario = limpar_dados($salario);
$quantidade_dias = limpar_dados($quantidade_dias);
$quantidade_dias = intval($quantidade_dias);

list($salario, $quantidade_dias, $salario_ferias, $terco, $valor_com_terco,  $inss, $irrf, $valor_liquido) = calcular_ferias($salario, $quantidade_dias);


// consulta SQL para enviar os dados ao banco com base nos valores retornados da função calcular_ferias.
$sql = "INSERT INTO ferias_dados (id_usuario, valor_salario, quantidade_dias, salario_ferias, terco, valor_com_terco, inss, irrf, valor_liquido, data_busca) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Obter a data atual para adicionar junto as outras informações
$data_busca = date('Y-m-d H:i:s');

// Enviando os dados da consulta SQL ao banco.
try {
  $stmt->execute([$id_usuario, $salario, $quantidade_dias, $salario_ferias, $terco, $valor_com_terco, $inss, $irrf, $valor_liquido, $data_busca]);
} catch (PDOException $e) {
  echo "Erro ao inserir os dados: " . $e->getMessage();
}

$descontos_totais = $inss + $irrf;


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
  <td>R$ '. number_format($terco, 2, ',', '.') .' </td>
  <td>-</td>
</tr>
<tr>
  <td>INSS</td>
  <td>-</td>
  <td>R$ '. number_format($inss, 2, ',', '.') .' </td>
</tr>
<tr>
  <td>IRRF</td>
  <td>-</td>
  <td>R$ '. number_format($irrf, 2, ',', '.') .' </td>
</tr>
<tr>
  <td>Totais</td>
  <td>R$ '. number_format($valor_com_terco, 2, ',', '.') .' </td>
  <td>R$ '. number_format($descontos_totais, 2, ',', '.') .' </td>
</tr>
<tr>
  <td>Valor líquido a receber</td>
  <td>R$ '.  number_format($valor_liquido, 2, ',', '.') . '</td>
  <td>-</td>
</tr>
</table>';


?>