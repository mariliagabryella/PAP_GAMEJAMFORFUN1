<?php
session_start();

if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 3) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["id"];
$email = $_SESSION["email"];

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* Buscar foto */
$stmt = $conn->prepare("SELECT foto FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

$foto = $user["foto"];

/* Apagar foto se não for default */
if ($foto !== "img/default.png" && file_exists($foto)) {
    unlink($foto);
}

/* Eliminar utilizador */
$stmt = $conn->prepare("DELETE FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

/* Eliminar tokens */
$stmt = $conn->prepare("DELETE FROM verificacoes_email WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

/* Terminar sessão */
session_unset();
session_destroy();

/* Redirecionar */
header("Location: index.php?msg=conta_eliminada");
exit();
?>
