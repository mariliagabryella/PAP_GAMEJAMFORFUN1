<?php
session_start();

/* Tem de estar logado - AGORA USA A VARIÁVEL CORRETA */
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$emailAntigo = $_SESSION["email"];
$nome = $_POST["nome"] ?? '';
$emailNovo = $_POST["email"] ?? '';

/* Conexão BD */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

/* Busca foto atual */
$stmt = $conn->prepare("SELECT foto FROM utilizadores WHERE email = ?");
$stmt->bind_param("s", $emailAntigo);
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

/* Upload nova foto (se enviada) */
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

/* Atualiza BD (Procura pelo email antigo e atualiza para o novo) */
$stmtUp = $conn->prepare("
    UPDATE utilizadores 
    SET nome = ?, email = ?, foto = ? 
    WHERE email = ?
");
$stmtUp->bind_param("ssss", $nome, $emailNovo, $fotoFinal, $emailAntigo);
$stmtUp->execute();

/* Atualiza sessão - AGORA ATUALIZA AS VARIÁVEIS CERTAS */
$_SESSION["nome"]  = $nome; /* Assumindo que também usas "nome" e não "usuarioNome" noutros lados */
$_SESSION["email"] = $emailNovo;

$stmtUp->close();
$conn->close();

header("Location: admin.php");
exit();
?>