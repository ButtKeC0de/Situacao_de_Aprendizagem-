<?php
$paginaAtual = basename($_SERVER['PHP_SELF']);
$ativoRotas = str_starts_with($paginaAtual, 'criacao_rotas') ? 'ativo' : '';
$ativoTrens = str_starts_with($paginaAtual, 'trens_') ? 'ativo' : '';
$ativoSensores = str_starts_with($paginaAtual, 'sensor_') ? 'ativo' : '';
?>
<aside class="sidebar">
    <a class="sidebar-logo" href="home.php" title="Início">
        <img src="../Assets/logos/Logo.png" alt="Rail View">
    </a>

    <nav class="sidebar-nav">
        <a href="criacao_rotas.php" title="Rotas" class="<?= $ativoRotas ?>">
            <img src="../Assets/logos/icon_rotas.png" alt="Rotas">
        </a>
        <a href="trens_home.php" title="Trens" class="<?= $ativoTrens ?>">
            <img src="../Assets/logos/icon_trem.png" alt="Trens">
        </a>
        <a href="sensor_home.php" title="Sensores" class="<?= $ativoSensores ?>">
            <img src="../Assets/logos/icon_sensores.png" alt="Sensores">
        </a>
    </nav>

    <div class="sidebar-logout">
        <a href="../index.html" title="Sair">
            <img src="../Assets/logos/icon_saida.png" alt="Sair">
        </a>
    </div>
</aside>
