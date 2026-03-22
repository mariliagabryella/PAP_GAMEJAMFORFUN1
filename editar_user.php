<?php
session_start();

/* Apenas admin master pode editar outros utilizadores */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

/* Buscar dados do admin logado */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$idAdmin = $_SESSION["id"];

$stmtAdmin = $conn->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmtAdmin->bind_param("i", $idAdmin);
$stmtAdmin->execute();
$adminData = $stmtAdmin->get_result()->fetch_assoc();

$nomeAdmin = $adminData["nome"];
$fotoLogado = $adminData["foto"] ?: "img/default.png";
$roleAdmin = $adminData["role_id"];

/* Verifica se recebeu ID por GET */
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$idUser = (int) $_GET['id'];

/* Buscar dados do utilizador a editar (foto removida da query pois não será editada aqui) */
$stmt = $conn->prepare("SELECT id, nome, email, role_id FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $idUser);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $stmt->close();
    $conn->close();
    header("Location: admin.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Player | Admin Master</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <div class="painel-menu">
        <div class="painel-user">
            <img src="<?php echo htmlspecialchars($fotoLogado); ?>" class="painel-foto" alt="Foto Admin">
            <span class="painel-ola">
                Olá, <span class="destaque-nome"><?php echo htmlspecialchars($nomeAdmin); ?></span>
           
                
            </span>
        </div>

        <div class="painel-toggle" onclick="togglePainelMenu()">
            <span id="painel-icon"><i class="fa-solid fa-bars"></i></span>
        </div>

        <div class="painel-links" id="painelLinks">
            <a href="index.php"><i class="fa-solid fa-house"></i>Site</a>
            <a href="editar_perfil.php"><i class="fa-solid fa-user-pen"></i>Perfil</a>

            <?php if ($roleAdmin == 1): ?>
                <a href="admin.php" class="active"><i class="active"></i>Painel</a>
            <?php endif; ?>

            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <script>
    function togglePainelMenu() {
        const menu = document.getElementById("painelLinks");
        const icon = document.getElementById("painel-icon");
        menu.classList.toggle("show");
        
        if (menu.classList.contains("show")) {
            icon.innerHTML = '<i class="fa-solid fa-xmark"></i>';
        } else {
            icon.innerHTML = '<i class="fa-solid fa-bars"></i>';
        }
    }
    </script>

    <div class="admin-content">
        <div class="cabecalho-dashboard">
            <h1 class="titulo-painel">Editar <span class="glow-text">Player</span></h1>
        </div>

        <form action="processar_editar_user.php" method="POST" class="form-card">

            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

            <div class="form-group">
                <label><i class="fa-solid fa-user"></i> Nome do Jogador:</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-envelope"></i> Email Associado:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-id-badge"></i> Cargo / Função:</label>
                <select name="role_id" style="width: 100%; padding: 14px; margin-bottom: 25px; background-color: var(--bg-dark-profile, #0f172a); border: 1px solid #334155; border-radius: 8px; color: #fff; font-family: 'Poppins', sans-serif; font-size: 15px;" required>
                    <option value="1" <?php if ($user['role_id'] == 1) echo 'selected'; ?>>Admin Master</option>
                    <option value="2" <?php if ($user['role_id'] == 2) echo 'selected'; ?>>Admin</option>
                    <option value="3" <?php if ($user['role_id'] == 3) echo 'selected'; ?>>Viewer / Player</option>
                </select>
            </div>

            <div class="form-actions">
                <a href="admin.php" class="btn-voltar-outline"><i class="fa-solid fa-arrow-left"></i> Cancelar</a>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Guardar Configurações</button>
            </div>

        </form>
    </div>

    

</body>
</html>