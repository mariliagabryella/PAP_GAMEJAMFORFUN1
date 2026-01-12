<?php
session_start();

/* Apenas viewer (3) entra aqui */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 3) {
    header("Location: login.php");
    exit();
}

$nome  = $_SESSION["usuarioNome"];
$email = $_SESSION["usuarioEmail"];

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* Foto do viewer */
$foto = "img/default.png";
$stmt = $conn->prepare("SELECT foto FROM utilizadores WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 1) {
    $row = $res->fetch_assoc();
    if (!empty($row['foto'])) {
        $foto = $row['foto'];
    }
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Painel do Utilizador</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<div class="painel-menu">
    <div class="painel-user">
        <img src="<?php echo htmlspecialchars($foto); ?>" class="painel-foto" alt="Foto">
        <span class="painel-ola">Olá, <?php echo htmlspecialchars($nome); ?> (Viewer)</span>
    </div>

    <div class="painel-toggle" onclick="togglePainelMenu()">
        <span id="painel-icon">☰</span>
    </div>

    <div class="painel-links" id="painelLinks">
        <a href="index.php">Voltar ao Site</a>
        <a href="editar_perfil.php">Editar Perfil</a>
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

<div class="admin-content">
    <h1>Área do Utilizador</h1>
    <p>Bem-vindo(a), <?php echo htmlspecialchars($nome); ?>.</p>

    <div class="cards-dashboard">
        <div class="card-dashboard">
            <span class="card-label">O meu email</span>
            <span class="card-value"><?php echo htmlspecialchars($email); ?></span>
        </div>

        <div class="card-dashboard">
            <span class="card-label">Tipo de conta</span>
            <span class="card-value">Viewer</span>
        </div>
    </div>

    <h2>Informações</h2>
    <p>Aqui podes editar o teu perfil, alterar a tua foto e aceder ao site principal.</p>
</div>

</body>
</html>
