<?php
/* ============================================================
   INICIAR SESSÃO E LIGAR À BASE DE DADOS
   ============================================================ */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* ============================================================
   BUSCAR DADOS DO UTILIZADOR LOGADO
   ============================================================ */
$userId = $_SESSION["id"] ?? null;

if (!$userId) {
    header("Location: login.php?erro=Precisa+de+iniciar+sessao");
    exit();
}

$stmt = $conn->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$nome = $user["nome"];
$fotoLogado = $user["foto"] ?: "img/default.png";
$role = $user["role_id"];

/* ============================================================
   BUSCAR INSCRIÇÕES
   ============================================================ */
$sql = "SELECT i.*, u.nome AS nome_user
        FROM inscricoes i
        LEFT JOIN utilizadores u ON i.user_id = u.id
        ORDER BY i.data_inscricao DESC";
$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Gestão de Inscrições</title>
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<!-- ============================================================
     MENU SUPERIOR DO PAINEL (COM FOTO + OLÁ + NOME + LINKS)
     ============================================================ -->
<div class="painel-menu">

    <!-- FOTO + OLÁ + NOME -->
    <div class="painel-user">
        <img src="<?php echo htmlspecialchars($fotoLogado); ?>" class="painel-foto" alt="Foto">
        <span class="painel-ola">Olá, <?php echo htmlspecialchars($nome); ?></span>
    </div>

    <!-- ÍCONE HAMBURGER (MOBILE) -->
    <div class="painel-toggle" onclick="togglePainelMenu()">
        <span id="painel-icon">☰</span>
    </div>

    <!-- LINKS DO MENU -->
    <div class="painel-links" id="painelLinks">
        <a href="index.php">Voltar ao Site</a>
        <a href="editar_perfil.php">Editar Perfil</a>

        <?php if ($role == 1): ?>

             <a href="admin.php">Painel Admin Master</a>
            <a href="admin_inscricoes.php">Inscrições</a>
             <a href="notificacoes_admin.php" class="notif-icon">
                    <i class="fa-solid fa-bell"></i>
                </a>
            <a href="criar_admin.php">Criar Admin</a>
            <a href="criar_viewer.php">Criar Viewer</a>
        <?php endif; ?>

        <?php if  ($role == 2): ?>
            <!-- MENU ADMIN NORMAL -->
            <a href="admin.php">Painel Admin</a>
            <a href="admin_inscricoes.php">Inscrições</a>
             <a href="notificacoes_admin.php" class="notif-icon">
                    <i class="fa-solid fa-bell"></i>
                </a>
            <a href="#" class="danger" onclick="abrirPopupEliminar()">Eliminar Perfil</a>
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

<!-- ============================================================
     CONTEÚDO PRINCIPAL — TABELA DE INSCRIÇÕES
     ============================================================ -->
<div class="admin-content">
    <h1>Inscrições - Game Jam For Fun 25</h1>

    <table class="tabela-inscricoes">
        <tr>
            <th>ID</th>
            <th>Utilizador</th>
            <th>Instituição</th>
            <th>Professor</th>
            <th>Email Professor</th>
            <th>Plataforma</th>
            <th>Linguagem</th>
            <th>Nº Participantes</th>
            <th>Estado</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>

        <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['nome_user'] ? htmlspecialchars($row['nome_user']) : "<i>Sem utilizador</i>"; ?></td>
            <td><?php echo htmlspecialchars($row['instituicao']); ?></td>
            <td><?php echo htmlspecialchars($row['professor']); ?></td>
            <td><?php echo htmlspecialchars($row['email_professor']); ?></td>
            <td><?php echo htmlspecialchars($row['plataforma']); ?></td>
            <td>
                <?php 
                echo htmlspecialchars($row['linguagem']);
                if (!empty($row['linguagem_outra'])) {
                    echo " (" . htmlspecialchars($row['linguagem_outra']) . ")";
                }
                ?>
            </td>
            <td><?php echo (int)$row['num_participantes']; ?></td>
            <td><?php echo ucfirst($row['estado']); ?></td>
            <td><?php echo $row['data_inscricao']; ?></td>

            <td class="acoes">
                <?php if ($row['estado'] == 'pendente'): ?>
                    <a class="btn-aprovar" href="aprovar_inscricoes.php?id=<?php echo $row['id']; ?>">✔ Aprovar</a>
                    <a class="btn-rejeitar" href="rejeitar_inscricao.php?id=<?php echo $row['id']; ?>">✖ Rejeitar</a>
                <?php elseif ($row['estado'] == 'aprovado'): ?>
                    <span class="estado-aprovado">Aprovada</span>
                <?php else: ?>
                    <span class="estado-rejeitado">Rejeitada</span>
                <?php endif; ?>

                <a class="btn-editar" href="editar_inscricao.php?id=<?php echo $row['id']; ?>">✎ Editar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php include 'eliminar_perfil.php'; ?>
</body>
</html>
