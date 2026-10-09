<?php
require_once '../infra/conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmaSenha = $_POST['confirmaSenha'] ?? '';

    if ($nome === '' || $email === '' || $senha === '') {
        echo "<script>alert('Preencha todos os campos.');</script>";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Digite um email válido.');</script>";

    } elseif ($senha !== $confirmaSenha) {
        echo "<script>alert('As senhas não coincidem.');</script>";

    } else {

        $stmt = $conexao->prepare(
            "SELECT id_usuario FROM Usuario WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {

            echo "<script>alert('Este email já está cadastrado.');</script>";

        } else {

            $dominio = substr(strrchr($email, "@"), 1);

            if ($dominio === 'admin.com') {
                $id_perfil = 1;
            } elseif (
                $dominio === 'railview.com' ||
                $dominio === 'funcionario.com'
            ) {
                $id_perfil = 2;
            } else {
                $id_perfil = 3;
            }

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conexao->prepare(
                "INSERT INTO Usuario (nome, email, senha, id_perfil)
                VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "sssi",
                $nome,
                $email,
                $senhaHash,
                $id_perfil
            );

            if ($stmt->execute()) {
                $_SESSION['usuario_id'] = $conexao->insert_id;
                $_SESSION['id_perfil'] = $id_perfil;

                header("Location: ../public/login.php");
                exit();
            } else {
                echo "<script>alert('Erro ao cadastrar usuário.');</script>";
            }
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">

    <link rel="stylesheet" href="../assets/css/cadastro.css">
</head>

<body>

    <main>

        <div>

            <video
                class="video_inicial"
                src="../assets/videos/video.login.mp4"
                autoplay
                loop
                muted
                playsinline>
            </video>

            <div class="container_login_2">

                <img
                    src="../assets/logos/logo_sem_fundo.png"
                    alt="Logo"
                    class="logo_login">

                <div id="form">

                    <form id="formCadastro" method="POST">

                        <label class="label_login" for="nomeCadastro">
                            Nome completo
                        </label>

                        <input
                            class="form_text"
                            type="text"
                            id="nomeCadastro"
                            name="nome"
                            placeholder="Digite seu nome completo"
                            required>

                        <label class="label_login" for="emailCadastro">
                            Email
                        </label>

                        <input
                            class="form_text"
                            type="email"
                            id="emailCadastro"
                            placeholder="Digite seu email"
                            required
                            name="email">

                        <br>

                        <label class="label_login" for="senhaCadastro">
                            Senha
                        </label>

                        <input
                            class="form_text"
                            type="password"
                            id="senhaCadastro"
                            placeholder="Digite sua senha"
                            required
                            name="senha">

                        <br>

                        <label class="label_login" for="confirmaSenha">
                            Confirmar Senha
                        </label>

                        <input
                            class="form_text"
                            type="password"
                            id="confirmaSenha"
                            placeholder="Confirme sua senha"
                            required
                            name="confirmaSenha">

                        <br>

                        <div class="login_1">

                            <input
                                class="checkbox_login"
                                type="checkbox"
                                name="termos"
                                id="termos"
                                required>

                            <label for="termos">
                                Aceito os
                            </label>

                            <a
                                href="../public/termo_de_uso.html"
                                target="_blank"
                                id="linkTermos">
                                Termos de Uso
                            </a>

                        </div>

                        <div class="login_1">

                            <a
                                href="../public/login.php"
                                id="text_log"
                                style="
                                    text-decoration: none;
                                    color: inherit;
                                    display: block;
                                    cursor: pointer;
                                    text-align: center;
                                ">
                                Já possui conta? Voltar para o Login.
                            </a>

                        </div>

                        <br>

                        <button id="button_login" type="submit">
                            Cadastrar
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </main>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous">
    </script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y"
        crossorigin="anonymous">
    </script>

    <script src="../scripts/cadastro.js"></script>

</body>

</html>