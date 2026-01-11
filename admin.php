<?php
session_start();

/* Apenas admins podem entrar */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

$nome  = $_SESSION["usuarioNome"];
$email = $_SESSION["usuarioEmail"];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>

<div class="admin-menu">
    <div class="admin-info">
        <strong><?php echo $nome; ?></strong><br>
        <small><?php echo $email; ?></small>
    </div>

    <div class="admin-links">
        <a href="admin.php">Dashboard</a>
        <a href="editar_perfil.php">Editar Perfil</a>
        <a href="criar_admin.php">Criar Admin</a>
        <a href="logout.php">Sair</a>
    </div>
</div>

<div class="admin-content">
    <h1>Bem-vindo(a), <?php echo $nome; ?></h1>
    <p>Escolhe uma opção no menu acima.</p>
</div>

</body>
</html>
