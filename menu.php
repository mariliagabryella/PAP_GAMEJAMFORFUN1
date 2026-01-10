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

$menuItems = [];

function getMenuItems($conn) {
    $items = [];
    $sql = "SELECT id_menu, titulo, url, pai_id FROM menus 
        where ativo = 1
        ORDER BY ordem ASC";
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

function renderMenu($menuTree, $currentPage = '', $isSub = false) {
    foreach ($menuTree as $item) {
        $hasChildren = isset($item['children']) && is_array($item['children']) && count($item['children']) > 0;
        $itemUrl = isset($item['url']) ? $item['url'] : '#';
        $itemUrlPath = parse_url($itemUrl, PHP_URL_PATH);
        $itemBase = $itemUrlPath ? basename($itemUrlPath) : '';

        // Não renderizar itens de login/logout que possam existir na BD
        if (in_array(strtolower($itemBase), ['login.php', 'logout.php'], true)) {
            continue;
        }
        $aClass = ($itemBase === $currentPage) ? ' class="active"' : '';

        if (!$isSub) {
            if ($hasChildren) {
                echo '<div class="dropdown">';
                echo '<a href="#">' . htmlspecialchars($item['titulo'], ENT_QUOTES, 'UTF-8') . ' ▾</a>';
                echo '<div class="dropdown-content">';
                // Render direct children as links (and handle deeper levels)
                foreach ($item['children'] as $child) {
                    $childUrl = isset($child['url']) ? $child['url'] : '#';
                    $childUrlPath = parse_url($childUrl, PHP_URL_PATH);
                    $childBase = $childUrlPath ? basename($childUrlPath) : '';
                    $childClass = ($childBase === $currentPage) ? ' class="active"' : '';

                    if (isset($child['children']) && count($child['children']) > 0) {
                        echo '<div class="dropdown-sub">';
                        echo '<a href="' . htmlspecialchars($childUrl, ENT_QUOTES, 'UTF-8') . '"' . $childClass . '>' . htmlspecialchars($child['titulo'], ENT_QUOTES, 'UTF-8') . '</a>';
                        // deeper children as plain links
                        foreach ($child['children'] as $grand) {
                            $grandUrl = isset($grand['url']) ? $grand['url'] : '#';
                            $grandUrlPath = parse_url($grandUrl, PHP_URL_PATH);
                            $grandBase = $grandUrlPath ? basename($grandUrlPath) : '';
                            $grandClass = ($grandBase === $currentPage) ? ' class="active"' : '';
                            echo '<a href="' . htmlspecialchars($grandUrl, ENT_QUOTES, 'UTF-8') . '"' . $grandClass . '>' . htmlspecialchars($grand['titulo'], ENT_QUOTES, 'UTF-8') . '</a>';
                        }
                        echo '</div>';
                    } else {
                        echo '<a href="' . htmlspecialchars($childUrl, ENT_QUOTES, 'UTF-8') . '"' . $childClass . '>' . htmlspecialchars($child['titulo'], ENT_QUOTES, 'UTF-8') . '</a>';
                    }
                }
                echo '</div>'; // .dropdown-content
                echo '</div>'; // .dropdown
            } else {
                echo '<a href="' . htmlspecialchars($itemUrl, ENT_QUOTES, 'UTF-8') . '"' . $aClass . '>' . htmlspecialchars($item['titulo'], ENT_QUOTES, 'UTF-8') . '</a>';
            }
        } else {
            // Sub-level rendering: simple links (used when called recursively)
            echo '<a href="' . htmlspecialchars($itemUrl, ENT_QUOTES, 'UTF-8') . '"' . $aClass . '>' . htmlspecialchars($item['titulo'], ENT_QUOTES, 'UTF-8') . '</a>';
            if ($hasChildren) {
                // render deeper children inline
                foreach ($item['children'] as $child) {
                    renderMenu([$child], $currentPage, true);
                }
            }
        }
    }
}




include_once 'config.php';

// Obtendo o nome da página atual
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="menu">
    <a href="index.php">
        <div class="menu-container">
            <!-- Logo do site -->
            <img src="img/logo.png" alt="Logo do Site" class="logo">

        </div>
    </a>


    <div class="menu-links">
        <?php
        $menuTree = buildMenuTree($menuItems);
        renderMenu($menuTree, $currentPage);
        ?>


    </div>
    <div class="menu-icon" onclick="toggleMenu()">☰</div>


</div>
</div>
</body>


</html>
