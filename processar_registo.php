<?php
session_start();

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);

$nome  = trim($_POST['nome']);
$email = trim($_POST['email']);
$senha = trim($_POST['senha']);

/* ------------------------------
   VALIDAÇÃO AVANÇADA
------------------------------ */

// Nome válido
if (!preg_match("/^[A-Za-zÀ-ÿ\s]+$/", $nome)) {
    header("Location: registar.php?erro=Nome inválido.");
    exit();
}

// Email válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: registar.php?erro=Email inválido.");
    exit();
}

// Senha forte
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $senha)) {
    header("Location: registar.php?erro=Senha fraca. Use maiúscula, minúscula, número e símbolo.");
    exit();
}

/* ------------------------------
   VERIFICAR EMAIL DUPLICADO
------------------------------ */
$stmt = $conn->prepare("SELECT id FROM utilizadores WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    header("Location: registar.php?erro=Este email já está registado.");
    exit();
}
$stmt->close();

/* ------------------------------
   UPLOAD DA FOTO
------------------------------ */
$foto = "img/default.png";

if (!empty($_FILES['foto']['name'])) {

    $permitidos = ['image/jpeg', 'image/png'];
    if (!in_array($_FILES['foto']['type'], $permitidos)) {
        header("Location: registar.php?erro=Formato inválido. Use JPG ou PNG.");
        exit();
    }

    if ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
        header("Location: registar.php?erro=Foto muito grande. Máximo 2MB.");
        exit();
    }

    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $novoNome = "foto_" . time() . "." . $ext;
    $destino = "uploads/" . $novoNome;

    move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
    $foto = $destino;
}

/* Criar notificação para todos os admins */
$conn->query("
    INSERT INTO notificacoes (user_id, mensagem, lida, data)
    SELECT id, 'Novo registo de utilizador: $nome', 0, NOW()
    FROM utilizadores
    WHERE role_id IN (1,2)
");

/* ------------------------------
   GERAR PIN DE VERIFICAÇÃO
------------------------------ */
$pin = rand(100000, 999999);

/* ------------------------------
   INSERIR UTILIZADOR
------------------------------ */
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conn->prepare("
    INSERT INTO utilizadores (nome, email, senha_hash, role_id, ativo, criado_em, foto)
    VALUES (?, ?, ?, 3, NULL, NOW(), ?)
");

$stmt->bind_param("ssss", $nome, $email, $senha_hash, $foto);

if (!$stmt->execute()) {
    die("<h1>ERRO NO INSERT:</h1><pre>" . $stmt->error . "</pre>");
}

$stmt->close();

/* ------------------------------
   GUARDAR PIN NA BD
------------------------------ */
$stmt = $conn->prepare("
    REPLACE INTO verificacoes_pin (email, pin)
    VALUES (?, ?)
");
$stmt->bind_param("ss", $email, $pin);
$stmt->execute();
$stmt->close();

/* ------------------------------
   ENVIAR EMAIL COM O PIN
------------------------------ */
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
    <h2>Verificação de Conta</h2>

    <p>Olá <strong>$nome</strong>,</p>

    <p>Obrigado por se registar na <strong>Game Jam For Fun</strong>!</p>

    <p>Para ativar a sua conta, introduza o código abaixo na página de verificação:</p>

    <div class='pin-box'>$pin</div>

    <p>Se não pediu este código, pode ignorar este email.</p>

    <div class='footer'>
        © " . date('Y') . " Game Jam For Fun<br>
        Este email foi enviado automaticamente — não responda.
    </div>
</div>

</body>
</html>
";

enviarEmail($email, "Código de Verificação - GameJam", $mensagem);

/* ------------------------------
   INICIAR SESSÃO (AINDA NÃO ATIVA)
------------------------------ */
$_SESSION["nome"]  = $nome;
$_SESSION["email"] = $email;
$_SESSION["role_id"] = 3;

/* Buscar ID do utilizador */
$stmt = $conn->prepare("SELECT id FROM utilizadores WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$_SESSION["id"] = $row["id"];

$stmt->close();
$conn->close();

/* ------------------------------
   REDIRECIONAR PARA VERIFICAÇÃO DO PIN
------------------------------ */
header("Location: verificar_pin.php?email=$email");
exit();
?>

