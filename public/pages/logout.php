<?php
session_start();

session_destroy();

// Redireciona para a página de login
header("Location: /login");
exit;
?>
