<?php

require_once '../infra/auth.php';
exigir_login();


$sql = "SELECT * FROM Sensor ORDER BY id_sensor DESC";
$resultado = $conexao->query($sql);

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sensores Cadastrados</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/css/painel.css">
    <link rel="stylesheet" href="../Assets/css/sidebar.css">
</head>

<body>

<div class="tela">

    <?php require '../infra/sidebar.php'; ?>

    <div class="conteudo">

        <div class="topo">

            <h1 class="titulo_home"> Sensores cadastrados </h1>

            <a class="usuario text-decoration-none" href="Perfil.php" title="Meu perfil">

                <div class="foto_usuario">
                    <i class="bi bi-person-fill"></i>
                </div>

                <span class="nome_usuario"><?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'Entrar') ?></span>

            </a>

        </div>

        <div class="busca">
            <i class="bi bi-search"></i>
            <input id="pesquisa"type="search"placeholder="ID do sensor"autocomplete="off">
        </div>

        <?php if (isset($_SESSION['mensagem'])): ?>

            <?= $_SESSION['mensagem']; ?>

            <?php unset($_SESSION['mensagem']); ?>

        <?php endif; ?>

        <div id="trens">

            <?php if ($resultado && $resultado->num_rows > 0): ?>

                <?php while ($sensor = $resultado->fetch_assoc()): ?>

                    <div class="trem sensor" data-id="<?= (int)$sensor['id_sensor'] ?>" >

                        <img src="../Assets/logos/icon_sensores.png"alt="Sensor" >
                        <p>ID:<?= (int)$sensor['id_sensor'] ?></p>
                        <p> <?= htmlspecialchars($sensor['localizacao'],ENT_QUOTES, 'UTF-8' ) ?></p>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <p style="grid-column: 1 / -1; text-align: center;"> Nenhum sensor cadastrado. </p>

            <?php endif; ?>

        </div>

        <div class="parte_baixo_home">

            <?php if (eh_admin()): ?>

            <div class="card_acao">

                <h2>
                    Cadastrar sensor
                </h2>

                <form action="sensor_cadastro.php" method="get">
                    <button type="submit" class="botao_laranja"> Cadastrar</button>
                </form>

            </div>

            <div class="card_acao">

                <h2>
                    Editar sensor
                </h2>

                <form action="sensor_lista.php" method="get">
                    <button type="submit"class="botao_laranja"> Editar</button>
                </form>

            </div>

            <div class="card_acao">

                <h2>
                    Excluir sensor
                </h2>

                <form action="sensor_lista.php" method="get">
                    <button type="submit" class="botao_laranja">Excluir </button>
                </form>

            </div>

            <?php else: ?>

            <div class="card_acao">

                <h2>
                    Consultar sensores
                </h2>

                <form action="sensor_lista.php" method="get">
                    <button type="submit" class="botao_laranja"> Ver lista </button>
                </form>

            </div>

            <?php endif; ?>

            <div class="card_mapa">

                <iframe src="https://www.openstreetmap.org/export/embed.html?bbox=-49.42%2C-25.62%2C-49.16%2C-25.36&layer=mapnik" title="Mapa"></iframe>

            </div>

        </div>

    </div>

</div>

<script src="../scripts/sensor_home.js?v=1"></script>

</body>

</html>