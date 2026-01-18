<?php
session_start();

/* Apenas admin master pode editar outros utilizadores */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

/* Buscar dados do admin logado */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$idAdmin = $_SESSION["id"];

$stmtAdmin = $conn->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmtAdmin->bind_param("i", $idAdmin);
$stmtAdmin->execute();
$adminData = $stmtAdmin->get_result()->fetch_assoc();

$nome = $adminData["nome"];
$fotoLogado = $adminData["foto"] ?: "img/default.png";
$role = $adminData["role_id"];

/* Verifica se recebeu ID por GET */
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$idUser = (int) $_GET['id'];

/* Buscar dados do utilizador a editar */
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
<link rel="stylesheet" href="css/editar_perfil.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<!-- ============================
     MENU DO ADMIN
=============================== -->
<div class="painel-menu">

    <div class="painel-user">
        <img src="<?php echo htmlspecialchars($fotoLogado); ?>" class="painel-foto" alt="Foto">
        <span class="painel-ola">Olá, <?php echo htmlspecialchars($nome); ?></span>
    </div>

    <div class="painel-toggle" onclick="togglePainelMenu()">
        <span id="painel-icon">☰</span>
    </div>

    <div class="painel-links" id="painelLinks">
        <a href="index.php">Voltar ao Site</a>
        <a href="editar_perfil.php">Editar Perfil</a>

        <?php if ($role == 1): ?>
            <a href="admin_inscricoes.php">Inscrições</a>
            <a href="notificacoes_admin.php" class="notif-icon">
                    <i class="fa-solid fa-bell"></i>
                </a>
            <a href="criar_admin.php">Criar Admin</a>
            <a href="criar_viewer.php">Criar Viewer</a>
        <?php endif; ?>

        <a href="logout.php">Sair</a>
    </div>
</div>

<script>
function togglePainelMenu() {
    const menu = document.getElementById("painelLinks");
    const icon = document.getElementById("painel-icon");

    menu.classList.toggle("show");
    icon.textContent = menu.classList.contains("show") ? "✖" : "☰";
}
</script>

<!-- ============================
     FORMULÁRIO
=============================== -->
<div class="perfil-container">
    <div class="perfil-card">

        <h2>Editar Utilizador</h2>

        <form action="processar_editar_user.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

            <div class="foto-area">
                <img src="<?php echo htmlspecialchars($user['foto'] ?: 'img/default.png'); ?>" 
                     class="foto-preview" alt="Foto">
            </div>

            <label>Alterar foto de perfil:</label>
            <input type="file" name="foto" class="input-file">

            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label>Função:</label>
            <select name="role_id" class="input-file" required>
                <option value="1" <?php if ($user['role_id'] == 1) echo 'selected'; ?>>Admin Master</option>
                <option value="2" <?php if ($user['role_id'] == 2) echo 'selected'; ?>>Admin</option>
                <option value="3" <?php if ($user['role_id'] == 3) echo 'selected'; ?>>Viewer</option>
            </select>

            <button type="submit" class="btn-guardar">Guardar Alterações</button>
            <a href="admin.php" class="btn-voltar">Voltar</a>

        </form>
    </div>
</div>
<?php include 'eliminar_perfil.php'; ?>
</body>
</html>
