<?php
session_start();

/* Apenas adminmaster pode processar edição */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

/* Verifica dados básicos */
if (!isset($_POST['id'])) {
    header("Location: admin.php");
    exit();
}

$id      = (int) $_POST['id'];
$nome    = $_POST['nome'] ?? '';
$email   = $_POST['email'] ?? '';
$role_id = (int) ($_POST['role_id'] ?? 3);

/* Conexão BD */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

/* Busca foto atual */
$stmt = $conn->prepare("SELECT foto FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$fotoAtual = "img/default.png";

if ($res->num_rows === 1) {
    $row = $res->fetch_assoc();
    if (!empty($row['foto'])) {
        $fotoAtual = $row['foto'];
    }
}
$stmt->close();

/* Trata upload de nova foto (se enviada) */
$fotoFinal = $fotoAtual;

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

/* Atualiza dados */
$stmtUp = $conn->prepare("
    UPDATE utilizadores 
    SET nome = ?, email = ?, role_id = ?, foto = ? 
    WHERE id = ?
");
$stmtUp->bind_param("ssisi", $nome, $email, $role_id, $fotoFinal, $id);
$stmtUp->execute();

$stmtUp->close();
$conn->close();

header("Location: admin.php");
exit();
