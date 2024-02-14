<?php
require_once 'conexao.php';
require_once 'funcoes-calc.php';


// Se o usuário não estiver cadastrado, continue com o cadastro
$nome = limpar_dados($_POST['nome']);
$sobrenome = limpar_dados($_POST['sobrenome']);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$email = limpar_dados($email);
$senha = $_POST['senha'];
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);
$conta_verificada = false;


$stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

// Verifique se o usuário existe e a senha eixstem no banco.
if ($user && password_verify($senha, $user['senha'])) {


    echo "essa conta já existe!";
} else {
    // O usuário não está logado, redirecione-o para a página de login
    $sql = "INSERT INTO usuario (nome, sobrenome, email, senha, conta_verificada) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nome, $sobrenome, $email, $senha_hash, $conta_verificada]);
    header('Location: ../login.php');
}
