<?php

/* Esse script executa a conexão com o banco de dados, sendo chamado sempre que é
necessário inserir dados no banco de dados, como uma criação de conta, ou enviar os dados da calculadora.
Também é possivel visualizar o histórico dos calculos realizado pelo usuário. */

//dados para conexão com o servidor.
$nome_servidor = "localhost"; 
$usuario = "root";
$senha = "root";
$dbnome = "salario"; 

try {
    $conn = new PDO("mysql:host=$nome_servidor;dbname=$dbnome", $usuario, $senha);
    // define o modo de erro do PDO para exceção
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexão bem sucedida"; 
} catch (PDOException $e) {
    echo "Conexão falhou: " . $e->getMessage();
}
