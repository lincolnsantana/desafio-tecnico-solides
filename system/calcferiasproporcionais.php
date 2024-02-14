<?php
session_start(); 

require 'funcoes-calc.php';
require 'conexao.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

//aqui colocaremos os valores do formulário nas variaveis;
$id_usuario = $_SESSION['user_id']; 
$salario = $_POST['valor'];
$meses_trabalhados = $_POST['mesestrabalhados'];

list($salario, $meses_trabalhados, $ferias_proporcionais, $terco_ferias, $ferias_com_terco, $inss_ferias, $irrf_ferias, $ferias_liquidas, $dias_de_ferias) = calcular_ferias_proporcionais($salario, $meses_trabalhados);


// consulta SQL para enviar os dados retornados da função calcular_ferias_proporcionais;
$sql = "INSERT INTO ferias_proporcionais (id_usuario, valor_salario, meses_trabalhados, ferias_proporcionais, terco_ferias, valor_bruto_ferias, inss_ferias, irrf_ferias, ferias_liquida, quantidade_dias, data_busca_proporcionais) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// essa variavel armazena a data atual da inserção, para adicionar ao banco de dados.
$data_busca = date('Y-m-d H:i:s');

// envia os dados da consulta SQL ao banco de dados.
try {
  $stmt->execute([$id_usuario, $salario, $meses_trabalhados, $ferias_proporcionais, $terco_ferias, $ferias_com_terco, $inss_ferias, $irrf_ferias, $ferias_liquidas, $dias_de_ferias, $data_busca]);
} catch (PDOException $e) {
  echo "Erro ao inserir os dados: " . $e->getMessage();
}
//retorna os dados mostrando ao usuário em uma tabela

echo '
    <h2 class="calculator-titles">Resultado</h2>
    <table class="resultado-tabela">
<tr class="cabecalho">
  <th>Eventos</th>
  <th>Valor</th>
  
</tr>
<tr>
  <td>Número de dias de férias</td>
  <td>' . $dias_de_ferias . ' </td>
  
</tr>
<tr>
  <td>Valor férias proporcionais</td>
  <td>R$ ' . number_format($ferias_proporcionais, 2, ',', '.') . ' </td>
</tr>
<tr>
  <td>1/3 de férias</td>
  <td>R$ ' . number_format($terco_ferias, 2, ',', '.') . ' </td>
</tr>
<tr>
  <td>Valor total das férias proporcionais:</td>
  <td>R$ ' . number_format($ferias_com_terco, 2, ',', '.') . ' </td>
</tr>

</table>';


?>
