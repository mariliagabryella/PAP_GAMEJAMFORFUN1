<?php
session_start();

if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    exit("Sem permissão");
}

if (!isset($_GET["id"]) || !isset($_GET["tipo"]) || !isset($_GET["edicao"])) {
    exit("Dados inválidos");
}

$id = intval($_GET["id"]);
$tipo = $_GET["tipo"];
$edicao = intval($_GET["edicao"]);

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

if ($tipo === "carrossel") {
    $sql = "DELETE FROM edicoes_carrossel WHERE id = ?";
} elseif ($tipo === "patrocinador") {
    $sql = "DELETE FROM edicoes_patrocinadores WHERE id = ?";
} else {
    exit("Tipo inválido");
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: editar_edicao.php?id=" . $edicao);
exit();
