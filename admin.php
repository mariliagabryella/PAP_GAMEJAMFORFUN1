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

$nome  = $_SESSION["usuarioNome"];
$email = $_SESSION["usuarioEmail"];
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
   ESTATÍSTICAS SIMPLES PARA OS CARDS DO PAINEL
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
   FILTROS DE BUSCA (nome/email) E ROLE
   ============================================================ */

// Parâmetros GET
$busca   = isset($_GET['busca']) ? trim($_GET['busca']) : '';
$filtroRole = isset($_GET['filtroRole']) ? (int)$_GET['filtroRole'] : 0;

// Construção dinâmica do WHERE
$where = " WHERE 1=1 ";
$params = [];
$types  = "";

// Filtro de texto (nome ou email)
if ($busca !== '') {
    $where .= " AND (nome LIKE ? OR email LIKE ?) ";
    $buscaLike = "%" . $busca . "%";
    $params[] = $buscaLike;
    $params[] = $buscaLike;
    $types   .= "ss";
}

// Filtro de role (1,2,3)
if ($filtroRole > 0) {
    $where .= " AND role_id = ? ";
    $params[] = $filtroRole;
    $types   .= "i";
}

/* ============================================================
   BUSCAR UTILIZADORES PARA A TABELA
   - Admin Master (1) vê tudo
   - Admin (2) também vê, mas não pode editar/eliminar
   ============================================================ */
$sql = "
    SELECT 
        id,
        nome,
        email,
        role_id,
        criado_em,
        ativo,
        foto
    FROM utilizadores
    $where
    ORDER BY criado_em DESC
";

$users = [];

if ($types !== "") {
    // Query com parâmetros
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        die("Erro na query de utilizadores: " . $conn->error);
    }
    $users = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    // Query simples sem parâmetros
    $result = $conn->query($sql);
    if ($result === false) {
        die("Erro na query de utilizadores: " . $conn->error);
    }
    $users = $result->fetch_all(MYSQLI_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
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

            <?php if ($role == 2): ?>
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
     CONTEÚDO PRINCIPAL
     ============================================================ -->
    <div class="admin-content">

        <h1>Painel Administrativo</h1>
        <p>Bem-vindo(a), <?php echo htmlspecialchars($nome); ?>.</p>

        <!-- ========================================================
         CARDS DE ESTATÍSTICAS
         ======================================================== -->
        <div class="cards-dashboard">
            <div class="card-dashboard">
                <span class="card-label">Total de Utilizadores</span>
                <span class="card-value"><?php echo $totalUsers; ?></span>
            </div>

            <div class="card-dashboard">
                <span class="card-label">Admins</span>
                <span class="card-value"><?php echo $totalAdmins; ?></span>
            </div>

            <div class="card-dashboard">
                <span class="card-label">Viewers</span>
                <span class="card-value"><?php echo $totalViewers; ?></span>
            </div>

            <?php if ($ultimoUser): ?>
                <div class="card-dashboard">
                    <span class="card-label">Último Utilizador</span>
                    <span class="card-value"><?php echo htmlspecialchars($ultimoUser['nome']); ?></span>
                    <span class="card-extra"><?php echo htmlspecialchars($ultimoUser['email']); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <!-- ========================================================
         FILTROS / BUSCA
         ======================================================== -->
        <form method="GET" class="filtros-form">
            <div class="filtro-item">
                <label>Buscar (nome ou email):</label>
                <input type="text" name="busca" value="<?php echo htmlspecialchars($busca); ?>" placeholder="Digite para filtrar...">
            </div>

            <div class="filtro-item">
                <label>Função:</label>
                <select name="filtroRole">
                    <option value="0">Todas</option>
                    <option value="1" <?php if ($filtroRole == 1) echo 'selected'; ?>>Admin Master</option>
                    <option value="2" <?php if ($filtroRole == 2) echo 'selected'; ?>>Admin</option>
                    <option value="3" <?php if ($filtroRole == 3) echo 'selected'; ?>>Viewer</option>
                </select>
            </div>

            <button type="submit" class="btn-filtrar">
                <i class="fa-solid fa-magnifying-glass"></i> Filtrar
            </button>

            <a href="admin.php" class="btn-filtrar limpar">
                Limpar
            </a>
        </form>

        <!-- ========================================================
         GESTÃO DE UTILIZADORES
         ======================================================== -->
        <h2>Gestão de Utilizadores</h2>

        <div class="tabela-container">
            <table class="tabela-users">
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Função</th>
                    <th>Criado em</th>
                    <th>Último Ativo</th>
                    <th>Ações</th>
                </tr>

                <?php foreach ($users as $u): ?>
                    <tr>
                        <td>
                            <img src="<?php echo htmlspecialchars($u['foto'] ?: 'img/default.png'); ?>"
                                class="foto-mini" alt="Foto">
                        </td>

                        <td><?php echo htmlspecialchars($u['nome']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>

                        <td>
                            <!-- Badge de role -->
                            <?php if ($u['role_id'] == 1): ?>
                                <span class="badge badge-master">Admin Master</span>
                            <?php elseif ($u['role_id'] == 2): ?>
                                <span class="badge badge-admin">Admin</span>
                            <?php else: ?>
                                <span class="badge badge-viewer">Viewer</span>
                            <?php endif; ?>
                        </td>

                        <td><?php echo htmlspecialchars($u['criado_em']); ?></td>

                        <td><?php echo $u['ativo'] ? htmlspecialchars($u['ativo']) : "Nunca"; ?></td>

                        <td class="acoes">
                            <?php if ($role == 1): ?>
                                <!-- ADMIN MASTER: pode editar e eliminar (exceto ID 1, se quiseres proteger) -->
                                <a href="editar_user.php?id=<?php echo $u['id']; ?>"
                                    class="acao editar" title="Editar utilizador">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <?php if ($u['id'] != 1): ?>
                                    <a href="eliminar_user.php?id=<?php echo $u['id']; ?>"
                                        class="acao eliminar"
                                        title="Eliminar utilizador"
                                        onclick="return confirm('Tem certeza que deseja eliminar este utilizador?');">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                <?php endif; ?>

                            <?php elseif ($role == 2): ?>
                                <!-- ADMIN NORMAL: pode apenas recuperar password -->
                                <a href="recuperar_password.php?id=<?php echo $u['id']; ?>"
                                    class="acao editar"
                                    title="Recuperar password">
                                    <i class="fa-solid fa-key"></i>
                                </a>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

    </div>
    <?php include 'eliminar_perfil.php'; ?>
</body>

</html>