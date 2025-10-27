<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To-do list avançada</title>

  <link rel="stylesheet" href="../css/includes/header.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <span class="red">To-do</span> list avançada
      </a>

      <div class="d-flex align-items-center">

        <?php if (isset($_SESSION['user'])): ?>

          <span class="text-light me-3"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Usuário') ?></span>
          <a href="/logout" class="btn btn-outline-danger btn-sm">sair</a>

        <?php else: ?>

          <a href="/login" class="nav-link me-3">Entrar</a>

          <a href="/register" class="nav-link me-3">Cadastrar</a>

        <?php endif; ?>
      </div>
    </div>
  </nav>
</body>
</html>
