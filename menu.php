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

        <!-- ============================================================
             ÁREA DO UTILIZADOR (LOGIN / PERFIL / ADMIN / LOGOUT)
             ============================================================ -->
        <?php if (!isset($_SESSION["usuarioEmail"])): ?>

            <!-- Utilizador NÃO está logado -->
            <a href="login.php">Login</a>

        <?php else: ?>

            <!-- Utilizador logado -->
            <div class="dropdown">
                <a href="#">Olá, <?php echo htmlspecialchars($_SESSION["usuarioNome"]); ?> ▾</a>

                <div class="dropdown-content">

                    <!-- Editar perfil -->
                    <a href="editar_perfil.php">Editar Perfil</a>

                    <!-- Apenas administradores -->
                    <?php if ($_SESSION["role_id"] == 1): ?>
                        <a href="admin.php">Painel Admin</a>
                        <a href="criar_admin.php">Criar Admin</a>
                    <?php endif; ?>

                    <!-- Logout -->
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

    // Alterna visibilidade do menu
    menu.classList.toggle('show');

    // Troca ícone
    icon.textContent = menu.classList.contains('show') ? "✖" : "☰";
}
</script>

</html>
