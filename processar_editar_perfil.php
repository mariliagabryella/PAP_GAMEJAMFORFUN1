<?php
session_start();

if (!isset($_SESSION["usuarioEmail"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$nomeNovo  = $_POST["nome"];
$emailNovo = $_POST["email"];
$emailAntigo = $_SESSION["usuarioEmail"];

$stmt = $conn->prepare("UPDATE utilizadores SET nome=?, email=? WHERE email=?");
$stmt->bind_param("sss", $nomeNovo, $emailNovo, $emailAntigo);
$stmt->execute();

$_SESSION["usuarioNome"]  = $nomeNovo;
$_SESSION["usuarioEmail"] = $emailNovo;

header("Location: admin.php");
exit();
