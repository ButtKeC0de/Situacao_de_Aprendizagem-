<?php
require_once '../infra/auth.php';
exigir_login();
?>
<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rail View</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Changa+One:ital@0;1&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../Assets/css/home.css">
</head>

<body>
<header class="navbar">    
  <nav class="nav-links w-100">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4">
      
      <a class="navbar-brand d-flex align-items-center text-dark fw-bold" href="#">
        <img src="../Assets/logos/Logo.png" alt="Logo" class="Logo_1 me-2">
        <span>Quem somos</span>
      </a>

      <div class="menu-icones d-flex align-items-center gap-3">
        <a href="../public/criacao_rotas.php"><img class="logos" src="../Assets/logos/icon_rotas.png" alt="Rotas"></a>
        <a href="../public/trens_home.php"><img class="logos" src="../Assets/logos/icon_trem.png" alt="Trens"></a>
        <a href="../public/sensor_home.php"><img class="logos" src="../Assets/logos/icon_sensores.png" alt="Sensores"></a>
        <a href="../public/logout.php"><img class="logos" src="../Assets/logos/icon_saida.png" alt="Sair"></a>
      </div>

    </div>
  </nav>
</header>

  <main>
    <div class="vid_1">
      <video id="video_inicial" src="../Assets/videos/trem_telainicial.mp4" autoplay loop muted playsinline></video>
    </div>

    

  <footer>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>