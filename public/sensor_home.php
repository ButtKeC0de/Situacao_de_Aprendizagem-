<?php

session_start();

require_once "../infra/conexao.php";

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
    <link rel="stylesheet" href="../Assets/css/home.css">
</head>

<body>

<div class="tela">

    <div class="principal">

        <div>

            <div>
                <img class="logos"src="../Assets/logos/Logo.png"alt="Logo"> </div>

            <div id="logos_barra_lateral">
                <div>
                    <a href="../public/criacao_rotas.html"><img class="logos" src="../Assets/logos/icon_rotas.png" alt="Rotas"> </a>
                </div>
                <div>
                    <a href="../public/home.php"><img class="logos"src="../Assets/logos/icon_trem.png" alt="Trens" ></a>
                </div>
                <div>
                    <a href="../public/sensor_home.php"><img class="logos" src="../Assets/logos/icon_sensores.png" alt="Sensores"></a>
                </div>
                <div>
                    <a href="../index.html"><img class="logos"src="../Assets/logos/icon_saida.png" alt="Sair"></a>
                </div>
            </div>

        </div>

    </div>

    <div class="conteudo">

        <div class="topo">

            <h1 class="titulo_home"> Sensores cadastrados </h1>

            <div class="usuario">

                <div class="foto_usuario">
                    <i class="bi bi-person-fill"></i>
                </div>

                <span class="nome_usuario">admin_007</span>

            </div>

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

                <form action="sensor_editar.php" method="get">
                    <button type="submit"class="botao_laranja"> Editar</button>
                </form>

            </div>

            <div class="card_acao">

                <h2>
                    Excluir sensor
                </h2>

                <form action="sensor_excluir.php" method="get">
                    <button type="submit" class="botao_laranja">Excluir </button>
                </form>

            </div>

            <div class="card_mapa">

                <iframe src="https://www.openstreetmap.org/export/embed.html?bbox=-49.42%2C-25.62%2C-49.16%2C-25.36&layer=mapnik" title="Mapa"></iframe>

            </div>

        </div>

    </div>

</div>

<script src="../scripts/sensor_home.js?v=1"></script>

</body>

</html>