<?php
// processar_criar_viewer.php
session_start();

/* Apenas adminmaster */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

$nome  = $_POST["nome"] ?? '';
$email = $_POST["email"] ?? '';
$senha = $_POST["senha"] ?? '';

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

/* Conexão BD */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

/* Upload foto (opcional) */
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

/* role_id = 3 → viewer */
$stmt = $conn->prepare("
    INSERT INTO utilizadores (nome, email, senha_hash, role_id, foto) 
    VALUES (?, ?, ?, 3, ?)
");
$stmt->bind_param("ssss", $nome, $email, $senhaHash, $fotoFinal);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: admin.php");
exit();
