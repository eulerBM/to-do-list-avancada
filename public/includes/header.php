<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu to-do list PHP</title>

  <!-- Bootstrap e CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
      <a class="navbar-brand" href="index.php">MeuSite</a>

      <div>
        <?php if (isset($_SESSION['user'])): ?>
          <!-- Se estiver logado -->
          <span class="text-light me-3">Olá, <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Usuário') ?>!</span>
          <a href="/logout" class="btn btn-outline-danger btn-sm">Logout</a>
        <?php else: ?>
          <!-- Se não estiver logado -->
          <a href="/login" class="btn btn-outline-light btn-sm">Login</a>
          <a href="/register" class="btn btn-outline-light btn-sm ms-2">Registrar</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</body>
</html>
