<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* Verificar login */
if (!isset($_SESSION["id"])) {
    header("Location: login.php?erro=Precisa+de+iniciar+sessao");
    exit();
}

/* Buscar dados do utilizador logado */
$userId = $_SESSION["id"];
$stmt = $conn->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$nome = $user["nome"];
$fotoLogado = $user["foto"] ?: "img/default.png";
$role = $user["role_id"];

/* Apenas admin master (1) e admin normal (2) podem editar */
if ($role != 1 && $role != 2) {
    die("Acesso negado.");
}

/* Buscar ID da inscrição */
$id = $_GET["id"] ?? null;
if (!$id) {
    die("ID inválido.");
}

/* Buscar dados da inscrição */
$stmt = $conn->prepare("SELECT * FROM inscricoes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$inscricao = $stmt->get_result()->fetch_assoc();

if (!$inscricao) {
    die("Inscrição não encontrada.");
}

/* Atualizar inscrição */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $instituicao = $_POST["instituicao"];
    $professor = $_POST["professor"];
    $email_professor = $_POST["email_professor"];
    $plataforma = $_POST["plataforma"];
    $linguagem = $_POST["linguagem"];
    $linguagem_outra = $_POST["linguagem_outra"];
    $num_participantes = $_POST["num_participantes"];
    $estado = $_POST["estado"];

    $stmt = $conn->prepare("
        UPDATE inscricoes 
        SET instituicao=?, professor=?, email_professor=?, plataforma=?, linguagem=?, linguagem_outra=?, num_participantes=?, estado=?
        WHERE id=?
    ");

    $stmt->bind_param("ssssssisi", 
        $instituicao, $professor, $email_professor, $plataforma, 
        $linguagem, $linguagem_outra, $num_participantes, $estado, $id
    );

    $stmt->execute();

    header("Location: admin_inscricoes.php?sucesso=1");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Editar Inscrição</title>
<link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<!-- MENU SUPERIOR -->
<div class="painel-menu">
    <div class="painel-user">
        <img src="<?php echo htmlspecialchars($fotoLogado); ?>" class="painel-foto" alt="Foto">
        <span class="painel-ola">
            Olá, <?php echo htmlspecialchars($nome); ?>
            <?php 
                if ($role == 1) echo "(Admin Master)";
                else echo "(Admin)";
            ?>
        </span>
    </div>

    <div class="painel-toggle" onclick="togglePainelMenu()">
        <span id="painel-icon">☰</span>
    </div>

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

        <?php if  ($role == 2): ?>
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

<!-- FORMULÁRIO DE EDIÇÃO -->
<div class="perfil-container">
    <div class="perfil-card">

        <h2>Editar Inscrição #<?php echo $id; ?></h2>

        <form method="POST" class="form-editar">

            <label>Instituição:</label>
            <input type="text" name="instituicao" value="<?php echo htmlspecialchars($inscricao['instituicao']); ?>" required>

            <label>Professor:</label>
            <input type="text" name="professor" value="<?php echo htmlspecialchars($inscricao['professor']); ?>" required>

            <label>Email do Professor:</label>
            <input type="email" name="email_professor" value="<?php echo htmlspecialchars($inscricao['email_professor']); ?>" required>

            <label>Plataforma:</label>
            <input type="text" name="plataforma" value="<?php echo htmlspecialchars($inscricao['plataforma']); ?>" required>

            <label>Linguagem:</label>
            <input type="text" name="linguagem" value="<?php echo htmlspecialchars($inscricao['linguagem']); ?>">

            <label>Outra Linguagem:</label>
            <input type="text" name="linguagem_outra" value="<?php echo htmlspecialchars($inscricao['linguagem_outra']); ?>">

            <label>Nº Participantes:</label>
            <input type="number" name="num_participantes" value="<?php echo $inscricao['num_participantes']; ?>" required>

            <label>Estado:</label>
            <select name="estado" class="input-file">
                <option value="pendente" <?php if ($inscricao['estado']=="pendente") echo "selected"; ?>>Pendente</option>
                <option value="aprovado" <?php if ($inscricao['estado']=="aprovado") echo "selected"; ?>>Aprovado</option>
                <option value="rejeitado" <?php if ($inscricao['estado']=="rejeitado") echo "selected"; ?>>Rejeitado</option>
            </select>

            <button type="submit" class="btn-guardar">💾 Guardar Alterações</button>
        </form>
    </div>
       </div>
       <?php include 'eliminar_perfil.php'; ?>
</body>
</html>
