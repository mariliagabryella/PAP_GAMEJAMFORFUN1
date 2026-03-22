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

/* Buscar dados do utilizador logado para o Menu */
$stmt = $conn->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$nome = $user["nome"];
$fotoLogado = $user["foto"] ?: "img/default.png";
$role = $user["role_id"]; // <-- Faltava isto para o menu saber quem é quem!

/* Buscar notificações APAGADAS (Lixo) */
$sql = "SELECT * FROM notificacoes WHERE user_id = ? AND apagada = 1 ORDER BY data DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Lixo | Notificações</title>
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
                <a href="#" class="danger" onclick="abrirPopupEliminar()"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>
            <?php endif; ?>

            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">
        <div class="cabecalho-dashboard">
            <a href="notificacoes_admin.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
            <h1 class="titulo-painel">Lixo das <span class="glow-text">Notificações</span></h1>
        </div>

        <section class="secao glass-panel">
            <h2 class="secao-titulo"><i class="fa-solid fa-trash-can"></i> Mensagens Eliminadas</h2>

            <div class="notif-container">
                <?php if ($res->num_rows == 0): ?>
                    <div class="sem-notif">
                        <i class="fa-solid fa-wind"></i>
                        <p>O lixo está vazio.</p>
                    </div>
                <?php else: ?>
                    <div class="notif-list">
                    <?php while ($n = $res->fetch_assoc()): ?>
                        <div class="notif-card lida">
                            <div class="notif-icone">
                                <i class="fa-solid fa-trash-can" style="color: var(--text-muted);"></i>
                            </div>
                            
                            <div class="notif-conteudo">
                                <p class="notif-mensagem" style="text-decoration: line-through; color: var(--text-muted);"><?php echo htmlspecialchars($n["mensagem"]); ?></p>
                                <span class="notif-data"><?php echo date("d/m/Y H:i", strtotime($n["data"])); ?></span>
                            </div>

                            <div class="notif-acoes">
                                <a href="acao_notificacao.php?acao=restaurar&id=<?php echo $n['id']; ?>" class="acao aprovar tooltip" title="Restaurar">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </a>
                                <a href="acao_notificacao.php?acao=destruir&id=<?php echo $n['id']; ?>" class="acao rejeitar tooltip" title="Apagar Definitivamente">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
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