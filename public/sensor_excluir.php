<?php
session_start();
require_once '../infra/conexao.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_sensor = intval($_GET['id']);

    $sql = "DELETE FROM Sensor WHERE id_sensor = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id_sensor);

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        Sensor excluído com sucesso!
                                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                    </div>";
        } else {
            $_SESSION['mensagem'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                        Erro ao excluir o sensor: " . $stmt->error . "
                                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                    </div>";
        }
        $stmt->close();
    }
}

header("Location: sensor_lista.php");
exit();