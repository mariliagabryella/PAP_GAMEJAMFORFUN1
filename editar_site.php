<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION["role_id"];
$nome = $_SESSION["usuarioNome"];
$email = $_SESSION["usuarioEmail"];

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$fotoLogado = "img/default.png";
$stmt = $conn->prepare("SELECT foto FROM utilizadores WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
if ($res && !empty($res["foto"])) {
    $fotoLogado = $res["foto"];
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Editar Site</title>
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<!-- MENU SUPERIOR -->
<div class="painel-menu">
    <div class="painel-user">
        <img src="<?php echo $fotoLogado; ?>" class="painel-foto">
        <span class="painel-ola">Olá, <?php echo $nome; ?></span>
    </div>

    <div class="painel-toggle" onclick="togglePainelMenu()">
        <span id="painel-icon">☰</span>
    </div>

    <div class="painel-links" id="painelLinks">
        <a href="index.php">Voltar ao Site</a>
        <a href="editar_perfil.php">Editar Perfil</a>
        <a href="editar_site.php" class="active">Editar Site</a>

        <?php if ($role == 1): ?>
            <a href="admin.php">Painel Admin Master</a>
            <a href="admin_inscricoes.php">Inscrições</a>
            <a href="criar_admin.php">Criar Admin</a>
            <a href="criar_viewer.php">Criar Viewer</a>
        <?php endif; ?>

        <?php if ($role == 2): ?>
            <a href="admin.php">Painel Admin</a>
            <a href="admin_inscricoes.php">Inscrições</a>
        <?php endif; ?>

        <a href="logout.php">Sair</a>
    </div>
</div>

<!-- CONTEÚDO -->
<div class="conteudo-admin">
    <h2>Editar Site</h2>
    <p>Escolha a página que deseja editar:</p>

    <div class="editar-site-menu">
        <a href="editar_index.php" class="editar-btn">Página Inicial (Index)</a>
        <a href="editar_sobre.php" class="editar-btn">Sobre Nós</a>
        <a href="editar_localizacao.php" class="editar-btn">Localização</a>
        <a href="editar_edicao.php" class="editar-btn">Edição</a>
        <a href="admin_edicoes.php">Gerir Edições</a>
        <a href="editar_patrocinadores.php" class="editar-btn">Patrocinadores</a>
        <a href="editar_contacto.php" class="editar-btn">Página Contacto</a>
        <a href="editar_inscricao.php" class="editar-btn">Página Inscrição</a>
    </div>
</div>

<style>
.editar-site-menu {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 400px;
}

.editar-btn {
    background: #09122c;
    color: white;
    padding: 12px;
    border-radius: 6px;
    text-align: center;
    font-size: 18px;
    transition: 0.3s;
}

.editar-btn:hover {
    background: #be3144;
}
</style>

<script>
function togglePainelMenu() {
    const menu = document.getElementById("painelLinks");
    const icon = document.getElementById("painel-icon");
    menu.classList.toggle("show");
    icon.textContent = menu.classList.contains("show") ? "✖" : "☰";
}
</script>

</body>
</html>
