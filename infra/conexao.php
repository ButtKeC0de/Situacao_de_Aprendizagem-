<?php

$host = "localhost";
$usuario = "root";
$senha = "root";
$banco = "ferrorama_db";
$porta = 3306;

$conexao = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($conexao->connect_error) {
    die("Erro na conexão com o banco: " . $conexao->connect_error);
}

$conexao->set_charset("utf8mb4");