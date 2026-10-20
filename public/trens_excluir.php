<?php
require_once '../infra/auth.php';
exigir_admin();


$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conexao->prepare("DELETE FROM Trem WHERE id_trem = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $_SESSION['mensagem'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                Trem ID <strong>{$id}</strong> foi excluído com sucesso!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        } else {
            $_SESSION['mensagem'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                Nenhum trem foi encontrado com o ID <strong>{$id}</strong>.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    } else {
        $_SESSION['mensagem'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Não foi possível excluir o trem. Ele possui vínculos ativos no sistema (sensores, rotas ou manutenção).
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    $stmt->close();
} else {
    $_SESSION['mensagem'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        Nenhum ID válido foi fornecido para exclusão.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
}

header("Location: trens_lista.php");
exit();
?>