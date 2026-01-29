<?php
/* ============================================================
   INICIAR SESSÃO
   ============================================================ */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ============================================================
   CONEXÃO COM A BASE DE DADOS
   ============================================================ */
$host = '127.0.0.1';
$dbname = 'gamejamforfun2';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    error_log('DB connect error: ' . $conn->connect_error);
}

/* ============================================================
   BUSCAR ITENS DO MENU NA BASE DE DADOS
   ============================================================ */
function getMenuItems($conn) {
    $items = [];
    $sql = "SELECT id_menu, titulo, url, pai_id 
            FROM menus 
            WHERE ativo = 1 
            ORDER BY ordem ASC";

    if ($result = $conn->query($sql)) {
        $items = $result->fetch_all(MYSQLI_ASSOC);
    }

    return $items;
}

$menuItems = getMenuItems($conn);

/* ============================================================
   BUSCAR LISTA DE EDIÇÕES
============================================================ */
function getEdicoes($conn) {
    $sql = "SELECT id, edicao_numero FROM edicoes ORDER BY id ASC";
    $result = $conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

$listaEdicoes = getEdicoes($conn);


/* ============================================================
   CONSTRUIR ÁRVORE DE MENUS (SUPORTA SUBMENUS)
   ============================================================ */
function buildMenuTree($items, $parentId = null) {
    $branch = [];

    foreach ($items as $item) {
        if ($item['pai_id'] == $parentId) {

            // Procura filhos (submenus)
            $children = buildMenuTree($items, $item['id_menu']);

            if ($children) {
                $item['children'] = $children;
            }

            $branch[] = $item;
        }
    }

    return $branch;
}

/* ============================================================
   RENDERIZAR MENU PRINCIPAL
   ============================================================ */
function renderMenu($menuTree, $currentPage = '') {

    foreach ($menuTree as $item) {

        $hasChildren = isset($item['children']) && count($item['children']) > 0;
        $itemUrl     = $item['url'] ?? '#';
        $itemBase    = basename(parse_url($itemUrl, PHP_URL_PATH));

        // Ignorar login/logout vindos da BD
        if (in_array(strtolower($itemBase), ['login.php', 'logout.php'])) {
            continue;
        }

        // Marca item ativo
        $active = ($itemBase === $currentPage) ? ' class="active"' : '';

        /* ---------------------------
           ITEM COM SUBMENUS
        ---------------------------- */
        if ($hasChildren) {
            echo '<div class="dropdown">';
            echo '<a href="#">' . htmlspecialchars($item['titulo']) . ' ▾</a>';
            echo '<div class="dropdown-content">';

            foreach ($item['children'] as $child) {
                $childUrl   = $child['url'] ?? '#';
                $childBase  = basename(parse_url($childUrl, PHP_URL_PATH));
                $childActive = ($childBase === $currentPage) ? ' class="active"' : '';

                echo '<a href="' . htmlspecialchars($childUrl) . '"' . $childActive . '>' 
                     . htmlspecialchars($child['titulo']) . '</a>';
            }

            echo '</div></div>';
        }

        /* ---------------------------
           ITEM SEM SUBMENUS
        ---------------------------- */
        else {
            echo '<a href="' . htmlspecialchars($itemUrl) . '"' . $active . '>' 
                 . htmlspecialchars($item['titulo']) . '</a>';
        }
    }
}

/* Página atual */
$currentPage = basename($_SERVER['PHP_SELF']);

/* Constrói árvore final */
$menuTree = buildMenuTree($menuItems);

/* ============================================================
   NOTIFICAÇÕES INTERNAS (CONTADOR)
   ============================================================ */
$notificacoes_nao_lidas = 0;

if (isset($_SESSION["id_utilizador"])) {
    $id_user_menu = $_SESSION["id_utilizador"];

    $sqlNotif = "SELECT COUNT(*) AS total 
                 FROM notificacoes 
                 WHERE user_id = $id_user_menu AND lida = 0";

    $resNotif = $conn->query($sqlNotif);

    if ($resNotif && $rowNotif = $resNotif->fetch_assoc()) {
        $notificacoes_nao_lidas = $rowNotif["total"];
    }
}
?>

<!-- ============================================================
     HTML DO MENU
     ============================================================ -->

<div class="menu">

    <!-- LOGO DO SITE -->
    <a href="index.php">
        <div class="menu-container">
            <img src="img/logo.png" alt="Logo do Site" class="logo">
        </div>
    </a>

    <!-- LINKS DO MENU (DINÂMICOS + ADMIN) -->
    <div class="menu-links" id="menu">


        <!-- Links vindos da BD -->
        <?php renderMenu($menuTree, $currentPage); ?>
        <!-- SUBMENU DAS EDIÇÕES -->
<div class="dropdown">
    <a href="#">Edições ▾</a>
    <div class="dropdown-content">
        <?php foreach ($listaEdicoes as $ed): ?>
            <a href="edicao.php?id=<?php echo $ed['id']; ?>">
                <?php echo htmlspecialchars($ed['edicao_numero']); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>


        <!-- ============================================================
             ÁREA DO UTILIZADOR (LOGIN / PERFIL / ADMIN / LOGOUT)
             ============================================================ -->
        <?php if (!isset($_SESSION["usuarioEmail"])): ?>

            <a href="login.php">Login</a>
            <a href="registar.php">Registar</a>

        <?php else: ?>

            <div class="dropdown">
                <a href="#">Olá, <?php echo htmlspecialchars($_SESSION["usuarioNome"]); ?> ▾</a>
                

                <div class="dropdown-content">

                    <!-- VIEWER -->
                    <?php if ($_SESSION["role_id"] == 3): ?>                       
                        <a href="painel_do_viewer.php">Conta</a>
                        <a href="editar_perfil.php">Editar Perfil</a>
                    <?php endif; ?>

                    <!-- ADMIN NORMAL -->
                    <?php if ($_SESSION["role_id"] == 2): ?>
                        <a href="admin.php">Painel Admin</a>
                        <a href="editar_perfil.php">Editar Perfil</a>
                    <?php endif; ?>

                    <!-- ADMIN MASTER -->
                    <?php if ($_SESSION["role_id"] == 1): ?>
                        <a href="admin.php">Painel Admin Master</a>
                        <a href="editar_perfil.php">Editar Perfil</a>
                    <?php endif; ?>



                    <!-- LOGOUT -->
                    <a href="logout.php">Sair</a>
                </div>
            </div>

        <?php endif; ?>
    </div>

    <!-- ÍCONE DO MENU HAMBURGUER (RESPONSIVO) -->
    <div class="menu-icon" onclick="toggleMenu()">
        <span id="menu-icon-symbol">☰</span>
    </div>
</div>

<!-- ============================================================
     JAVASCRIPT DO MENU RESPONSIVO
     ============================================================ -->
<script>
function toggleMenu() {
    const menu = document.getElementById('menu');
    const icon = document.getElementById('menu-icon-symbol');

    menu.classList.toggle('show');
    icon.textContent = menu.classList.contains('show') ? "✖" : "☰";
}
</script>


</html>
