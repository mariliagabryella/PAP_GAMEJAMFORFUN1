<?php
session_start();

/* Apenas adminmaster pode editar outros utilizadores */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

/* Verifica se recebeu ID por GET */
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$idUser = (int) $_GET['id'];

/* Conexão BD */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$stmt = $conn->prepare("SELECT id, nome, email, role_id, foto FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $stmt->close();
    $conn->close();
    header("Location: admin.php");
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
<title>Editar Utilizador</title>
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="admin-content">
    <h2>Editar Utilizador</h2>

    <form action="processar_editar_user.php" method="POST" enctype="multipart/form-data" class="form-card">

        <!-- ID oculto -->
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

        <div class="form-group">
            <label>Foto atual:</label><br>
            <img src="<?php echo htmlspecialchars($user['foto'] ?: 'img/default.png'); ?>" 
                 class="foto-mini-grande" alt="Foto">
        </div>

        <div class="form-group">
            <label>Alterar foto de perfil:</label>
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

        <div class="form-group">
            <label>Função:</label>
            <select name="role_id" required>
                <option value="1" <?php if ($user['role_id'] == 1) echo 'selected'; ?>>Admin Master</option>
                <option value="2" <?php if ($user['role_id'] == 2) echo 'selected'; ?>>Admin</option>
                <option value="3" <?php if ($user['role_id'] == 3) echo 'selected'; ?>>Viewer</option>
            </select>
        </div>

        <button type="submit">Guardar Alterações</button>
        <a href="admin.php" class="btn-voltar">Voltar</a>
    </form>
</div>

</body>
</html>
