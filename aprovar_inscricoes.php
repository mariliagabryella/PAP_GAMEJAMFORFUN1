<?php
session_start();
require 'enviar_email.php';

if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET["id"])) {
    header("Location: admin_inscricoes.php");
    exit();
}

$id_inscricao = (int)$_GET["id"];

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* Buscar dados da inscrição */
$stmt = $conn->prepare("SELECT * FROM inscricoes WHERE id = ?");
$stmt->bind_param("i", $id_inscricao);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {
    $stmt->close();
    $conn->close();
    header("Location: admin_inscricoes.php");
    exit();
}

$insc    = $res->fetch_assoc();
$user_id = $insc["user_id"];
$email   = $insc["email_professor"]; // ou email do utilizador se preferires
$nome    = $insc["professor"];       // ou nome do user

$stmt->close();

/* Atualizar estado */
$stmt = $conn->prepare("UPDATE inscricoes SET estado = 'aprovado' WHERE id = ?");
$stmt->bind_param("i", $id_inscricao);
$stmt->execute();
$stmt->close();

/* Notificação interna para o utilizador */
$msg_notif = "A sua inscrição para a Game Jam For Fun 25 foi APROVADA.";
$stmt = $conn->prepare("INSERT INTO notificacoes (user_id, mensagem) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $msg_notif);
$stmt->execute();
$stmt->close();

/* Email para o utilizador/professor */
$mensagem_email = "
    <h2>Inscrição Aprovada - Game Jam For Fun 25</h2>
    <p>Olá $nome,</p>
    <p>A sua inscrição para a Game Jam For Fun 25 foi <strong>aprovada</strong> pela organização.</p>
    <p>Em breve receberá mais informações sobre o evento.</p>
";

enviarEmail($email, "Inscrição aprovada - Game Jam For Fun 25", $mensagem_email);

$conn->close();

header("Location: admin_inscricoes.php?msg=aprovada");
exit();
?>
