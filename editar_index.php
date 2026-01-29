<?php
/* ============================================================
   INICIAR SESSÃO E VERIFICAR PERMISSÕES
   Apenas Admin Master (1) e Admin (2) podem editar o site
============================================================ */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    header("Location: login.php");
    exit();
}

$role  = $_SESSION["role_id"];
$nome  = $_SESSION["usuarioNome"];
$email = $_SESSION["usuarioEmail"];

/* ============================================================
   LIGAR À BASE DE DADOS
============================================================ */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* ============================================================
   BUSCAR FOTO DO UTILIZADOR PARA O MENU
============================================================ */
$fotoLogado = "img/default.png";

$stmt = $conn->prepare("SELECT foto FROM utilizadores WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if ($res && !empty($res["foto"])) {
    $fotoLogado = $res["foto"];
}
$stmt->close();

/* ============================================================
   FUNÇÃO PARA BUSCAR VALOR ATUAL DE UM CAMPO
============================================================ */
function get_index_val($campo, $conn) {
    $stmt = $conn->prepare("SELECT valor FROM conteudo_index WHERE campo=? LIMIT 1");
    $stmt->bind_param("s", $campo);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $res ? $res["valor"] : "";
}

/* ============================================================
   FUNÇÃO PARA ATUALIZAR OU INSERIR CAMPO
============================================================ */
function set_index_val($campo, $valor, $conn) {
    $stmt = $conn->prepare("SELECT id FROM conteudo_index WHERE campo=? LIMIT 1");
    $stmt->bind_param("s", $campo);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($res) {
        $stmt = $conn->prepare("UPDATE conteudo_index SET valor=? WHERE campo=?");
        $stmt->bind_param("ss", $valor, $campo);
    } else {
        $stmt = $conn->prepare("INSERT INTO conteudo_index (campo, valor) VALUES (?, ?)");
        $stmt->bind_param("ss", $campo, $valor);
    }
    $stmt->execute();
    $stmt->close();
}

/* ============================================================
   PROCESSAR FORMULÁRIO (TEXTOS + UPLOADS)
============================================================ */
$mensagemSucesso = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    /* ---------- TEXTOS SIMPLES (SEM UPLOAD) ---------- */

    // Hero
    set_index_val("titulo",    $_POST["titulo"],    $conn);
    set_index_val("subtitulo", $_POST["subtitulo"], $conn);
    set_index_val("descricao", $_POST["descricao"], $conn);

    // Sobre Nós
    set_index_val("sobre_titulo", $_POST["sobre_titulo"], $conn);
    set_index_val("sobre_texto1", $_POST["sobre_texto1"], $conn);
    set_index_val("sobre_texto2", $_POST["sobre_texto2"], $conn);

    // Localização
    set_index_val("local_titulo", $_POST["local_titulo"], $conn);
    set_index_val("local_texto1", $_POST["local_texto1"], $conn);
    set_index_val("local_texto2", $_POST["local_texto2"], $conn);

    // Etapas
    set_index_val("etapas_titulo", $_POST["etapas_titulo"], $conn);

    // Patrocinadores
    set_index_val("patrocinadores_titulo",         $_POST["patrocinadores_titulo"],         $conn);
    set_index_val("patrocinadores_agradecimento",  $_POST["patrocinadores_agradecimento"],  $conn);

    /* ============================================================
       UPLOAD REAL DE VÍDEO (FUNDO) E LOGO
       - Guarda ficheiro em /uploads
       - Grava caminho na BD
    ============================================================= */

    // Garante que a pasta uploads existe
    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

    /* ---------- UPLOAD DO VÍDEO DE FUNDO ---------- */
    if (!empty($_FILES["video_upload"]["name"])) {

        $videoNome = $_FILES["video_upload"]["name"];
        $videoTmp  = $_FILES["video_upload"]["tmp_name"];
        $videoExt  = strtolower(pathinfo($videoNome, PATHINFO_EXTENSION));

        if ($videoExt !== "mp4") {
            die("Erro: Apenas vídeos MP4 são permitidos para o fundo.");
        }

        $novoNomeVideo = time() . "_" . uniqid() . ".mp4";
        $destinoVideo  = "uploads/" . $novoNomeVideo;

        if (move_uploaded_file($videoTmp, $destinoVideo)) {
            set_index_val("video_url", $destinoVideo, $conn);
        }
    } else {
        // Se quiseres permitir também URL manual (campo texto opcional)
        if (!empty($_POST["video_url_manual"])) {
            set_index_val("video_url", $_POST["video_url_manual"], $conn);
        }
    }

    /* ---------- UPLOAD DA LOGO ---------- */
    if (!empty($_FILES["logo_upload"]["name"])) {

        $imgNome = $_FILES["logo_upload"]["name"];
        $imgTmp  = $_FILES["logo_upload"]["tmp_name"];
        $imgExt  = strtolower(pathinfo($imgNome, PATHINFO_EXTENSION));

        $permitidos = ["jpg", "jpeg", "png", "webp"];

        if (!in_array($imgExt, $permitidos)) {
            die("Erro: Apenas imagens JPG, JPEG, PNG ou WEBP são permitidas para a logo.");
        }

        $novoNomeImg = time() . "_" . uniqid() . "." . $imgExt;
        $destinoImg  = "uploads/" . $novoNomeImg;

        if (move_uploaded_file($imgTmp, $destinoImg)) {
            set_index_val("logo", $destinoImg, $conn);
        }
    } else {
        // Também podes permitir URL manual para logo
        if (!empty($_POST["logo_manual"])) {
            set_index_val("logo", $_POST["logo_manual"], $conn);
        }
    }

    $mensagemSucesso = "Conteúdo da página inicial atualizado com sucesso!";
}

/* ============================================================
   BUSCAR VALORES ATUAIS PARA MOSTRAR NO FORMULÁRIO
============================================================ */
$video_url   = get_index_val("video_url", $conn);
$titulo      = get_index_val("titulo", $conn);
$subtitulo   = get_index_val("subtitulo", $conn);
$descricao   = get_index_val("descricao", $conn);
$logo        = get_index_val("logo", $conn);

$sobre_titulo  = get_index_val("sobre_titulo", $conn);
$sobre_texto1  = get_index_val("sobre_texto1", $conn);
$sobre_texto2  = get_index_val("sobre_texto2", $conn);

$local_titulo  = get_index_val("local_titulo", $conn);
$local_texto1  = get_index_val("local_texto1", $conn);
$local_texto2  = get_index_val("local_texto2", $conn);

$etapas_titulo = get_index_val("etapas_titulo", $conn);

$pat_titulo    = get_index_val("patrocinadores_titulo", $conn);
$pat_agrade    = get_index_val("patrocinadores_agradecimento", $conn);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Página Inicial</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<!-- ============================================================
     MENU SUPERIOR DO PAINEL
============================================================ -->
<div class="painel-menu">
    <div class="painel-user">
        <img src="<?php echo htmlspecialchars($fotoLogado); ?>" class="painel-foto" alt="Foto">
        <span class="painel-ola">Olá, <?php echo htmlspecialchars($nome); ?></span>
    </div>

    <div class="painel-toggle" onclick="togglePainelMenu()">
        <span id="painel-icon">☰</span>
    </div>

    <div class="painel-links" id="painelLinks">
        <a href="index.php">Voltar ao Site</a>
        <a href="editar_perfil.php">Editar Perfil</a>
        <a href="editar_site.php" class="active">Editar Site</a>

        <?php if ($role == 1): ?>
            <a href="admin.php">Painel Admin Master</a>
            <a href="admin_inscricoes.php">Inscrições</a>
            <a href="criar_admin.php">Criar Admin</a>
            <a href="criar_viewer.php">Criar Viewer</a>
        <?php endif; ?>

        <?php if ($role == 2): ?>
            <a href="admin.php">Painel Admin</a>
            <a href="admin_inscricoes.php">Inscrições</a>
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
     FORMULÁRIO DE EDIÇÃO
============================================================ -->
<div class="conteudo-admin">
    <h2>Editar Página Inicial (Index)</h2>

    <?php if ($mensagemSucesso): ?>
        <div class="alert-sucesso"><?php echo htmlspecialchars($mensagemSucesso); ?></div>
    <?php endif; ?>

    <!-- enctype necessário para upload de ficheiros -->
    <form method="POST" enctype="multipart/form-data" class="form-editar-site">

        <!-- ================= HERO / VÍDEO ================= -->
        <h3>Hero / Vídeo de Fundo</h3>

        <label>Vídeo de Fundo (MP4) - Upload:</label>
        <input type="file" name="video_upload" accept="video/mp4">

        <?php if (!empty($video_url)): ?>
            <small>Atual: <?php echo htmlspecialchars($video_url); ?></small><br>
            <video src="<?php echo htmlspecialchars($video_url); ?>" width="300" controls style="margin-top:10px;"></video>
        <?php endif; ?>

        <label>OU URL manual do vídeo (opcional):</label>
        <input type="text" name="video_url_manual" placeholder="https://..." value="">

        <label>Título Principal:</label>
        <input type="text" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>">

        <label>Subtítulo:</label>
        <input type="text" name="subtitulo" value="<?php echo htmlspecialchars($subtitulo); ?>">

        <label>Descrição:</label>
        <textarea name="descricao" rows="3"><?php echo htmlspecialchars($descricao); ?></textarea>

        <!-- ================= LOGO ================= -->
        <h3>Logo</h3>

        <label>Logo (imagem) - Upload:</label>
        <input type="file" name="logo_upload" accept="image/*">

        <?php if (!empty($logo)): ?>
            <small>Atual: <?php echo htmlspecialchars($logo); ?></small><br>
            <img src="<?php echo htmlspecialchars($logo); ?>" style="max-width:150px; margin-top:10px;">
        <?php endif; ?>

        <label>OU URL manual da logo (opcional):</label>
        <input type="text" name="logo_manual" placeholder="img/logo.png ou https://..." value="">

        <hr>

        <!-- ================= SOBRE NÓS ================= -->
        <h3>Secção "Sobre Nós"</h3>

        <label>Título:</label>
        <input type="text" name="sobre_titulo" value="<?php echo htmlspecialchars($sobre_titulo); ?>">

        <label>Texto 1:</label>
        <textarea name="sobre_texto1" rows="3"><?php echo htmlspecialchars($sobre_texto1); ?></textarea>

        <label>Texto 2:</label>
        <textarea name="sobre_texto2" rows="3"><?php echo htmlspecialchars($sobre_texto2); ?></textarea>

        <hr>

        <!-- ================= LOCALIZAÇÃO ================= -->
        <h3>Secção "Localização"</h3>

        <label>Título:</label>
        <input type="text" name="local_titulo" value="<?php echo htmlspecialchars($local_titulo); ?>">

        <label>Texto 1:</label>
        <textarea name="local_texto1" rows="3"><?php echo htmlspecialchars($local_texto1); ?></textarea>

        <label>Texto 2:</label>
        <textarea name="local_texto2" rows="3"><?php echo htmlspecialchars($local_texto2); ?></textarea>

        <hr>

        <!-- ================= ETAPAS ================= -->
        <h3>Secção "Etapas"</h3>

        <label>Título:</label>
        <input type="text" name="etapas_titulo" value="<?php echo htmlspecialchars($etapas_titulo); ?>">

        <hr>

        <!-- ================= PATROCINADORES ================= -->
        <h3>Secção "Patrocinadores"</h3>

        <label>Título:</label>
        <input type="text" name="patrocinadores_titulo" value="<?php echo htmlspecialchars($pat_titulo); ?>">

        <label>Texto de Agradecimento:</label>
        <textarea name="patrocinadores_agradecimento" rows="3"><?php echo htmlspecialchars($pat_agrade); ?></textarea>

        <button type="submit" class="btn-guardar">Guardar Alterações</button>
    </form>
</div>

<!-- ============================================================
     ESTILOS DO FORMULÁRIO
============================================================ -->
<style>
.form-editar-site {
    max-width: 800px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.form-editar-site input[type="text"],
.form-editar-site textarea,
.form-editar-site input[type="file"] {
    width: 100%;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.form-editar-site h3 {
    margin-top: 20px;
    color: #09122c;
}

.alert-sucesso {
    background: #2ecc71;
    color: white;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 15px;
}

.btn-guardar {
    margin-top: 20px;
    padding: 10px 20px;
    background: #be3144;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-guardar:hover {
    background: #09122c;
}
</style>

</body>
</html>
