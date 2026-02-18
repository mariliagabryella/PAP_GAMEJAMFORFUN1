<?php
session_start();
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$email = $_POST['email'];
$pin   = $_POST['pin'];

if (empty($email)) {
    header("Location: registar.php?erro=Email inválido.");
    exit();
}

$stmt = $conn->prepare("SELECT pin FROM verificacoes_pin WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 1) {
    $row = $res->fetch_assoc();

    if ($row['pin'] === $pin) {

        // Ativar conta
        $stmt2 = $conn->prepare("UPDATE utilizadores SET ativo = NOW() WHERE email = ?");
        $stmt2->bind_param("s", $email);
        $stmt2->execute();

        // Buscar dados do utilizador para iniciar sessão
        $stmt3 = $conn->prepare("SELECT id, nome, email, role_id, foto FROM utilizadores WHERE email = ?");
        $stmt3->bind_param("s", $email);
        $stmt3->execute();
        $user = $stmt3->get_result()->fetch_assoc();

        // Criar sessão automaticamente
        $_SESSION["id"]    = $user["id"];
        $_SESSION["nome"]  = $user["nome"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role_id"] = $user["role_id"];
        $_SESSION["foto"]  = $user["foto"];

        // Apagar PIN
        $stmt4 = $conn->prepare("DELETE FROM verificacoes_pin WHERE email = ?");
        $stmt4->bind_param("s", $email);
        $stmt4->execute();

        // Redirecionar para o painel
        header("Location: painel_do_viewer.php");
        exit();
    }
}

// Se falhar:
header("Location: verificar_pin.php?email=" . urlencode($email) . "&erro=PIN incorreto");
exit();
?>
