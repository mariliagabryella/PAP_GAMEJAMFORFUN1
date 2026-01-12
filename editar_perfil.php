<?php
session_start();

/* Tem de estar logado */
if (!isset($_SESSION["usuarioEmail"])) {
    header("Location: login.php");
    exit();
}

$emailSessao = $_SESSION["usuarioEmail"];

/* Conexão BD */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$stmt = $conn->prepare("SELECT nome, email, foto FROM utilizadores WHERE email = ?");
$stmt->bind_param("s", $emailSessao);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
$conn->close();

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

    <form action="processar_editar_perfil.php" method="POST" enctype="multipart/form-data" class="form-card">

        <div class="form-group">
            <label>Foto atual:</label><br>
            <img src="<?php echo htmlspecialchars($user['foto'] ?: 'img/default.png'); ?>" 
                 class="foto-mini-grande" alt="Foto de perfil">
        </div>

        <div class="form-group">
            <label>Nova foto de perfil:</label>
            <input type="file" name="foto">
        </div>

        <div class="form-group">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <button type="submit">Guardar</button>
        <a href="admin.php" class="btn-voltar">Voltar</a>
    </form>
</div>

</body>
</html>
