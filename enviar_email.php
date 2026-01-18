<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

function enviarEmail($destinatario, $assunto, $mensagemHTML) {

    $mail = new PHPMailer(true);

    try {
        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        // ⚠️ Coloca aqui o teu email e password de app
        $mail->Username   = 'gamejamforfunteste@gmail.com';
        $mail->Password   = 'zwzx utns tnwi hcae';

        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Remetente
        $mail->setFrom('gamejamforfunteste@gmail.com', 'GameJam For Fun');

        // Destinatário
        $mail->addAddress($destinatario);

        // Conteúdo
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body    = $mensagemHTML;

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}
