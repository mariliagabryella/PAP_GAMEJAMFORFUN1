<?php
session_start();
include 'bd_connection.php';

// 1. VERIFICAÇÃO DE LOGIN E PERMISSÕES
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    die("Sem permissão.");
}

// 2. DADOS DO UTILIZADOR PARA O MENU LATERAL
$user_id = $_SESSION["id"] ?? 0; 
$nome = $_SESSION["nome"] ?? "Utilizador";
$fotoLogado = "img/default_user.png";
$role = $_SESSION["role_id"] ?? 3;

if ($user_id > 0) {
    $stmtUser = $pdo->query("SELECT foto FROM utilizadores WHERE id = $user_id");
    $userDados = $stmtUser->fetch(PDO::FETCH_ASSOC);
    if ($userDados && !empty($userDados['foto'])) {
        $fotoLogado = $userDados['foto'];
    }
}

// 3. BUSCAR DADOS DOS CONTACTOS
$stmt = $pdo->query("SELECT * FROM contactos_pagina WHERE id = 1");
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

// 4. GUARDAR ALTERAÇÕES
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "UPDATE contactos_pagina SET
        titulo = :titulo,
        subtitulo = :subtitulo,
        facebook = :facebook,
        instagram = :instagram,
        discord = :discord,
        email = :email
        WHERE id = 1";

    $stmtUpdate = $pdo->prepare($sql);
    $stmtUpdate->execute([
        ':titulo' => $_POST['titulo'],
        ':subtitulo' => $_POST['subtitulo'],
        ':facebook' => $_POST['facebook'],
        ':instagram' => $_POST['instagram'],
        ':discord' => $_POST['discord'],
        ':email' => $_POST['email']
    ]);

    header("Location: admin_contactos_pagina.php?msg=guardado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Contactos | Painel Premium</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <div class="painel-menu">
        <div class="painel-user">
            <img src="<?php echo htmlspecialchars($fotoLogado); ?>" class="painel-foto" alt="Foto">
            <span class="painel-ola">Olá, <span class="destaque-nome"><?php echo htmlspecialchars($nome); ?></span></span>
        </div>

        <div class="painel-links" id="painelLinks">
            <a href="index.php"><i class="fa-solid fa-house"></i> Site</a>
            <a href="editar_perfil.php"><i class="fa-solid fa-user-pen"></i> Perfil</a>

            <?php if ($role <= 2): ?>
                <a href="admin.php"><i class="active"></i> Painel</a>
                
            <?php endif; ?>

            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">
        <div class="cabecalho-dashboard">
            <a href="editar_site.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
            <h1 class="titulo-painel">Editar <span class="glow-text">Página de Contactos</span></h1>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'guardado'): ?>
            <div class="notif-card lida" style="border-left: 4px solid #2ecc71; margin-bottom: 20px;">
                <div class="notif-icone"><i class="fa-solid fa-circle-check" style="color: #2ecc71;"></i></div>
                <div class="notif-conteudo">
                    <p class="notif-mensagem">Contactos atualizados com sucesso!</p>
                </div>
            </div>
        <?php endif; ?>

        <div class="card-contactos">
            <form method="POST">
                
                <div class="form-group-contact">
                    <label><i class="fa-solid fa-heading"></i> Título Principal:</label>
                    <input type="text" name="titulo" value="<?= htmlspecialchars($dados['titulo']) ?>" required>
                </div>

                <div class="form-group-contact">
                    <label><i class="fa-solid fa-align-left"></i> Subtítulo / Descrição:</label>
                    <textarea name="subtitulo"><?= htmlspecialchars($dados['subtitulo']) ?></textarea>
                </div>

                <div class="form-group-contact">
                    <label><i class="fa-brands fa-facebook" style="color:#1877F2;"></i> Link do Facebook:</label>
                    <input type="text" name="facebook" value="<?= htmlspecialchars($dados['facebook']) ?>">
                </div>

                <div class="form-group-contact">
                    <label><i class="fa-brands fa-instagram" style="color:#E4405F;"></i> Link do Instagram:</label>
                    <input type="text" name="instagram" value="<?= htmlspecialchars($dados['instagram']) ?>">
                </div>

                <div class="form-group-contact">
                    <label><i class="fa-brands fa-discord" style="color:#5865F2;"></i> Link do Discord:</label>
                    <input type="text" name="discord" value="<?= htmlspecialchars($dados['discord']) ?>">
                </div>

                <div class="form-group-contact">
                    <label><i class="fa-solid fa-envelope" style="color:#ea4335;"></i> Email de Contacto:</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($dados['email']) ?>">
                </div>

                <button type="submit" class="btn-save" style="width: 100%; margin-top: 10px;">
                    <i class="fa-solid fa-floppy-disk"></i> GUARDAR CONTACTOS
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePainelMenu() {
            document.getElementById("painelLinks").classList.toggle("active");
        }
    </script>
</body>
</html>