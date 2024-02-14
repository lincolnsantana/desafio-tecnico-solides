<?php
session_start();

require 'funcoes-calc.php';
require 'conexao.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: ../login.php');
  exit;
}

//aqui colocaremos os valores do formulário nas variaveis;
$id_usuario = $_SESSION['user_id']; // Recuperar o id do usuário da sessão
$salario = $_POST['valor'];
$dataInicio = $_POST['datainicio'];
$dataFim = $_POST['datafim'];

//aqui o script verifica as datas inseridas. caso tenha colocado a data inicio maior que a data fim, o script envia uma mensagem. 
if (strtotime($dataInicio) > strtotime($dataFim)) {
  echo "A data inicio não pode ser maior que a data final! \n";
} else {
  $dias_uteis = calcular_dias_uteis($dataInicio, $dataFim); // retorna quantidade de dias uteis com base na api dentro da função que busca os feriados nacionais.


  list($salario, $quantidade_dias, $salario_ferias, $terco, $valor_com_terco,  $inss, $irrf, $valor_liquido) = calcular_ferias($salario, $dias_uteis);

  $descontos_totais = $inss + $irrf;

  // consulta SQL para enviar os dados retornados da função calcular_ferias;
  $sql = "INSERT INTO ferias_contando_dias_uteis (id_usuario, valor_salario, salario_ferias, terco, valor_com_terco, inss, irrf,
valor_liquido, data_inicio, data_final, quantidade_dias, data_busca_ferias) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);

  // essa variavel armazena a data atual da inserção, para adicionar ao banco de dados.
  $data_busca = date('Y-m-d H:i:s');
  // envia os dados da consulta SQL ao banco de dados.
  try {
    $stmt->execute([$id_usuario, $salario, $salario_ferias, $terco, $valor_com_terco, $inss, $irrf, $valor_liquido, $dataInicio, $dataFim, $quantidade_dias, $data_busca]);
  } catch (PDOException $e) {
    echo "Erro ao inserir os dados: " . $e->getMessage();
  }


  echo '
    <h2 class="calculator-titles">Resultado</h2>
    <table class="resultado-tabela">
<tr class="cabecalho">
  <th>Eventos</th>
  <th>Proventos</th>
  <th>Descontos</th>
</tr>
<tr>
  <td>Valor das férias</td>
  <td>R$ ' . number_format($salario, 2, ',', '.') . ' </td>
  <td>-</td>
</tr>
<tr>
  <td>1/3 do salário</td>
  <td>R$ ' . number_format($terco, 2, ',', '.') . ' </td>
  <td>-</td>
</tr>
<tr>
  <td>INSS</td>
  <td>-</td>
  <td>R$ ' . number_format($inss, 2, ',', '.') . ' </td>
</tr>
<tr>
  <td>IRRF</td>
  <td>-</td>
  <td>R$ ' . number_format($irrf, 2, ',', '.') . ' </td>
</tr>
<tr>
  <td>Totais</td>
  <td>R$ ' . number_format($valor_com_terco, 2, ',', '.') . ' </td>
  <td>R$ ' . number_format($descontos_totais, 2, ',', '.') . ' </td>
</tr>
<tr>
  <td>Valor líquido a receber</td>
  <td>R$ ' .  number_format($valor_liquido, 2, ',', '.') . '</td>
  <td>-</td>
</tr>
</table>';
}
