<?php
session_start();

if (!isset($_GET['email']) || empty($_GET['email'])) {
    header("Location: registar.php?erro=Email não encontrado. Faça o registo novamente.");
    exit();
}

$email = $_GET['email'];
$erro = isset($_GET['erro']) ? $_GET['erro'] : "";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Verificar Conta</title>
</head>
<body>

<h2>Verificação de Email</h2>

<?php if ($erro): ?>
    <p style="color:red;"><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

<p>Enviámos um código de 6 dígitos para <strong><?= htmlspecialchars($email) ?></strong></p>

<form action="confirmar_pin.php" method="POST">
    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">

    <label>Introduza o PIN:</label>
    <input type="text" name="pin" maxlength="6" required>

    <button type="submit">Verificar</button>
</form>

</body>
</html>
