<?php
session_start();

// 1. Conexão à Base de Dados
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) die("Erro de ligação.");

// 2. Verificar Permissão (Role 3 = Utilizador)
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 3) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["id"];

/* ============================================================
   LÓGICA DE UPLOADS (FOTO E BANNER)
============================================================ */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['banner_file']) && $_FILES['banner_file']['error'] == 0) {
        $target_b = "uploads/banners/";
        if (!file_exists($target_b)) mkdir($target_b, 0777, true);
        $ext = pathinfo($_FILES["banner_file"]["name"], PATHINFO_EXTENSION);
        $nome_b = "banner_" . $user_id . "_" . time() . "." . $ext;
        move_uploaded_file($_FILES["banner_file"]["tmp_name"], $target_b . $nome_b);
        $path_b = $target_b . $nome_b;
        $conn->query("UPDATE utilizadores SET banner_bg = '$path_b' WHERE id = $user_id");
    }

    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $target_p = "uploads/perfis/";
        if (!file_exists($target_p)) mkdir($target_p, 0777, true);
        $ext = pathinfo($_FILES["foto_perfil"]["name"], PATHINFO_EXTENSION);
        $nome_p = "perfil_" . $user_id . "_" . time() . "." . $ext;
        move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $target_p . $nome_p);
        $path_p = $target_p . $nome_p;
        $conn->query("UPDATE utilizadores SET foto = '$path_p' WHERE id = $user_id");
    }
    header("Location: painel_do_viewer.php");
    exit();
}

// 3. Buscar Dados do Utilizador
$query = "SELECT nome, email, foto, created_at, banner_bg FROM utilizadores WHERE id = $user_id";
$res = $conn->query($query);
$user = $res->fetch_assoc();

$nomeReal = $user['nome'];
$fotoPerfil = !empty($user['foto']) ? $user['foto'] : "img/default.png";
$bannerPath = $user['banner_bg'];
$bannerStyle = (strpos($bannerPath, 'uploads/') !== false) ? "style='background-image: url($bannerPath); background-size: cover; background-position: center;'" : "";

// 4. Buscar as Inscrições deste Utilizador
$sql_insc = "SELECT * FROM inscricoes WHERE user_id = ? ORDER BY data_inscricao DESC";
$stmt = $conn->prepare($sql_insc);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res_insc = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Painel | <?php echo htmlspecialchars($nomeReal); ?></title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <div class="painel-menu">
        <div class="painel-user">
            <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" class="painel-foto">
            <span class="painel-ola">Olá, <span class="destaque-nome"><?php echo htmlspecialchars($nomeReal); ?></span></span>
        </div>
        <div class="painel-links">
            <a href="index.php"><i class="fa-solid fa-house"></i>Site</a>
            <a href="editar_perfil.php" class="active"><i class="fa-solid fa-user-pen"></i> Perfil</a>
             <a href="eliminar_perfil.php" class="danger"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>
            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-power-off"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">
        
        <div class="viewer-hero" <?php echo $bannerStyle; ?>>
            <form action="" method="POST" enctype="multipart/form-data" id="formBanner">
                <input type="file" name="banner_file" id="inputBanner" style="display:none;" onchange="document.getElementById('formBanner').submit()">
                <button type="button" class="change-banner-btn" onclick="document.getElementById('inputBanner').click()">
                    <i class="fa-solid fa-image"></i> Alterar Fundo
                </button>
            </form>

            <div class="viewer-avatar-wrapper">
                <div class="profile-pic-container">
                    <form action="" method="POST" enctype="multipart/form-data" id="formFoto">
                        <input type="file" name="foto_perfil" id="inputFoto" style="display:none;" onchange="document.getElementById('formFoto').submit()">
                        <img src="<?php echo htmlspecialchars($fotoPerfil); ?>" alt="Avatar" onclick="document.getElementById('inputFoto').click()" class="foto-clicavel">
                        <div class="foto-overlay" onclick="document.getElementById('inputFoto').click()">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </form>
                </div>
                <div class="viewer-name-tag">
                    <span class="badge-rank"><i class="fa-solid fa-user-check"></i> Utilizador Verificado</span>
                    <h2><?php echo htmlspecialchars($nomeReal); ?></h2>
                </div>
            </div>
        </div>

        <div class="bento-grid">
            <div class="bento-item large">
                <h4><i class="fa-solid fa-id-card"></i> Identidade</h4>
                <div class="value"><?php echo htmlspecialchars($user['email']); ?></div>
                <p style="color: #64748b; font-size: 0.85rem; margin-top: 10px;">Email oficial da conta.</p>
            </div>

            <div class="bento-item">
                <h4><i class="fa-solid fa-lock"></i> Segurança</h4>
                <div class="value" style="color: #10b981;">Protegida</div>
                <a href="recuperar_password.php?id=<?php echo $user_id; ?>" style="color: #8b5cf6; font-size: 0.85rem; text-decoration: none; display: block; margin-top: 10px; font-weight: 600;">
                    <i class="fa-solid fa-shield-halved"></i> Alterar Password
                </a>
            </div>

            <div class="bento-item">
                <h4><i class="fa-solid fa-calendar-day"></i> Registado em</h4>
                <div class="value"><?php echo date("d/m/Y", strtotime($user['created_at'])); ?></div>
            </div>

            <a href="notificacoes.php" class="bento-item" style="text-decoration: none; color: inherit;">
                <h4><i class="fa-solid fa-bell"></i> Notificações</h4>
                <div class="value">Ver Centro</div>
                <span style="font-size: 0.8rem; color: #94a3b8;">Gerir alertas</span>
            </a>
        </div>

        <section class="secao glass-panel" style="margin-top: 30px; padding: 25px;">
            <div class="cabecalho-dashboard" style="margin-bottom: 25px; border:none; padding:0;">
                <h1 class="titulo-painel" style="font-size: 1.6rem;">GAME JAM <span class="glow-text">MINHAS INSCRIÇÕES</span></h1>
            </div>

            <div class="tabela-container">
                <table class="tabela-users">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>INSTITUIÇÃO</th>
                            <th>PLATAFORMA</th>
                            <th>LINGUAGEM</th>
                            <th>ESTADO</th>
                            <th>DATA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($res_insc->num_rows == 0): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                                    Ainda não tens nenhuma inscrição registada.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php while ($row = $res_insc->fetch_assoc()): ?>
                                <tr>
                                    <td style="color: #64748b;">#<?php echo $row['id']; ?></td>
                                    <td style="font-weight: 600; color: #fff;"><?php echo htmlspecialchars($row['instituicao']); ?></td>
                                    <td><?php echo htmlspecialchars($row['plataforma']); ?></td>
                                    <td><?php echo htmlspecialchars($row['linguagem']); ?></td>
                                    <td>
                                        <?php 
                                        $est = $row['estado'] ?? 'pendente';
                                        if ($est == 'pendente') echo '<span class="badge badge-pendente">Pendente</span>';
                                        elseif ($est == 'aprovado') echo '<span class="badge badge-aprovado">Aprovado</span>';
                                        else echo '<span class="badge badge-rejeitado">Rejeitado</span>';
                                        ?>
                                    </td>
                                    <td style="color: #94a3b8; font-size: 0.85rem;">
                                        <?php echo date("d/m/Y", strtotime($row['data_inscricao'])); ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>
</html>