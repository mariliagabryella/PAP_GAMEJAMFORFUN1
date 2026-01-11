<?php
session_start();

if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Administrador</title>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>

<div class="admin-content">
    <h2>Criar Novo Administrador</h2>

    <form action="processar_criar_admin.php" method="POST">

        <label>Nome:</label>
        <input type="text" name="nome" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Senha:</label>
        <input type="password" name="senha" required>

        <button type="submit">Criar Admin</button>
    </form>

    <p><a href="admin.php">Voltar</a></p>
</div>

</body>
</html>
