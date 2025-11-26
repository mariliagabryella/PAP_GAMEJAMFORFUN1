<?php
include_once 'config.php';
// 🔹 Verifica se a sessão está ativa antes de iniciar
if (!isset($_SESSION)) {
    if (isset($_POST['login']) || isset($_SESSION["usuario"])) {
        session_start(); // Inicia a sessão apenas se o login for necessário
    }
}

// Obtendo o nome da página atual
$currentPage = basename($_SERVER['PHP_SELF']);

// Verifica se há um usuário logado
$usuarioLogado = isset($_SESSION["usuario"]) ? $_SESSION["usuario"] : null;

?>
<div class="menu">
    <a href="index.php">
        <div class="menu-container">
            <!-- Logo do site -->
            <img src="img/logo.png" alt="Logo do Site" class="logo">
            </img>

        </div>
    </a>

    <!-- 🔹 Login dentro do menu fixo (Somente em telas grandes) -->
    <div class="login-container desktop-only">
        <?php if ($usuarioLogado): ?>
            <a href="logout.php" class="logout-btn">Logout</a>
        <?php else: ?>
            <a href="login.php" class="login-btn">Login</a>
        <?php endif; ?>
    </div>
    <div class="menu-links">
        <a href="index.php" class="<?= ($currentPage == 'index.php') ? 'active' : ''; ?>">Início</a>
        <a href="#sobre-nos" class="<?= ($currentPage == 'index.php') ? 'active' : ''; ?>">Sobre Nós</a>
        
        <div class="dropdown">
            <a href="#" >Edições ▾</a>
            <div class="dropdown-content">
                <a href="edicao1(1).php" class="<?= ($currentPage == 'edicao1(1).php') ? 'active' : ''; ?>">Edição 1</a>
                <a href="edicao2(1).php" class="<?= ($currentPage == 'edicao2(1).php') ? 'active' : ''; ?>">Edição 2</a>
              <a href="edicao3(1).php" class="<?= ($currentPage == 'edicao3(1).php') ? 'active' : ''; ?>">Edição 3</a>

            </div>
        </div>
        <a href="inscrição.php" class="<?= ($currentPage == 'inscrição.php') ? 'active' : ''; ?>">Inscrição</a>
        <a href="contact.php" class="<?= ($currentPage == 'contact.php') ? 'active' : ''; ?>">Contactos</a>
    </div>
    <div class="menu-icon" onclick="toggleMenu()">☰</div>

</div>


</div>