<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Registar Conta</title>
    <link rel="stylesheet" href="css/loginstyle.css">
</head>

<body>

<?php include 'menu.php'; ?>

<div class="login-wrapper">
    <form action="processar_registo.php" method="POST" enctype="multipart/form-data">
        <h2>Criar Conta</h2>

        <?php if (isset($_GET['erro'])): ?>
            <p style="color: #ff8080;"><?php echo htmlspecialchars($_GET['erro']); ?></p>
        <?php endif; ?>

        <?php if (isset($_GET['sucesso'])): ?>
            <p style="color: #80ff80;"><?php echo htmlspecialchars($_GET['sucesso']); ?></p>
        <?php endif; ?>

        <label>Nome completo:</label>
        <input type="text" name="nome" required>

        <label>E-mail:</label>
        <input type="email" name="email" required>

        <label>Senha:</label>
        <input type="password" name="senha" required>

        <label>Foto de perfil:</label>
        <input type="file" name="foto" accept="image/png, image/jpeg">

        <button type="submit">Criar Conta</button>
    </form>
</div>

</body>
</html>
