<?php
session_start();
include 'bd_connection.php';

// Apenas Admin Master (1) e Admin (2)
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    die("Sem permissão.");
}

$id = $_GET['id'] ?? 0;
if (!$id) {
    die("ID inválido.");
}

// APAGAR CARROSSEL
$stmt = $pdo->prepare("DELETE FROM edicoes_carrossel WHERE id_edicao = :id");
$stmt->execute([':id' => $id]);

// APAGAR PATROCINADORES
$stmt = $pdo->prepare("DELETE FROM edicoes_patrocinadores WHERE id_edicao = :id");
$stmt->execute([':id' => $id]);

// APAGAR A EDIÇÃO
$stmt = $pdo->prepare("DELETE FROM edicoes WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: admin_edicoes.php?msg=apagada");
exit;
