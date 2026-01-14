<?php
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$token = $_GET['token'];

$stmt = $conn->prepare("SELECT email FROM verificacoes_email WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 1) {
    $row = $res->fetch_assoc();
    $email = $row['email'];

    // Ativar conta
    $conn->query("UPDATE utilizadores SET ativo = NOW() WHERE email = '$email'");

    // Apagar token
    $conn->query("DELETE FROM verificacoes_email WHERE token = '$token'");

    echo "Conta verificada com sucesso!";
} else {
    echo "Token inválido.";
}
?>
