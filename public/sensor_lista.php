<?php
session_start();

require_once '../infra/conexao.php';

$mensagem = "";
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);
}

$sql = "SELECT 
            s.id_sensor,
            s.tipo_sensor,
            s.localizacao,
            s.status_sensor,
            s.empresa_operadora,
            s.id_trem,
            t.apelido AS nome_trem,
            t.modelo AS modelo_trem
        FROM Sensor s
        LEFT JOIN Trem t ON s.id_trem = t.id_trem
        ORDER BY s.id_sensor DESC";

$resultado = $conexao->query($sql);
$sensores = [];

if ($resultado) {
    while ($row = $resultado->fetch_assoc()) {
        $sensores[] = $row;
    }
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Sensores - Rail View</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../Assets/css/home.css">
    <link rel="stylesheet" href="../Assets/css/sensor_cadastro.css">
</head>

<body>

    <div class="app-container d-flex">

        <aside class="principal">
            <div>
                <div>
                    <img class="logos" src="../Assets/logos/Logo.png" alt="Logo">
                </div>

                <div id="logos_barra_lateral">
                    <div>
                        <a href="../public/criação_rotas.html">
                            <img class="logos" src="../Assets/logos/icon_rotas.png" alt="Rotas">
                        </a>
                    </div>

                    <div>
                        <a href="../public/home.html">
                            <img class="logos" src="../Assets/logos/icon_trem.png" alt="Trens">
                        </a>
                    </div>

                    <div> 
                        <a href="../public/sensor_cadastro.html">
                            <img class="logos" src="../Assets/logos/icon_sensores.png" alt="Sensores">
                        </a>
                    </div>

                    <div>
                        <a href="../index.html">
                            <img class="logos" src="../Assets/logos/icon_saida.png" alt="Sair">
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <main class="content flex-grow-1 p-4">

            <section class="painel-cadastro">

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                    <h1 class="titulo m-0">Sensores Cadastrados</h1>
                    <a href="sensor_cadastro.php" class="btn btn-dark text-white rounded-pill px-4 py-2">
                         Cadastrar Sensor
                    </a>
                </div>

                <?php if (!empty($mensagem)) echo $mensagem; ?>

                <div class="mb-4">
                    <input type="text" id="campoBusca" class="form-control input-busca" placeholder="🔍 Pesquisar por tipo, localização, operadora ou trem...">
                </div>

                <div id="listaSensores">
                    <?php if (count($sensores) > 0): ?>
                        <div class="row g-3">
                            <?php foreach ($sensores as $sensor): ?>
                                <?php 
                                    $statusClass = 'badge-ativo';
                                    if (mb_strtolower($sensor['status_sensor']) === 'inativo') {
                                        $statusClass = 'badge-inativo';
                                    } elseif (mb_strtolower($sensor['status_sensor']) === 'manutenção' || mb_strtolower($sensor['status_sensor']) === 'manutencao') {
                                        $statusClass = 'badge-manutencao';
                                    }
                                ?>
                                <div class="col-md-6 col-lg-4 item-sensor">
                                    <div class="card-sensor">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <span class="badge badge-status <?= $statusClass ?>">
                                                <?= htmlspecialchars($sensor['status_sensor']) ?>
                                            </span>
                                            <small class="text-muted">ID: #<?= $sensor['id_sensor'] ?></small>
                                        </div>

                                        <div class="mb-2">
                                            <div class="label-campo">Tipo do Sensor</div>
                                            <div class="valor-campo fw-bold"><?= htmlspecialchars($sensor['tipo_sensor']) ?></div>
                                        </div>

                                        <div class="mb-2">
                                            <div class="label-campo">Localização</div>
                                            <div class="valor-campo"><?= htmlspecialchars($sensor['localizacao']) ?></div>
                                        </div>

                                        <div class="mb-2">
                                            <div class="label-campo">Empresa Operadora</div>
                                            <div class="valor-campo"><?= htmlspecialchars($sensor['empresa_operadora']) ?></div>
                                        </div>

                                        <div class="mb-0">
                                            <div class="label-campo">Trem Vinculado</div>
                                            <div class="valor-campo text-warning">
                                                <?= !empty($sensor['nome_trem']) ? htmlspecialchars($sensor['nome_trem']) . ' (' . htmlspecialchars($sensor['modelo_trem']) . ')' : 'Não informado' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info text-center rounded-4 py-4" role="alert">
                            Nenhum sensor cadastrado até o momento. <br>
                            <a href="sensor_cadastro.php" class="alert-link">Clique aqui para cadastrar o primeiro sensor.</a>
                        </div>
                    <?php endif; ?>
                </div>

            </section>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('campoBusca').addEventListener('keyup', function() {
            const termo = this.value.toLowerCase();
            const cards = document.querySelectorAll('.item-sensor');

            cards.forEach(card => {
                const textoCard = card.textContent.toLowerCase();
                if (textoCard.includes(termo)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>