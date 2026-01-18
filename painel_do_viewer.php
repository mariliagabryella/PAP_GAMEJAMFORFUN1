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

/* Buscar dados completos do viewer */
$stmt = $conn->prepare("
    SELECT nome, email, foto, criado_em, ativo 
    FROM utilizadores 
    WHERE email = ?
");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if (!$user) {
    // Evita erros e mostra mensagem útil
    $foto = "img/default.png";
    $criado_em = "Desconhecido";
    $ultimoLogin = "Nunca";
} else {
    $foto       = $user['foto'] ?: "img/default.png";
    $criado_em  = $user['criado_em'] ?? "Desconhecido";
    $ultimoLogin = $user['ativo'] 
    ? date("d/m/Y H:i", strtotime($user['ativo'])) 
    : "Nunca";

    /* Contar notificações não lidas */
$sqlNotif = $conn->prepare("SELECT COUNT(*) AS total FROM notificacoes WHERE user_id = ? AND lida = 0");
$sqlNotif->bind_param("i", $id_user);
$sqlNotif->execute();
$notifCount = $sqlNotif->get_result()->fetch_assoc()["total"];

}


$stmt->close();

/* Verificar se email está confirmado */
$stmt2 = $conn->prepare("SELECT id FROM verificacoes_email WHERE email = ?");
$stmt2->bind_param("s", $email);
$stmt2->execute();
$stmt2->store_result();

$emailPendente = $stmt2->num_rows > 0; // TRUE se ainda não confirmou

$stmt2->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Painel do Utilizador</title>
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/YOUR-FONT-AWESOME-KIT.js" crossorigin="anonymous"></script> <!-- Importa os ícones -->

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
    <a href="#" class="danger" onclick="abrirPopupEliminar()">Eliminar Perfil</a>
    <a href="notificacoes.php"><i class="fa-solid fa-bell" style="color: #ffffff;"></i></a>
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

        <div class="card-dashboard">
            <span class="card-label">Conta criada em</span>
            <span class="card-value"><?php echo $criado_em; ?></span>
        </div>

        <div class="card-dashboard">
            <span class="card-label">Último login</span>
            <span class="card-value"><?php echo $ultimoLogin; ?></span>
        </div>

        <div class="card-dashboard" style="background: <?php echo $emailPendente ? '#be3144' : '#2ecc71'; ?>;">
            <span class="card-label">Estado do Email</span>
            <span class="card-value">
                <?php echo $emailPendente ? "Pendente de verificação" : "Verificado"; ?>
            </span>
        </div>

    </div>

    <h2>Informações</h2>
    <p>Aqui podes editar o teu perfil, alterar a tua foto e aceder ao site principal.</p>

    <?php if ($emailPendente): ?>
        <p style="color:#be3144; font-weight:bold;">
            ⚠ O teu email ainda não foi verificado. Verifica a tua caixa de entrada.
        </p>
    <?php endif; ?>

</div>

<?php include 'eliminar_perfil.php'; ?>

</body>
</html>
