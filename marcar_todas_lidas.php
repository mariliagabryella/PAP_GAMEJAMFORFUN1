<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["id"];

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Atualiza todas as notificações DO UTILIZADOR LOGADO para lidas (lida = 1)
$stmt = $conn->prepare("UPDATE notificacoes SET lida = 1 WHERE user_id = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();

$conn->close();

// Redireciona de volta
header("Location: notificacoes_admin.php");
exit();
?>