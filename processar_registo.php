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
   CRIAR TOKEN DE VERIFICAÇÃO
------------------------------ */
$token = bin2hex(random_bytes(32));

/* ------------------------------
   INSERIR UTILIZADOR
------------------------------ */
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conn->prepare("
    INSERT INTO utilizadores (nome, email, senha_hash, role_id, ativo, criado_em, foto)
    VALUES (?, ?, ?, 3, NOW(), NOW(), ?)
");

$stmt->bind_param("ssss", $nome, $email, $senha_hash, $foto);

if (!$stmt->execute()) {
    die("<h1>ERRO NO INSERT:</h1><pre>" . $stmt->error . "</pre>");
}

$stmt->close();


/* ------------------------------
   GUARDAR TOKEN DE VERIFICAÇÃO
------------------------------ */
$stmt = $conn->prepare("
    INSERT INTO verificacoes_email (email, token)
    VALUES (?, ?)
");
$stmt->bind_param("ss", $email, $token);
$stmt->execute();
$stmt->close();

/* ------------------------------
   ENVIAR EMAIL DE VERIFICAÇÃO
------------------------------ */
require 'enviar_email.php';

$link = "http://172.20.10.2/PAP_GAMEJAMFORFUN1/verificar_email.php?token=$token";


$mensagem = "
    <h2>Confirmação de Conta</h2>
    <p>Olá $nome,</p>
    <p>Clique no link abaixo para ativar a sua conta:</p>
    <p><a href='$link'>$link</a></p>
";

enviarEmail($email, "Verificação de Conta - GameJam", $mensagem);

/* ------------------------------
   INICIAR SESSÃO AUTOMÁTICA
------------------------------ */
$_SESSION["nome"]  = $nome;
$_SESSION["email"] = $email;
$_SESSION["role_id"]      = 3;

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
   REDIRECIONAR PARA O PAINEL VIEWER
------------------------------ */
header("Location: painel_do_viewer.php");
exit();
?>
