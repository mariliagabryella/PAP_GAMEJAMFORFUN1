<?php
// criar_admin.php
session_start();

/* Apenas adminmaster pode criar admins */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Criar Admin</title>
<link rel="stylesheet" href="css/admin.css">
</head>

<body>

<div class="admin-content">
    <h2>Criar Admin</h2>

    <form action="processar_criar_admin.php" method="POST" enctype="multipart/form-data" class="form-card">

        <div class="form-group">
            <label>Foto de Perfil (opcional):</label>
            <input type="file" name="foto">
        </div>

        <div class="form-group">
            <label>Nome:</label>
            <input type="text" name="nome" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label>Senha:</label>
            <input type="password" name="senha" required>
        </div>

        <button type="submit">Criar Admin</button>
        <a href="admin.php" class="btn-voltar">Voltar</a>
    </form>
</div>

</body>
</html>
