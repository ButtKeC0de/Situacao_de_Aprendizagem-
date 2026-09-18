<?php
session_start();

require_once '../infra/conexao.php'; 

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo    = $_POST['modelo'] ?? '';
    $apelido   = $_POST['apelido'] ?? '';
    $operadora = $_POST['operadora'] ?? '';
    $tipo      = $_POST['tipo'] ?? '';
    $vagoes    = $_POST['vagoes'] ?? '';

    if (!empty($modelo) && !empty($apelido) && !empty($tipo) && !empty($vagoes)) {
        
        $sql = "INSERT INTO Trem (modelo, apelido, tipo_trem, empresa_operadora, numero_vagoes) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conexao->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssi", $modelo, $apelido, $tipo, $operadora, $vagoes);

            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                            Trem '<strong>{$apelido}</strong>' cadastrado com sucesso!
                                            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                        </div>";

                header("Location: trens_lista.php");
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
    <title>Cadastrar Trem</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/trem.css">
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
                        <a href="../public/home.php">
                            <img class="logos" src="../Assets/logos/icon_rotas.png" alt="Rotas">
                        </a>
                    </div>

                    <div>
                        <a href="../public/trens_lista.php">
                            <img class="logos" src="../Assets/logos/icon_trem.png" alt="Trens">
                        </a>
                    </div>

                    <div> 
                        <a href="../public/sensor_home.php">
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
                    <h1 class="titulo m-0">Cadastrar trem</h1>
                    <a href="trens_lista.php" class="btn btn-dark text-white rounded-pill px-4 py-2">
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
                                        <label for="modelo">Modelo do trem</label>
                                        <input type="text" id="modelo" name="modelo" placeholder="Coloque o modelo" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="apelido">Digite o apelido do trem</label>
                                        <input type="text" id="apelido" name="apelido" placeholder="Coloque o apelido" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="operadora">Empresa operadora</label>
                                        <input type="text" id="operadora" name="operadora" placeholder="Coloque a operadora">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card-input">
                                        <label for="tipo">Tipo do trem</label>
                                        <input type="text" id="tipo" name="tipo" placeholder="Coloque o tipo" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="card-input">
                                        <label for="vagoes">Número de vagões</label>
                                        <input type="number" id="vagoes" name="vagoes" placeholder="Coloque o número" min="1" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>