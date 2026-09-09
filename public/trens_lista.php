<?php
session_start();

require_once '../infra/conexao.php';

$trens = [];

$sql = "SELECT id_trem, modelo, apelido, empresa_operadora, tipo_trem, numero_vagoes FROM Trem ORDER BY id_trem DESC";
$resultado = $conexao->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $trens[] = $row;
    }
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Trens</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="../assets/css/cadastro_trem.css">
    <link rel="stylesheet" href="../assets/css/home.css">
</head>

<body>

    <div class="app-container">

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

        <main class="content">

            <section class="painel-cadastro">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="titulo m-0">Trens Cadastrados</h1>
                    <a href="trens_cadastro.php" class="btn btn-dark text-white rounded-pill px-4 py-2">
                        + Cadastrar Novo
                    </a>
                </div>

                <?php 
                if (isset($_SESSION['mensagem'])) {
                    echo $_SESSION['mensagem'];
                    unset($_SESSION['mensagem']);
                }
                ?>

                <div class="table-responsive rounded-4 shadow-sm">
                    <table class="table table-hover align-middle m-0 text-center custom-table">
                        <thead>
                            <tr>
                                <th>Modelo</th>
                                <th>Apelido</th>
                                <th>Operadora</th>
                                <th>Tipo</th>
                                <th>Vagões</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($trens)): ?>
                                <?php foreach ($trens as $trem): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($trem['modelo']) ?></td>
                                        <td><?= htmlspecialchars($trem['apelido']) ?></td>
                                        <td><?= htmlspecialchars($trem['empresa_operadora']) ?></td>
                                        <td><span class="badge bg-secondary"><?= htmlspecialchars($trem['tipo_trem']) ?></span></td>
                                        <td><?= htmlspecialchars($trem['numero_vagoes']) ?></td>
                                        <td>
                                            <a href="trens_editar.php?id=<?= $trem['id_trem'] ?>" class="btn btn-warning btn-sm text-white me-1 rounded-3" title="Editar">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            
                                            <a href="trens_excluir.php?id=<?= $trem['id_trem'] ?>" class="btn btn-danger btn-sm rounded-3" onclick="return confirm('Tem certeza que deseja excluir este trem?');" title="Excluir">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-muted py-4">Nenhum trem cadastrado até o momento.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </section>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>