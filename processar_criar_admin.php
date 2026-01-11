<?php
session_start();

if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$nome  = $_POST["nome"];
$email = $_POST["email"];
$senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

$stmt = $conn->prepare("
    INSERT INTO utilizadores (nome, email, senha_hash, role_id)
    VALUES (?, ?, ?, 1)
");
$stmt->bind_param("sss", $nome, $email, $senha);
$stmt->execute();

header("Location: admin.php");
exit();
