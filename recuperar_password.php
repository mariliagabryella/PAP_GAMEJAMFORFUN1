<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ============================================================
   VERIFICAR LOGIN
============================================================ */
if (!isset($_SESSION["id"])) {
    header("Location: login.php?erro=Precisa+de+iniciar+sessao");
    exit();
}

/* ============================================================
   LIGAR À BASE DE DADOS
============================================================ */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* ============================================================
   BUSCAR DADOS DO ADMIN LOGADO
============================================================ */
$userId = $_SESSION["id"];

$stmt = $conn->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

$nome = $admin["nome"];
$fotoLogado = $admin["foto"] ?: "img/default.png";
$role = (int)$admin["role_id"];

/* Apenas ADMIN NORMAL pode recuperar passwords */
if ($role !== 2) {
    die("Acesso negado.");
}

/* ============================================================
   BUSCAR UTILIZADOR A EDITAR
============================================================ */
if (!isset($_GET["id"])) {
    die("ID inválido.");
}

$id = (int) $_GET["id"];

$stmt = $conn->prepare("SELECT nome, email FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("Utilizador não encontrado.");
}

/* ============================================================
   PROCESSAR ALTERAÇÃO DE PASSWORD
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $novaPass = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE utilizadores SET password=? WHERE id=?");
    $stmt->bind_param("si", $novaPass, $id);
    $stmt->execute();

    header("Location: admin.php?sucesso=pass");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Password</title>
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
     FORMULÁRIO DE RECUPERAÇÃO DE PASSWORD
============================================================ -->
    <div class="perfil-container">
        <div class="perfil-card">

            <h2>Recuperar Password</h2>

            <p>Está a alterar a password de:</p>
            <p><strong><?php echo htmlspecialchars($user["nome"]); ?></strong></p>

            <form method="POST">
                <label>Nova Password:</label>
                <input type="password" name="password" required>

                <button type="submit" class="btn-guardar">Guardar Nova Password</button>
                <a href="admin.php" class="btn-voltar">Voltar</a>
            </form>

        </div>
    </div>

</body>

</html>