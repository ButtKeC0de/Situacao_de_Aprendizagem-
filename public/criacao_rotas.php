<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cadastro e gerenciamento de rotas ferroviárias">

    <title>Cadastro de Rotas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../Assets/css/rotas.css">
  
</head>

<body>
    <div class="tela">
        <div class="d-flex h-100">
            <div class="principal">
                <div>
                    <div>
                        <img class="logos" src="../Assets/logos/Logo.png" alt="Logo">
                    </div>

                    <div id="logos_barra_lateral">
                        <div>
                           <a href="../public/criação_rotas.html">
                        <img class="logos" src="../Assets/logos/icon_rotas.png" alt="">
                        </a>
                    </div>

                    <div>
                        <a href="../public/home.php">
                        <img class="logos" src="../Assets/logos/icon_trem.png" alt="">
                        </a>
                    </div>

                    <div> 
                        <a href="../public/sensor_home.php">
                        <img class="logos" src="../Assets/logos/icon_sensores.png" alt="">
                        </a>
                    </div>

                    <div>
                        <a href="../index.html">
                            <img class="logos" src="../Assets/logos/icon_saida.png" alt="">
                        </a>
                        </div>
                    </div>


                </div>
            </div>
        </div

        <main class="conteudo">
            <header class="topo">
                <div>
                    <h1 class="titulo_home">Cadastro de Rota</h1>
                </div>

                <div class="usuario">
                    <div class="foto_usuario" aria-hidden="true">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="nome_usuario">admin_007</span>
                </div>
            </header>

            <section id="rotas_cadastradas" aria-label="Cadastro e listagem de rotas">
                <article id="trens" class="card">
                    <div class="card-cabecalho">
                        <div class="icone-card" aria-hidden="true">
                            <i class="bi bi-signpost-split-fill"></i>
                        </div>
                        <div>
                            <h2>Cadastrar Rota</h2>
                            <p>Informe os dados do novo trajeto.</p>
                        </div>
                    </div>

                    <form class="formrota" id="formRota" autocomplete="off">
                        <div class="campo">
                            <label for="idTrem">ID do trem</label>
                            <input type="number" id="idTrem" name="idTrem" min="1" placeholder="Ex.: 15" required>
                        </div>

                        <div class="campo">
                            <label for="origem">Origem</label>
                            <input type="text" id="origem" name="origem" maxlength="60" placeholder="Ex.: Joinville" required>
                        </div>

                        <div class="campo">
                            <label for="destino">Destino</label>
                            <input type="text" id="destino" name="destino" maxlength="60" placeholder="Ex.: Curitiba" required>
                        </div>

                        <p id="mensagemFormulario" class="mensagem" role="status" aria-live="polite"></p>

                        <button class="btn-cadastrar" type="submit">
                            <i class="bi bi-plus-lg" aria-hidden="true"></i>
                            Cadastrar rota
                        </button>
                    </form>
                </article>

                <article id="trens_2" class="card">
                    <div class="lista-topo">
                        <div>
                            <h2>Rotas Cadastradas</h2>
                            <p id="contadorRotas">Nenhuma rota cadastrada</p>
                        </div>

                        <label class="pesquisa" for="pesquisarRota">
                            <i class="bi bi-search" aria-hidden="true"></i>
                            <input type="search" id="pesquisarRota" placeholder="Pesquisar rota">
                        </label>
                    </div>

                    <div id="listaRotas" aria-live="polite"></div>

                    <div id="estadoVazio" class="estado-vazio">
                        <i class="bi bi-map" aria-hidden="true"></i>
                        <h3>Nenhuma rota cadastrada</h3>
                        <p>As novas rotas aparecerão aqui.</p>
                    </div>
                </article>
            </section>

            <section class="parte_baixo_home" aria-labelledby="tituloMapa">
                <div class="mapa-cabecalho">
                    <h2 id="tituloMapa">Mapa das rotas</h2>
                  
                </div>

                <div class="card_mapa">
                    <iframe
                        src="https://www.openstreetmap.org/export/embed.html?bbox=-49.42%2C-25.62%2C-49.16%2C-25.36&amp;layer=mapnik"
                        title="Mapa das rotas"
                        loading="lazy">
                    </iframe>
                </div>
            </section>
        </main>
    </div>

    <script src="../scripts/rota.js"></script>
</body>

</html>
