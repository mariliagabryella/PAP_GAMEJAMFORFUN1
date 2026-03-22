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
$role = $user["role_id"];

/* Buscar notificações APENAS AS NÃO APAGADAS (apagada = 0) */
$sql = "SELECT * FROM notificacoes WHERE user_id = ? AND apagada = 0 ORDER BY data DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Notificações | Player Hub</title>
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
            <a href="painel_do_viewer.php"><i class="active"></i> Painel</a>
            <a href="eliminar_perfil.php" class="danger"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>
            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">
        <div class="cabecalho-dashboard">
            <h1 class="titulo-painel">Centro de <span class="glow-text">Notificações</span></h1>
        </div>

        <section class="secao glass-panel">
            <div class="header-notificacoes">
                <h2 class="secao-titulo"><i class="fa-solid fa-inbox"></i> As tuas mensagens</h2>
                
                <div class="acoes-notif-header">
                    <?php if ($res->num_rows > 0): ?>
                        <a href="acao_notificacao.php?acao=ler_todas" class="btn-secundario"><i class="fa-solid fa-check-double"></i> Ler Todas</a>
                    <?php endif; ?>
                    <a href="lixo_notificacoes.php" class="btn-secundario btn-lixo"><i class="fa-solid fa-trash-can"></i> Lixo</a>
                </div>
            </div>

            <div class="notif-container-list">
                <?php if ($res->num_rows == 0): ?>
                    <div class="sem-notif">
                        <i class="fa-solid fa-bell-slash"></i>
                        <p>Não tens notificações no momento.</p>
                    </div>
                <?php else: ?>
                    <div class="notif-list">
                    <?php while ($n = $res->fetch_assoc()): ?>
                        
                        <?php $classe_lida = ($n['lida'] == 0) ? 'nao-lida' : 'lida'; ?>
                        
                        <div class="notif-card <?php echo $classe_lida; ?>">
                            <div class="notif-icone">
                                <i class="fa-solid fa-bell"></i>
                            </div>
                            
                            <div class="notif-conteudo">
                                <p class="notif-mensagem"><?php echo htmlspecialchars($n["mensagem"]); ?></p>
                                <span class="notif-data"><i class="fa-regular fa-clock"></i> <?php echo date("d/m/Y H:i", strtotime($n["data"])); ?></span>
                            </div>

                            <div class="notif-acoes">
                                <?php if ($n['lida'] == 0): ?>
                                    <a href="acao_notificacao.php?acao=ler&id=<?php echo $n['id']; ?>" class="acao aprovar tooltip" title="Marcar como lida">
                                        <i class="fa-solid fa-check"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="visto-duplo tooltip" title="Lida">
                                        <i class="fa-solid fa-check-double"></i>
                                    </span>
                                <?php endif; ?>
                                
                                <a href="acao_notificacao.php?acao=apagar&id=<?php echo $n['id']; ?>" class="acao rejeitar tooltip" title="Mover para o Lixo">
                                    <i class="fa-solid fa-trash"></i>
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