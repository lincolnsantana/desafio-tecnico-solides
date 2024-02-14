<?php
// Inicie a sessão
session_start();

// Verifique se o usuário está logado

if (!isset($_SESSION['user_id'])) {
    // O usuário não está logado, redirecione-o para a página de login
    header('Location: login.php');
    exit;
} 

$pagina = $_POST['pagina'];
header("Location: $pagina");

?>