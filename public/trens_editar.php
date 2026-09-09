<?php
session_start();

require_once '../infra/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$mensagem = "";

if (!$id) {
    $_SESSION['mensagem'] = "<div class='alert alert-danger'>ID inválido ou não informado.</div>";
    header("Location: trens_lista.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo    = $_POST['modelo'] ?? '';
    $apelido   = $_POST['apelido'] ?? '';
    $operadora = $_POST['operadora'] ?? '';
    $tipo      = $_POST['tipo'] ?? '';
    $vagoes    = $_POST['vagoes'] ?? '';

    if (!empty($modelo) && !empty($apelido) && !empty($tipo) && !empty($vagoes)) {
        
        $sql_update = "UPDATE Trem 
                       SET modelo = ?, apelido = ?, tipo_trem = ?, empresa_operadora = ?, numero_vagoes = ? 
                       WHERE id_trem = ?";
        
        $stmt_update = $conexao->prepare($sql_update);

        if ($stmt_update) {
            $stmt_update->bind_param("ssssii", $modelo, $apelido, $tipo, $operadora, $vagoes, $id);

            if ($stmt_update->execute()) {
                $_SESSION['mensagem'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                            Trem '<strong>{$apelido}</strong>' atualizado com sucesso!
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>";
                header("Location: trens_lista.php");
                exit();
            } else {
                $mensagem = "<div class='alert alert-danger'>Erro ao atualizar no banco: " . $stmt_update->error . "</div>";
            }
            $stmt_update->close();
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro na preparação da consulta: " . $conexao->error . "</div>";
        }

    } else {
        $mensagem = "<div class='alert alert-danger'>Preencha todos os campos obrigatórios.</div>";
    }
}

$sql_select = "SELECT id_trem, modelo, apelido, empresa_operadora AS operadora, tipo_trem AS tipo, numero_vagoes AS vagoes FROM Trem WHERE id_trem = ?";
$stmt_select = $conexao->prepare($sql_select);
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$resultado = $stmt_select->get_result();

if ($resultado && $resultado->num_rows > 0) {
    $dados_trem = $resultado->fetch_assoc();
} else {
    $_SESSION['mensagem'] = "<div class='alert alert-warning'>Trem não encontrado.</div>";
    header("Location: trens_lista.php");
    exit();
}
$stmt_select->close();
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Trem</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
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
                    <h1 class="titulo m-0">Editar Trem</h1>
                    <a href="trens_lista.php" class="btn btn-dark text-white rounded-pill px-4 py-2">
                        ← Voltar para Lista
                    </a>
                </div>

                <?php if (!empty($mensagem)) echo $mensagem; ?>

                <form action="" method="POST">
                    <div class="row g-4 align-items-center">

                        <div class="col-lg-8">

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="modelo">Modelo do trem</label>
                                        <input type="text" id="modelo" name="modelo" value="<?= htmlspecialchars($dados_trem['modelo']) ?>" placeholder="Coloque o modelo" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="apelido">Digite o apelido do trem</label>
                                        <input type="text" id="apelido" name="apelido" value="<?= htmlspecialchars($dados_trem['apelido']) ?>" placeholder="Coloque o apelido" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="operadora">Empresa operadora</label>
                                        <input type="text" id="operadora" name="operadora" value="<?= htmlspecialchars($dados_trem['operadora']) ?>" placeholder="Coloque a operadora">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="tipo">Tipo do trem</label>
                                        <input type="text" id="tipo" name="tipo" value="<?= htmlspecialchars($dados_trem['tipo']) ?>" placeholder="Coloque o tipo" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="card-input">
                                        <label for="vagoes">Número de vagões</label>
                                        <input type="number" id="vagoes" name="vagoes" value="<?= htmlspecialchars($dados_trem['vagoes']) ?>" placeholder="Coloque o número" min="1" required>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-lg-4 d-flex justify-content-center align-items-center">

                            <div class="botao-container">
                                <button type="submit" class="btn-enviar">
                                    Salvar
                                </button>
                            </div>

                        </div>

                    </div>
                </form>

            </section>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>