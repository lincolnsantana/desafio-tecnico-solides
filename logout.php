<?php
// Inicie a sessão
session_start();
// Destrua a sessão para fazer logout
session_destroy();
// Redirecione o usuário para a página de login
header('Location: login.php');
exit;
?>
