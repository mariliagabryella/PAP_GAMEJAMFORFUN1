<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];
$nome  = $_SESSION["nome"];

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* Verificar se o utilizador já está ativo */
$stmt = $conn->prepare("SELECT ativo FROM utilizadores WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$stmt->close();

if ($user["ativo"] == 1) {
    // Já está verificado → não precisa reenviar PIN
    header("Location: painel_do_viewer.php");
    exit();
}

/* Gerar novo PIN */
$novoPin = rand(100000, 999999);

/* Guardar novo PIN na BD */
$stmt = $conn->prepare("
    REPLACE INTO verificacoes_pin (email, pin)
    VALUES (?, ?)
");
$stmt->bind_param("ss", $email, $novoPin);
$stmt->execute();
$stmt->close();

/* Enviar email com o novo PIN */
require 'enviar_email.php';

$mensagem = "
<!DOCTYPE html>
<html lang='pt'>
<head>
<meta charset='UTF-8'>
<style>
    body {
        background: #0d0d0d;
        font-family: 'Poppins', Arial, sans-serif;
        color: #ffffff;
        padding: 0;
        margin: 0;
    }

    .container {
        max-width: 500px;
        margin: 40px auto;
        background: #1a1a1a;
        border-radius: 12px;
        padding: 30px;
        border: 1px solid #ff2e2e33;
        box-shadow: 0 0 20px rgba(255, 0, 0, 0.25);
    }

    h2 {
        color: #ff2e2e;
        text-align: center;
        margin-bottom: 10px;
    }

    p {
        color: #cccccc;
        font-size: 15px;
        line-height: 1.6;
    }

    .pin-box {
        background: #ff2e2e;
        color: #ffffff;
        padding: 15px;
        text-align: center;
        font-size: 32px;
        letter-spacing: 6px;
        border-radius: 8px;
        margin: 25px 0;
        font-weight: bold;
    }

    .footer {
        margin-top: 25px;
        text-align: center;
        font-size: 12px;
        color: #777;
    }
</style>
</head>

<body>

<div class='container'>
    <h2>Novo Código de Verificação</h2>

    <p>Olá <strong>$nome</strong>,</p>

    <p>Gerámos um novo código de verificação para ativar a sua conta.</p>

    <div class='pin-box'>$novoPin</div>

    <p>Introduza este código na página de verificação.</p>

    <div class='footer'>
        © " . date('Y') . " Game Jam For Fun<br>
        Este email foi enviado automaticamente — não responda.
    </div>
</div>

</body>
</html>
";

enviarEmail($email, "Novo Código de Verificação - GameJam", $mensagem);

/* Redirecionar de volta para a página de verificação */
header("Location: verificar_pin.php?email=" . urlencode($email) . "&reenviado=1");
exit();
?>
