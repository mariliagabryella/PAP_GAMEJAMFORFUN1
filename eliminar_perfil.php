<?php
session_start();

if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 3) {
    header("Location: login.php");
    exit();
}

$nome = $_SESSION["usuarioNome"];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Confirmar Eliminação</title>
<link rel="stylesheet" href="css/admin.css">
</head>

<body>

<div class="admin-content">
    <h1>Eliminar Conta</h1>

    <p>Tem a certeza que deseja eliminar a sua conta, <strong><?php echo htmlspecialchars($nome); ?></strong>?</p>
    <p style="color:#ff4d4d; font-weight:bold;">Esta ação é permanente e não pode ser desfeita.</p>

    <div style="margin-top:25px;">
        <a href="processar_eliminar_perfil.php" 
           style="padding:10px 20px; background:#ff4d4d; color:white; text-decoration:none; margin-right:15px;">
           SIM, eliminar conta
        </a>

        <a href="painel_do_viewer.php" 
           style="padding:10px 20px; background:#4CAF50; color:white; text-decoration:none;">
           NÃO, voltar ao painel
        </a>
    </div>
</div>

</body>
</html>
