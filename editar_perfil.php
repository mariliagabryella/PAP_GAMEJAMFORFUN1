<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Tem de estar logado */
if (!isset($_SESSION["usuarioEmail"])) {
    header("Location: login.php");
    exit();
}

$emailSessao = $_SESSION["usuarioEmail"];

/* Conexão BD */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$stmt = $conn->prepare("SELECT id, nome, email, foto, role_id FROM utilizadores WHERE email = ?");
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

$nome = $user["nome"];
$email = $user["email"];
$foto = $user["foto"] ?: "img/default.png";
$role = $user["role_id"];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Editar Perfil</title>
<link rel="stylesheet" href="css/editar_perfil.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<!-- ============================
     MENU DINÂMICO POR ROLE
=============================== -->
<div class="painel-menu">
    <div class="painel-user">
        <img src="<?php echo htmlspecialchars($foto); ?>" class="painel-foto" alt="Foto">
        <span class="painel-ola">
            Olá, <?php echo htmlspecialchars($nome); ?>
            <?php 
                if ($role == 1) echo "(Admin Master)";
                elseif ($role == 2) echo "(Admin)";
                else echo "(Viewer)";
            ?>
        </span>
    </div>

    <div class="painel-toggle" onclick="togglePainelMenu()">
        <span id="painel-icon">☰</span>
    </div>

    <div class="painel-links" id="painelLinks">

        <a href="index.php">Voltar ao Site</a>
        <a href="editar_perfil.php">Editar Perfil</a>

        <?php if ($role == 1): ?>
            <!-- MENU ADMIN MASTER -->
            <a href="admin.php">Painel Admin Master</a>
            <a href="admin_inscricoes.php">Inscrições</a>
            <a href="criar_admin.php">Criar Admin</a>
            <a href="criar_viewer.php">Criar Viewer</a>
           

        <?php elseif ($role == 2): ?>
            <!-- MENU ADMIN NORMAL -->
            <a href="admin.php">Painel Admin</a>
            <a href="admin_inscricoes.php">Inscrições</a>
            <a href="#" class="danger" onclick="abrirPopupEliminar()">Eliminar Perfil</a>

        <?php else: ?>
            <!-- MENU VIEWER -->
            <a href="painel_do_viewer.php">Painel</a>
            <a href="#" class="danger" onclick="abrirPopupEliminar()">Eliminar Perfil</a>
            <a href="notificacoes.php"><i class="fa-solid fa-bell"></i></a>
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
     FORMULÁRIO MODERNO
=============================== -->
<div class="perfil-container">
    <div class="perfil-card">

        <h2>Editar Perfil</h2>

        <form action="processar_editar_perfil.php" method="POST" enctype="multipart/form-data">

            <div class="foto-area">
                <img src="<?php echo htmlspecialchars($foto); ?>" class="foto-preview" alt="Foto de perfil">
            </div>

            <label>Nova foto de perfil:</label>
            <input type="file" name="foto" class="input-file">

            <label>Nome:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <button type="submit" class="btn-guardar">Guardar Alterações</button>
        </form>
    </div>
</div>

<?php include 'eliminar_perfil.php'; ?>

</body>
</html>
