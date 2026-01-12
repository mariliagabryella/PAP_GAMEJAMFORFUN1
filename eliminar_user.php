<?php
session_start();

/* ============================================================
   PERMISSÕES
   Apenas Admin Master (role_id = 1) pode eliminar utilizadores
   ============================================================ */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

/* Verificar se ID foi enviado */
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$id = (int) $_GET['id'];

/* ============================================================
   NÃO PERMITIR:
   - Apagar Admin Master (id 1)
   - Apagar a si próprio
   ============================================================ */
$idLogado = $_SESSION["id"] ?? null;

if ($id == 1) {
    die("❌ Não é permitido eliminar o Admin Master.");
}

if ($id == $idLogado) {
    die("❌ Não podes eliminar a tua própria conta.");
}

/* ============================================================
   CONEXÃO BD
   ============================================================ */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

/* ============================================================
   ELIMINAR UTILIZADOR
   ============================================================ */
$stmt = $conn->prepare("DELETE FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

/* ============================================================
   REGISTAR LOG DA AÇÃO
   ============================================================ */
require_once "registar_log.php";
registar_log(
    $conn,
    $idLogado,
    "Eliminar utilizador",
    "Utilizador ID $id eliminado pelo Admin Master"
);

$conn->close();

/* Redirecionar */
header("Location: admin.php");
exit();
