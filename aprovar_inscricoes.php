<?php
session_start();
require 'enviar_email.php';

// Verificar se é admin
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

/* ======================================================
   A MAGIA AQUI: Fazer JOIN com a tabela utilizadores 
   para apanhar o email real da conta do utilizador!
   ====================================================== */
$stmt = $conn->prepare("
    SELECT i.*, u.email AS email_conta, u.nome AS nome_conta 
    FROM inscricoes i
    JOIN utilizadores u ON i.user_id = u.id
    WHERE i.id = ?
");
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

// AGORA SIM: Usar o email e nome da conta que fez a inscrição!
$email   = $insc["email_conta"]; 
$nome    = $insc["nome_conta"];  

$stmt->close();

/* Atualizar estado para aprovado */
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

/* Email para o utilizador: APROVADO (Tema Gaming) */
$mensagem_email = '
<!DOCTYPE html>
<html>
<head>
<style>
  @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap");
</style>
</head>
<body style="margin:0; padding:0; background-color: #0f172a;">
<div style="font-family: \'Poppins\', Arial, sans-serif; background-color: #0f172a; padding: 40px 20px; color: #cbd5e1;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #1e293b; border: 2px solid #10b981; border-radius: 12px; box-shadow: 0 0 20px rgba(16, 185, 129, 0.2); overflow: hidden;">
        
        <div style="background-color: #10b981; padding: 25px 20px; text-align: center;">
            <h1 style="margin: 0; color: #0f172a; font-size: 26px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">&#11088; Game Jam For Fun</h1>
        </div>
        
        <div style="padding: 40px 30px; font-size: 16px; line-height: 1.7;"
            <h2 style="color: #ffffff; font-size: 24px; margin-top: 0;">Level Up, <strong>' . $nome . '</strong>!</h2>
            
            <p>É com muito entusiasmo que te comunicamos que a tua inscrição foi <span style="color: #10b981; font-weight: 700; text-shadow: 0 0 8px rgba(16,185,129,0.5);">APROVADA</span>.</p>
            
            <p>O teu lugar na <strong>Game Jam For Fun 25</strong> está oficialmente garantido. Prepara o teu motor de jogo favorito, afina a tua criatividade e avisa a tua equipa, porque este desafio vai ser épico!</p>
            
            <p>Nos próximos dias, enviaremos um novo <i>update</i> com as <i>patch notes</i> do evento: horários, regulamento completo e os links do nosso servidor de Discord.</p>
            
            <p>Estamos ansiosos por ver as tuas <i>skills</i> em ação.</p>
            
            <hr style="border: none; border-top: 1px solid #334155; margin: 30px 0;">
            <p style="margin: 0; color: #94a3b8; font-size: 15px;">GlHF (Good Luck, Have Fun),<br><strong style="color: #ffffff;">A Organização - Game Jam For Fun 25</strong></p>
        </div>
        
    </div>
</div>
</body>
</html>';

enviarEmail($email, "Inscricao aprovada - Game Jam For Fun 25", $mensagem_email);

$conn->close();

header("Location: admin_inscricoes.php?msg=aprovada");
exit();
?>