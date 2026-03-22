<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ============================================================
   PERMISSÕES
   adminmaster (1) e admin (2) podem entrar
   viewer (3) NÃO entra neste painel
   ============================================================ */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    header("Location: login.php");
    exit();
}

$nome  = $_SESSION["nome"];
$email = $_SESSION["email"];
$role  = $_SESSION["role_id"];

/* ============================================================
   CONEXÃO COM A BASE DE DADOS
   ============================================================ */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* ============================================================
   BUSCAR FOTO DO UTILIZADOR LOGADO PARA O MENU
   ============================================================ */
$fotoLogado = "img/default.png";

$stmtFoto = $conn->prepare("SELECT foto FROM utilizadores WHERE email = ?");
$stmtFoto->bind_param("s", $email);
$stmtFoto->execute();
$resFoto = $stmtFoto->get_result();
if ($resFoto->num_rows === 1) {
    $rowFoto = $resFoto->fetch_assoc();
    if (!empty($rowFoto['foto'])) {
        $fotoLogado = $rowFoto['foto'];
    }
}
$stmtFoto->close();

/* ============================================================
   ESTATÍSTICAS PARA OS CARDS E GRÁFICO
   ============================================================ */
$totalUsers = 0;
$res = $conn->query("SELECT COUNT(*) AS total FROM utilizadores");
if ($res && $row = $res->fetch_assoc()) {
    $totalUsers = (int)$row['total'];
}

$totalAdmins = 0;
$res = $conn->query("SELECT COUNT(*) AS total FROM utilizadores WHERE role_id = 2");
if ($res && $row = $res->fetch_assoc()) {
    $totalAdmins = (int)$row['total'];
}

$totalViewers = 0;
$res = $conn->query("SELECT COUNT(*) AS total FROM utilizadores WHERE role_id = 3");
if ($res && $row = $res->fetch_assoc()) {
    $totalViewers = (int)$row['total'];
}

// Calcula os Admin Masters
$totalMasters = $totalUsers - $totalAdmins - $totalViewers;

/* Último utilizador criado */
$ultimoUser = null;
$res = $conn->query("
    SELECT nome, email, criado_em 
    FROM utilizadores 
    ORDER BY criado_em DESC 
    LIMIT 1
");
if ($res && $res->num_rows === 1) {
    $ultimoUser = $res->fetch_assoc();
}

/* ============================================================
   FILTROS DE BUSCA E ROLE
   ============================================================ */
$busca   = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$filtroRole = isset($_GET['filtroRole']) ? (int)$_GET['filtroRole'] : 0;

$where = " WHERE 1=1 ";
$params = [];
$types  = "";

if ($busca !== '') {
    $where .= " AND (nome LIKE ? OR email LIKE ?) ";
    $buscaLike = "%" . $busca . "%";
    $params[] = $buscaLike;
    $params[] = $buscaLike;
    $types   .= "ss";
}

if ($filtroRole > 0) {
    $where .= " AND role_id = ? ";
    $params[] = $filtroRole;
    $types   .= "i";
}

/* ============================================================
   BUSCAR UTILIZADORES
   ============================================================ */
$sql = "SELECT id, nome, email, role_id, criado_em, ativo, foto FROM utilizadores $where ORDER BY criado_em DESC";
$users = [];

if ($types !== "") {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $result = $conn->query($sql);
    $users = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo Premium</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Estilo rápido para a mensagem de sucesso para não teres de mexer mais no CSS */
        .msg-sucesso {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid #10b981;
            color: #10b981;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            animation: fadeInDown 0.5s ease-out;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
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

            <?php if ($role == 2): ?>
                

                <a href="eliminar_perfil.php" class="danger"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>
            <?php endif; ?>

            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">

        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'utilizador_criado'): ?>
            <div class="msg-sucesso">
                <i class="fa-solid fa-circle-check"></i> 
                Novo utilizador criado e guardado com sucesso!
            </div>
        <?php endif; ?>

        <div class="cabecalho-dashboard">
            <h1 class="titulo-painel">Dashboard <span class="glow-text">Overview</span></h1>
        </div>

        
            <section class="secao glass-panel">
                <h2 class="secao-titulo"><i class="fa-solid fa-bolt"></i> Acesso Rápido</h2>
                <div class="atalhos-container">
                    <a href="admin_inscricoes.php" class="atalho-card"><i class="fa-solid fa-file-lines"></i><span>Inscrições</span></a>
                    <a href="notificacoes_admin.php" class="atalho-card"><i class="fa-solid fa-bell"></i><span>Notificações</span></a>
                    <a href="editar_site.php" class="atalho-card"><i class="fa-solid fa-pen-to-square"></i><span>Editar Site</span></a>
       <?php if ($role == 1): ?>
                   <a href="criar_utilizador.php" class="atalho-card">
    <i class="fa-solid fa-user-plus"></i>
    <span>Criar Utilizador</span>
</a>
        <?php endif; ?>             

                </div>
            </section>
    

        <section class="secao stats-section">
            <div class="stats-cards glass-panel">
                <h2 class="secao-titulo"><i class="fa-solid fa-chart-simple"></i> Números Globais</h2>
                <div class="cards-dashboard">
                    <div class="card-dashboard">
                        <i class="fa-solid fa-users bg-icon"></i>
                        <span class="card-label">Total Utilizadores</span>
                        <span class="card-value"><?php echo $totalUsers; ?></span>
                    </div>
                    <div class="card-dashboard">
                        <i class="fa-solid fa-user-tie bg-icon"></i>
                        <span class="card-label">Administradores</span>
                        <span class="card-value text-blue"><?php echo $totalAdmins; ?></span>
                    </div>
                    <div class="card-dashboard">
                        <i class="fa-solid fa-glasses bg-icon"></i>
                        <span class="card-label">Viewers</span>
                        <span class="card-value text-green"><?php echo $totalViewers; ?></span>
                    </div>
                </div>
                
                <?php if ($ultimoUser): ?>
                    <div class="card-ultimo-user mt-4">
                        <span class="card-label">Último Registo:</span>
                        <strong><?php echo htmlspecialchars($ultimoUser['nome']); ?></strong> 
                        <span class="text-muted">(<?php echo htmlspecialchars($ultimoUser['email']); ?>)</span>
                    </div>
                <?php endif; ?>
            </div>

            <div class="stats-chart glass-panel">
                <h2 class="secao-titulo"><i class="fa-solid fa-chart-pie"></i> Distribuição</h2>
                <div class="chart-container">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </section>

        <section class="secao glass-panel">
            <h2 class="secao-titulo"><i class="fa-solid fa-filter"></i> Filtros de Pesquisa</h2>
            <form method="GET" class="filtros-form">
                <div class="filtro-item">
                    <input type="text" name="busca" value="<?php echo htmlspecialchars($busca); ?>" placeholder="Buscar por nome ou email...">
                </div>
                <div class="filtro-item">
                    <select name="filtroRole">
                        <option value="0">Qualquer Função</option>
                        <option value="1" <?php if ($filtroRole == 1) echo 'selected'; ?>>Admin Master</option>
                        <option value="2" <?php if ($filtroRole == 2) echo 'selected'; ?>>Admin</option>
                        <option value="3" <?php if ($filtroRole == 3) echo 'selected'; ?>>Viewer</option>
                    </select>
                </div>
                <button type="submit" class="btn-acao btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Filtrar</button>
                <a href="admin.php" class="btn-acao btn-secondary">Limpar</a>
            </form>
        </section>

        <section class="secao glass-panel">
            <h2 class="secao-titulo"><i class="fa-solid fa-users-gear"></i> Gestão de Utilizadores</h2>
            <div class="tabela-container">
                <table class="tabela-users">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Função</th>
                            <th>Registo</th>
                            <th>Último Acesso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td><img src="<?php echo htmlspecialchars($u['foto'] ?: 'img/default.png'); ?>" class="foto-mini"></td>
                                <td class="fw-bold"><?php echo htmlspecialchars($u['nome']); ?></td>
                                <td class="text-muted"><?php echo htmlspecialchars($u['email']); ?></td>
                                <td>
                                    <?php if ($u['role_id'] == 1): ?>
                                        <span class="badge badge-master">Master</span>
                                    <?php elseif ($u['role_id'] == 2): ?>
                                        <span class="badge badge-admin">Admin</span>
                                    <?php else: ?>
                                        <span class="badge badge-viewer">Viewer</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($u['criado_em']); ?></td>
                                <td>
                                    <?php if($u['ativo']): ?>
                                        <span class="status-dot online"></span> <?php echo htmlspecialchars($u['ativo']); ?>
                                    <?php else: ?>
                                        <span class="status-dot offline"></span> Nunca
                                    <?php endif; ?>
                                </td>
                                <td class="acoes">
                                    <?php if ($role == 1): ?>
                                        <a href="editar_user.php?id=<?php echo $u['id']; ?>" class="acao editar tooltip" data-tooltip="Editar"><i class="fa-solid fa-pen"></i></a>
                                        <?php if ($u['id'] != 1): ?>
                                            <a href="eliminar_user.php?id=<?php echo $u['id']; ?>" class="acao eliminar tooltip" data-tooltip="Eliminar" onclick="return confirm('Eliminar este utilizador?');"><i class="fa-solid fa-trash"></i></a>
                                        <?php endif; ?>
                                    <?php elseif ($role == 2): ?>
                                        <a href="recuperar_password.php?id=<?php echo $u['id']; ?>" class="acao editar tooltip" data-tooltip="Recuperar Password"><i class="fa-solid fa-key"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>

    <script>
        // Menu Mobile
        function togglePainelMenu() {
            const menu = document.getElementById("painelLinks");
            const icon = document.getElementById("painel-icon");
            menu.classList.toggle("show");
            icon.textContent = menu.classList.contains("show") ? "✖" : "☰";
        }

        // Gráfico de Utilizadores
        const ctx = document.getElementById('usersChart').getContext('2d');
        const usersChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Admin Master', 'Admins', 'Viewers'],
                datasets: [{
                    data: [<?php echo $totalMasters; ?>, <?php echo $totalAdmins; ?>, <?php echo $totalViewers; ?>],
                    backgroundColor: [
                        'rgba(255, 193, 7, 0.8)', // Amarelo
                        'rgba(52, 152, 219, 0.8)', // Azul
                        'rgba(46, 204, 113, 0.8)'  // Verde
                    ],
                    borderColor: [
                        'rgba(255, 193, 7, 1)',
                        'rgba(52, 152, 219, 1)',
                        'rgba(46, 204, 113, 1)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#e2e8f0', font: { family: 'Poppins', size: 13 } }
                    }
                }
            }
        });
    </script>
</body>
</html>