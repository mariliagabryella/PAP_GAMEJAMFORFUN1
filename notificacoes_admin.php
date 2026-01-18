<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["id"];

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

/* Buscar dados do admin */
$stmt = $conn->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$nome = $user["nome"];
$foto = $user["foto"] ?: "img/default.png";
$role = $user["role_id"];

/* Buscar notificações */
$sql = "SELECT * FROM notificacoes WHERE user_id = $id_user ORDER BY data DESC";
$res = $conn->query($sql);

/* Marcar como lidas */
$conn->query("UPDATE notificacoes SET lida = 1 WHERE user_id = $id_user");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Notificações</title>
<link rel="stylesheet" href="css/notificacoes.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>



<div class="notif-container">
    <h2>Notificações</h2>

    <?php if ($res->num_rows == 0): ?>
        <p class="sem-notif">Sem notificações.</p>
    <?php else: ?>
        <div class="notif-list">
        <?php while ($n = $res->fetch_assoc()): ?>
            <div class="notif-card">
                <div class="notif-data">
                    <i class="fa-solid fa-bell"></i>
                    <span><?php echo date("d/m/Y H:i", strtotime($n["data"])); ?></span>
                </div>
                <p><?php echo htmlspecialchars($n["mensagem"]); ?></p>
            </div>
        <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>
<?php include 'eliminar_perfil.php'; ?>
</body>
</html>
