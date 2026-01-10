<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexão com o banco de dados
$host = '127.0.0.1';
$dbname = 'gamejamforfun2';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    error_log('DB connect error: ' . $conn->connect_error);
}

function getMenuItems($conn) {
    $items = [];
    $sql = "SELECT id_menu, titulo, url, pai_id FROM menus WHERE ativo = 1 ORDER BY ordem ASC";
    if ($result = $conn->query($sql)) {
        $items = $result->fetch_all(MYSQLI_ASSOC);
    }
    return $items;
}

$menuItems = getMenuItems($conn);

function buildMenuTree($items, $parentId = null) {
    $branch = [];
    foreach ($items as $item) {
        if ($item['pai_id'] == $parentId) {
            $children = buildMenuTree($items, $item['id_menu']);
            if ($children) {
                $item['children'] = $children;
            }
            $branch[] = $item;
        }
    }
    return $branch;
}

function renderMenu($menuTree, $currentPage = '') {
    foreach ($menuTree as $item) {
        $hasChildren = isset($item['children']) && count($item['children']) > 0;
        $itemUrl = $item['url'] ?? '#';
        $itemBase = basename(parse_url($itemUrl, PHP_URL_PATH));

        // Ignorar login/logout vindos da BD
        if (in_array(strtolower($itemBase), ['login.php', 'logout.php'])) {
            continue;
        }

        $active = ($itemBase === $currentPage) ? ' class="active"' : '';

        if ($hasChildren) {
            echo '<div class="dropdown">';
            echo '<a href="#">' . htmlspecialchars($item['titulo']) . ' ▾</a>';
            echo '<div class="dropdown-content">';

            foreach ($item['children'] as $child) {
                $childUrl = $child['url'] ?? '#';
                $childBase = basename(parse_url($childUrl, PHP_URL_PATH));
                $childActive = ($childBase === $currentPage) ? ' class="active"' : '';

                echo '<a href="' . htmlspecialchars($childUrl) . '"' . $childActive . '>' . htmlspecialchars($child['titulo']) . '</a>';
            }

            echo '</div></div>';
        } else {
            echo '<a href="' . htmlspecialchars($itemUrl) . '"' . $active . '>' . htmlspecialchars($item['titulo']) . '</a>';
        }
    }
}

$currentPage = basename($_SERVER['PHP_SELF']);
$menuTree = buildMenuTree($menuItems);
?>

<div class="menu">
    <a href="index.php">~
     
        <div class="menu-container">
            <img src="img/logo.png" alt="Logo do Site" class="logo">
        </div>
    </a>

    <div class="menu-links">
        <?php renderMenu($menuTree, $currentPage); ?>
    </div>

    <div class="menu-icon" onclick="toggleMenu()">☰</div>
</div>

<script>
function toggleMenu() {
    const menu = document.querySelector('.menu-links');
    menu.classList.toggle('show');
}
</script>



</html>
