<?php
require_once '../infra/auth.php';

if (isset($_SESSION['usuario_id'])) {
    exigir_login();
}
$adminCadastrando = eh_admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmaSenha = $_POST['confirmaSenha'] ?? '';

    $id_perfil = $adminCadastrando
        ? filter_input(INPUT_POST, 'id_perfil', FILTER_VALIDATE_INT)
        : PERFIL_USUARIO;

    if ($nome === '' || $email === '' || $senha === '') {
        echo "<script>alert('Preencha todos os campos.');</script>";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Digite um email válido.');</script>";

    } elseif ($senha !== $confirmaSenha) {
        echo "<script>alert('As senhas não coincidem.');</script>";

    } elseif (!in_array($id_perfil, [PERFIL_ADMIN, PERFIL_FUNCIONARIO, PERFIL_USUARIO], true)) {
        echo "<script>alert('Perfil inválido.');</script>";

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
                if ($adminCadastrando) {
                    $_SESSION['mensagem'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                                Usuário '<strong>" . htmlspecialchars($nome) . "</strong>' cadastrado com sucesso!
                                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                            </div>";
                    header("Location: usuario_lista.php");
                } else {
                    header("Location: login.php?cadastro=ok");
                }
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

    <link rel="stylesheet" href="../Assets/css/cadastro.css">
</head>

<body>

    <main>

        <div>

            <video
                class="video_inicial"
                src="../Assets/videos/video.login.mp4"
                autoplay
                loop
                muted
                playsinline>
            </video>

            <div class="container_login_2">

                <img
                    src="../Assets/logos/logo_sem_fundo.png"
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

                        <?php if ($adminCadastrando): ?>

                        <label class="label_login" for="perfilCadastro">
                            Perfil
                        </label>

                        <select class="form_text" id="perfilCadastro" name="id_perfil" required>
                            <option value="<?= PERFIL_USUARIO ?>">Usuário</option>
                            <option value="<?= PERFIL_FUNCIONARIO ?>">Funcionário</option>
                            <option value="<?= PERFIL_ADMIN ?>">Administrador</option>
                        </select>

                        <br>

                        <div class="login_1">
                            <a href="usuario_lista.php" style="text-decoration: none; color: inherit; display: block; text-align: center;">
                                ← Voltar para a lista de usuários
                            </a>
                        </div>

                        <?php else: ?>

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

                        <?php endif; ?>

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

    

</body>

</html>