<?php
// Inicie a sessão

session_start();
// Conecte ao banco de dados
require_once 'conexao.php';
require_once 'funcoes-calc.php';

// Verifique se o usuário está logado
if (isset($_SESSION['user_id'])) {
    // O usuário está logado, redirecione-o para a página calculadora.php
    header('Location: ../calculadora.php');
    exit;
}

function verificarLogin($email, $senha, $conn)
{
    // Busque o usuário no banco de dados
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Verifique se o usuário existe e a senha está correta
    if ($user && password_verify($senha, $user['senha'])) {
        // Armazene o ID do usuário na sessão
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];

        // O usuário está logado, retorne true
        return true;
    } else {
        // O usuário não está logado, retorne false
        return false;
        header('Location: ../login.php');
    }
}


$email = limpar_dados($_POST['email']);
$senha = limpar_dados($_POST['senha']);


if (verificarLogin($email, $senha, $conn)) {
    // O usuário está logado, continue com a lógica da página
    header('Location: ../home.php');
} else {
    // O usuário não está logado, redirecione-o para a página de login
    echo "Senha incorreta!";
}

?>
