<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["id"];

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

$sql = "SELECT * FROM notificacoes WHERE user_id = $id_user ORDER BY data DESC";
$res = $conn->query($sql);

/* Marcar todas como lidas */
$conn->query("UPDATE notificacoes SET lida = 1 WHERE user_id = $id_user");
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Notificações</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<?php include 'menu.php'; ?>

<div class="admin-content">
    <h1>Notificações</h1>

    <?php if ($res->num_rows == 0): ?>
        <p>Não tem notificações.</p>
    <?php else: ?>
        <ul>
        <?php while ($n = $res->fetch_assoc()): ?>
            <li>
                <strong><?php echo $n["data"]; ?>:</strong>
                <?php echo htmlspecialchars($n["mensagem"]); ?>
            </li>
        <?php endwhile; ?>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>
