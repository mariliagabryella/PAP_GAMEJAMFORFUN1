<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se está logado e se é Admin (1) ou Admin Normal (2)
if (!isset($_SESSION["id"]) || !isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["id"];
$role = $_SESSION["role_id"];

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* Buscar dados do utilizador logado para o Menu */
$stmt = $conn->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$nome = $user["nome"];
$fotoLogado = $user["foto"] ?: "img/default.png";

// Verificar se há notificações não lidas para o ícone do menu
$stmt_notif = $conn->prepare("SELECT COUNT(*) as total FROM notificacoes WHERE user_id = ? AND lida = 0 AND apagada = 0");
$stmt_notif->bind_param("i", $id_user);
$stmt_notif->execute();
$notifs_nao_lidas = $stmt_notif->get_result()->fetch_assoc()['total'];
$tem_notif = $notifs_nao_lidas > 0 ? 'tem-notif' : '';

?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Site | Painel Premium</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <div class="painel-menu">
        <div class="painel-user">
            <img src="<?php echo htmlspecialchars($fotoLogado); ?>" class="painel-foto" alt="Foto">
            <span class="painel-ola">Olá, <span class="destaque-nome"><?php echo htmlspecialchars($nome); ?></span></span>
        </div>


        <div class="painel-links" id="painelLinks">
            <a href="index.php"><i class="fa-solid fa-house"></i> Site</a>
            <a href="editar_perfil.php"><i class="fa-solid fa-user-pen"></i> Perfil</a>

            <?php if ($role == 1 || $role == 2): ?>
                <a href="admin.php">Painel</a>
            <?php endif; ?>

            <?php if ($role == 2): ?>
                        <a href="eliminar_perfil.php" class="danger"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>

            <?php endif; ?>

            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">
        <div class="cabecalho-dashboard">
            <h1 class="titulo-painel">Gestor de <span class="glow-text">Páginas</span></h1>
        </div>

        <p class="subtitulo-painel">Escolha a secção do site que deseja personalizar.</p>

        <div class="cards-grid">
            
            <div class="dashboard-card glass-panel">
                <div class="card-icon" style="color: #3498db;"><i class="fa-solid fa-house-chimney-window"></i></div>
                <h3>Página Inicial</h3>
                <p>Edita o banner principal, a secção "Sobre Nós" e os destaques visíveis na página de entrada.</p>
                <a href="editar_index.php" class="btn-primario">Editar <i class="fa-solid fa-arrow-right"></i></a>
            </div>


            <div class="dashboard-card glass-panel">
                <div class="card-icon" style="color: #f1c40f;"><i class="fa-solid fa-layer-group"></i></div>
                <h3>Gerir Edições</h3>
                <p>Visualiza e gere o histórico de todas as Game Jams anteriores e as suas informações.</p>
                <a href="admin_edicoes.php" class="btn-primario">Gerir <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="dashboard-card glass-panel">
                <div class="card-icon" style="color: #2ecc71;"><i class="fa-solid fa-envelope-open-text"></i></div>
                <h3>Página de Contacto</h3>
                <p>Atualiza os emails de suporte, formulários e textos descritivos da página de contactos.</p>
                <a href="admin_contactos_pagina.php" class="btn-primario">Editar <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="dashboard-card glass-panel">
                <div class="card-icon" style="color: #9b59b6;"><i class="fa-solid fa-clipboard-list"></i></div>
                <h3>Página de Inscrição</h3>
                <p>Altera as regras, instruções e os textos de ajuda que os professores vêem ao inscrever-se.</p>
                <a href="admin_inscricao_pagina.php" class="btn-primario">Editar <i class="fa-solid fa-arrow-right"></i></a>
            </div>

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
</body>
</html>