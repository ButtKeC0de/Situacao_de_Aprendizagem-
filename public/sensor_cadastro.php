<?php
session_start();

require_once '../infra/conexao.php'; 

$mensagem = "";

$trens = [];
$resultTrens = $conexao->query("SELECT id_trem, apelido, modelo FROM Trem ORDER BY apelido ASC");
if ($resultTrens) {
    while ($row = $resultTrens->fetch_assoc()) {
        $trens[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo_sensor       = $_POST['tipo_sensor'] ?? '';
    $localizacao       = $_POST['localizacao'] ?? '';
    $empresa_operadora = $_POST['empresa_operadora'] ?? '';
    $status_sensor     = $_POST['status_sensor'] ?? 'Ativo';
    $id_trem           = $_POST['id_trem'] ?? '';

    if (!empty($tipo_sensor) && !empty($localizacao) && !empty($empresa_operadora) && !empty($id_trem)) {
        
        $sql = "INSERT INTO Sensor (tipo_sensor, localizacao, status_sensor, empresa_operadora, id_trem) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssi", $tipo_sensor, $localizacao, $status_sensor, $empresa_operadora, $id_trem);

            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                            Sensor '<strong>{$tipo_sensor}</strong>' cadastrado com sucesso!
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>";

                header("Location: sensor_lista.php");
                exit();
            } else {
                $mensagem = "<div class='alert alert-danger'>Erro ao cadastrar: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            $mensagem = "<div class='alert alert-danger'>Erro na preparação da consulta: " . $conexao->error . "</div>";
        }

    } else {
        $mensagem = "<div class='alert alert-danger'>Por favor, preencha todos os campos obrigatórios.</div>";
    }
}
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Sensor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../Assets/css/sensor_cadastro.css">
    <link rel="stylesheet" href="../Assets/css/home.css">
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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="titulo m-0">Cadastrar sensor</h1>
                    <a href="sensor_lista.php" class="btn btn-dark text-white rounded-pill px-4 py-2">
                        ← Ver Lista
                    </a>
                </div>

                <?php if (!empty($mensagem)) echo $mensagem; ?>

                <form action="" method="POST">
                    <div class="row g-4 align-items-center">

                        <div class="col-lg-8">

                            <div class="row g-4">

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="tipo_sensor">Tipo do Sensor</label>
                                        <input type="text" id="tipo_sensor" name="tipo_sensor" placeholder="Ex: Temperatura, Presença" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="localizacao">Localização</label>
                                        <input type="text" id="localizacao" name="localizacao" placeholder="Ex: Eixo 01, Motor A" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="empresa_operadora">Empresa operadora</label>
                                        <input type="text" id="empresa_operadora" name="empresa_operadora" placeholder="Coloque a operadora" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="status_sensor">Status do Sensor</label>
                                        <select id="status_sensor" name="status_sensor" class="form-select border-0 text-center" style="background-color: rgb(248, 161, 61); font-weight: bold; border-radius: 25px;" required>
                                            <option value="Ativo">Ativo</option>
                                            <option value="Inativo">Inativo</option>
                                            <option value="Manutenção">Manutenção</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="card-input">
                                        <label for="id_trem">Selecione o Trem</label>
                                        <select id="id_trem" name="id_trem" class="form-select border-0 text-center" style="background-color: rgb(248, 161, 61); font-weight: bold; border-radius: 25px;" required>
                                            <option value="">-- Selecione um Trem --</option>
                                            <?php foreach ($trens as $trem): ?>
                                                <option value="<?= $trem['id_trem'] ?>">
                                                    <?= htmlspecialchars($trem['apelido']) ?> (<?= htmlspecialchars($trem['modelo']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-lg-4 d-flex justify-content-center align-items-center">

                            <div class="botao-container">
                                <button type="submit" class="btn-enviar">
                                    Enviar
                                </button>
                            </div>

                        </div>

                    </div>
                </form>

            </section>

        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>