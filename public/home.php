<?php

session_start();

require_once "../infra/conexao.php";

$sql = "SELECT * FROM trem ORDER BY id_trem DESC";
$resultado = $conexao->query($sql);

?>

<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trens Cadastrados</title>

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
                <img
                    class="logos"
                    src="../Assets/logos/Logo.png"
                    alt="Logo"
                >
            </div>

            <div id="logos_barra_lateral">

                <div>
                    <a href="../public/criação_rotas.html">
                        <img
                            class="logos"
                            src="../Assets/logos/icon_rotas.png"
                            alt="Rotas"
                        >
                    </a>
                </div>

                <div>
                    <a href="../public/home.php">
                        <img
                            class="logos"
                            src="../Assets/logos/icon_trem.png"
                            alt="Trens"
                        >
                    </a>
                </div>

                <div>
                    <a href="../public/sensor_home.php">
                        <img
                            class="logos"
                            src="../Assets/logos/icon_sensores.png"
                            alt="Sensores"
                        >
                    </a>
                </div>

                <div>
                    <a href="../index.html">
                        <img
                            class="logos"
                            src="../Assets/logos/icon_saida.png"
                            alt="Sair"
                        >
                    </a>
                </div>

            </div>

        </div>

    </div>

    <div class="conteudo">

        <div class="topo">

            <h1 class="titulo_home">
                Trens cadastrados
            </h1>

            <div class="usuario">

                <div class="foto_usuario">
                    <i class="bi bi-person-fill"></i>
                </div>

                <span class="nome_usuario">
                    admin_007
                </span>

            </div>

        </div>

        <div class="busca">

            <i class="bi bi-search"></i>

            <input
                id="pesquisa"
                type="search"
                placeholder="ID:92462"
                autocomplete="off"
            >

        </div>

        <?php if (isset($_SESSION['mensagem'])): ?>

            <?= $_SESSION['mensagem']; ?>

            <?php unset($_SESSION['mensagem']); ?>

        <?php endif; ?>

        <div id="trens">

            <?php if ($resultado && $resultado->num_rows > 0): ?>

                <?php while ($trem = $resultado->fetch_assoc()): ?>

                    <div
                        class="trem"
                        data-id="<?= (int)$trem['id_trem'] ?>"
                    >

                        <img
                            src="../Assets/logos/Logo.png"
                            alt="Imagem do trem"
                        >

                        <p>
                            ID:<?= (int)$trem['id_trem'] ?>
                        </p>

                        <p>
                            <?= htmlspecialchars(
                                $trem['apelido'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </p>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <p
                    style="
                        grid-column: 1 / -1;
                        text-align: center;
                    "
                >
                    Nenhum trem cadastrado.
                </p>

            <?php endif; ?>

        </div>

        <div class="parte_baixo_home">

            <div class="card_acao">

                <h2>
                    Cadastrar trem
                </h2>

                <form
                    action="trens_cadastro.php"
                    method="get"
                >

                    <button
                        type="submit"
                        class="botao_laranja"
                    >
                        Cadastrar
                    </button>

                </form>

            </div>

            <div class="card_acao">

                <h2>
                    Editar trem
                </h2>

                <form
                    action="trens_editar.php"
                    method="get"
                >

                    <button
                        type="submit"
                        class="botao_laranja"
                    >
                        Editar
                    </button>

                </form>

            </div>

            <div class="card_acao">

                <h2>
                    Excluir trem
                </h2>

                <form
                    action="trens_excluir.php"
                    method="get"
                >

                    <button
                        type="submit"
                        class="botao_laranja"
                    >
                        Excluir
                    </button>

                </form>

            </div>

            <div class="card_mapa">

                <iframe
                    src="https://www.openstreetmap.org/export/embed.html?bbox=-49.42%2C-25.62%2C-49.16%2C-25.36&layer=mapnik"
                    title="Mapa das rotas"
                ></iframe>

            </div>

        </div>

    </div>

</div>

<script src="../scripts/home.js?v=3"></script>

</body>

</html>