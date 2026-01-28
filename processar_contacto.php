<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$nome = $_POST["nome"];
$email = $_POST["email"];
$mensagem = $_POST["mensagem"];

$user_id = isset($_SESSION["id"]) ? $_SESSION["id"] : null;

/* Guardar contacto */
$stmt = $conn->prepare("
    INSERT INTO contactos (nome, email, mensagem, data_envio, user_id)
    VALUES (?, ?, ?, NOW(), ?)
");
$stmt->bind_param("sssi", $nome, $email, $mensagem, $user_id);
$stmt->execute();

$contactoId = $stmt->insert_id;

/* Criar notificação interna para Admin e Admin Master */
$conn->query("
    INSERT INTO notificacoes (user_id, mensagem, lida, data)
    SELECT id, 'Novo pedido de contacto de $nome', 0, NOW()
    FROM utilizadores
    WHERE role_id IN (1,2)
");

/* Enviar email para o email oficial */
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'gamejamforfunteste@gmail.com';
    $mail->Password = 'zwzx utns tnwi hcae';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom($email, $nome);
    $mail->addAddress('gamejamforfunteste@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = "Novo contacto recebido";
    $mail->Body = "
        <h3>Novo contacto recebido</h3>
        <p><strong>Nome:</strong> $nome</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Mensagem:</strong><br>$mensagem</p>
    ";

    $mail->send();

} catch (Exception $e) {
    die("Erro ao enviar email: {$mail->ErrorInfo}");
}

header("Location: contact.php?sucesso=1");
exit();
