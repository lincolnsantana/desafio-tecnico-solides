<?php

/*Esse script, todas as funções principais do sistema. Aqui tem funções que leem APIs, que calculam o INSS e IRRF, 
e realizam os calculos referente aos diversos modos de férias.*/


/* essa função é utilizada para limpar as strings que são passadas pelos usuários*/
function limpar_dados($data)
{
    $data = trim($data); //remover espaços em brancos
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


/*Essa função calcula o número de dias úteis entre duas datas, considerando os feriados nacionais do Brasil. 
Ela recebe como parâmetros as datas de início e fim do intervalo, e retorna o número de dias úteis.
Essa função leva em consideração o sabado e domingo como dias não úteis.*/
function calcular_dias_uteis($dataInicio, $dataFim)
{

    // URL da API
    $url = "https://brasilapi.com.br/api/feriados/v1/2024";
    // Inicializa o cURL
    $ch = curl_init();
    // Define a URL da API
    curl_setopt($ch, CURLOPT_URL, $url);
    // Define que o resultado seja retornado em vez de exibido
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // Executa a chamada da API
    $resultado = curl_exec($ch);
    // Fecha a sessão cURL
    curl_close($ch);

    // Decodificação da resposta JSON para um objeto PHP
    $dados = json_decode($resultado);

    //esse array armazena toodos os feriados do ano
    $feriados = array();
    // Acessando os dados do objeto JSON e armazenando no array
    foreach ($dados as $dado) {
        $feriados[] = $dado->date;
    }

    // Esse array vai amarzenar somente os DIAS ÚTEIS do intervalo de dias que o usuario colocou.
    $arrayDatas = array();
    // Variável que contará quantos dias uteis tem no intervalo.
    $diasUteis = 0;
    $dataFim = new DateTime($dataFim);
    $dataFim->modify('+1 day'); // Adiciona um dia à data final, pois o dateTime não conta o último dia.

    // Criação do período de datas
    $periodo = new DatePeriod(
        new DateTime($dataInicio),
        new DateInterval('P1D'),
        $dataFim
    );

    // Preenchimento do array com as datas do período
    foreach ($periodo as $data) {
        $arrayDatas[] = $data->format('Y-m-d');
    }

    // esse foreach vai verificar cada dia do array diaDaSemana, e verificar quais dias que são feriados.
    foreach ($arrayDatas as $data) {
        $diaDaSemana = date('w', strtotime($data));

        /* Esses dois ifs aninhados verificam somente os dias uteis, excluindo o domingo e os feriados.
         a variavel $diasUteis amazena somente os dias uteis. */
        if ($diaDaSemana != 0 && $diaDaSemana != 6) {

            if (!in_array($data, $feriados)) {
                //echo "$data \n";
                $diasUteis++;
            }
        }
    }

    return $diasUteis;
}

/*Essa função recebe como parâmetro o salário bruto e retorna o valor do desconto. A função usa um array que contém as faixas de salário e as alíquotas correspondentes. 
Ela percorre esse array com um laço foreach e vai subtraindo o valor da faixa do salário restante, multiplicando pelo percentual da alíquota e somando ao valor do INSS. 
A função faz isso até que o salário restante seja zero ou menor que zero, e então retorna o valor do INSS. */
function calcular_inss($salario)
{
    $faixas = array(
        array('ate' => 1412.00, 'aliquota' => 0.075),
        array('ate' => 2666.68, 'aliquota' => 0.09),
        array('ate' => 4000.03, 'aliquota' => 0.12),
        array('ate' => 7786.02, 'aliquota' => 0.14)
    );

    $inss = 0;
    $salario_restante = $salario;

    foreach ($faixas as $i => $faixa) {
        if ($i == 0) {
            $valor_faixa = min($faixa['ate'], $salario_restante);
        } else {
            $valor_faixa = min($faixa['ate'] - $faixas[$i - 1]['ate'], $salario_restante);
        }

        $inss += $valor_faixa * $faixa['aliquota'];
        $salario_restante -= $valor_faixa;

        if ($salario_restante <= 0) {
            break;
        }
    }

    return $inss;
}

/* Essa função calcula o valor do IRRF (Imposto de Renda Retido na Fonte) que deve ser descontado do salário de um trabalhador. 
Ela recebe como parâmetros o salário bruto e o valor do INSS, e retorna o valor do imposto. */
function calcular_irrf($salario, $inss)
{
    $base_calculo = $salario - $inss;
    $aliquota = 0;
    $deducao = 0;

    if ($salario <= 2259.20) {
        $aliquota = 0;
        $deducao = 0;
    } else if ($salario <= 2828.65) {
        $aliquota = 0.075;
        $deducao = 169.44;
    } else if ($salario <= 3751.05) {
        $aliquota = 0.15;
        $deducao = 381.44;
    } else if ($salario <= 4664.68) {
        $aliquota = 0.225;
        $deducao = 662.77;
    } else {
        $aliquota = 0.275;
        $deducao = 896.00;
    }

    $irrf = ($base_calculo * $aliquota) - $deducao;

    return $irrf;
}


/* 
Essa função calcula o valor das férias de um trabalhador, considerando o salário bruto, a quantidade de dias de férias, o valor do INSS e do IRRF. 
Nessa função os parâmetros inseridos são o salário bruto e a quantidade de dias de férias, e então retorna um array com o salário, quantidade de dias
o salário de férias, o terço de férias, o valor do salário com terço, inss, irrf e o valor liquido do salário de férias. */

function calcular_ferias($salario, $quantidade_dias)
{
    // calcula o valor bruto das férias
    $salario_ferias = ($salario / 30) * $quantidade_dias;
    $terco = $salario_ferias / 3;

    $valor_com_terco = $salario_ferias + $terco;

    $inss = calcular_inss($valor_com_terco);
    $irrf = calcular_irrf($valor_com_terco, $inss);
    // calcula o valor liquido das férias

    $valor_liquido = $valor_com_terco - $inss - $irrf;

    //retorna o valor total das férias
    return array($salario, $quantidade_dias, $salario_ferias, $terco, $valor_com_terco,  $inss, $irrf, $valor_liquido);
}


/*Essa função calcula somente as ferias proporcionais, que leva em consideração os meses trabalhados pelo usuario e tem um limite máximo de 12 meses trabalhados.*/

function calcular_ferias_proporcionais($salario, $meses_trabalhados)
{
    $ferias_proporcionais = ($salario * $meses_trabalhados) / 12;
    $terco_ferias = $ferias_proporcionais / 3;
    $ferias_com_terco = $ferias_proporcionais + $terco_ferias;

    // Descontos
    $inss_ferias = calcular_inss($ferias_com_terco);
    $irrf_ferias = calcular_irrf($ferias_com_terco, $inss_ferias);

    $ferias_liquidas = $ferias_com_terco  - $inss_ferias - $irrf_ferias;

    // Calcula a quantidade de dias de férias proporcionais
    $dias_de_ferias = ($meses_trabalhados * 30) / 12;

    return array($salario, $meses_trabalhados, $ferias_proporcionais,  $terco_ferias, $ferias_com_terco, $inss_ferias, $irrf_ferias, $ferias_liquidas, $dias_de_ferias);
}

function calcular_venda_ferias($salario)
{
    // calcula o valor bruto das férias
    $terco_ferias = $salario / 3;
    $salario_ferias_inss = $salario + $terco_ferias; //usa o salario + o 1/3 para calculo do inss
    $abono_pecuniario = $terco_ferias;
    $terco_abono = $abono_pecuniario / 3;
    $salario_com_tercos = $salario + $terco_ferias + $abono_pecuniario + $terco_abono;
    $inss_abono = calcular_inss($salario_ferias_inss);
    $irrf_abono = calcular_irrf($salario_ferias_inss, $inss_abono);

    // calcula o valor total da venda de férias
    $venda_ferias_liquida = $salario_com_tercos - $inss_abono - $irrf_abono;

    // Retornando as variaveis referentes ao calculo da venda de ferias.
    return array($salario, $terco_ferias, $salario_ferias_inss, $abono_pecuniario, $terco_abono, $salario_com_tercos, $inss_abono, $irrf_abono, $venda_ferias_liquida);
}
