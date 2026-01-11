<?php
session_start();

if (!isset($_SESSION["usuarioEmail"])) {
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
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>

<div class="admin-content">
    <h2>Editar Perfil</h2>

    <form action="processar_editar_perfil.php" method="POST">

        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo $nome; ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>

        <button type="submit">Atualizar</button>
    </form>

    <p><a href="admin.php">Voltar</a></p>
</div>

</body>
</html>
