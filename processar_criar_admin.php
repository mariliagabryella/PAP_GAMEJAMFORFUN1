<?php
session_start();

/* ============================================================
   PERMISSÕES
   Apenas Admin Master pode criar novos admins
   ============================================================ */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

/* Dados do formulário */
$nome  = trim($_POST["nome"] ?? '');
$email = trim($_POST["email"] ?? '');
$senha = $_POST["senha"] ?? '';

if ($nome === '' || $email === '' || $senha === '') {
    die("❌ Preencha todos os campos.");
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

/* ============================================================
   CONEXÃO BD
   ============================================================ */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

/* ============================================================
   UPLOAD DE FOTO (opcional)
   ============================================================ */
$fotoFinal = "img/default.png";

if (!empty($_FILES["foto"]["name"])) {

    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    $nomeFoto = time() . "_" . basename($_FILES["foto"]["name"]);
    $destino  = "uploads/" . $nomeFoto;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) {
        $fotoFinal = $destino;
    }
}

/* ============================================================
   INSERIR NOVO ADMIN (role_id = 2)
   ============================================================ */
$stmt = $conn->prepare("
    INSERT INTO utilizadores (nome, email, senha_hash, role_id, foto) 
    VALUES (?, ?, ?, 2, ?)
");
$stmt->bind_param("ssss", $nome, $email, $senhaHash, $fotoFinal);
$stmt->execute();
$stmt->close();

/* ============================================================
   REGISTAR LOG
   ============================================================ */
require_once "registar_log.php";

$idLogado = $_SESSION["id"] ?? 0;

registar_log(
    $conn,
    $idLogado,
    "Criar Admin",
    "Criado novo admin: $email"
);

$conn->close();

/* Redirecionar */
header("Location: admin.php");
exit();
