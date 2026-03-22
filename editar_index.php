<?php
/* ============================================================
   INICIAR SESSÃO E VERIFICAR PERMISSÕES
============================================================ */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["id"];
$role  = $_SESSION["role_id"];
$nome  = $_SESSION["nome"];
$email = $_SESSION["email"];

/* ============================================================
   LIGAR À BASE DE DADOS
============================================================ */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* ============================================================
   BUSCAR DADOS DO UTILIZADOR PARA O MENU E NOTIFICAÇÕES
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

// Verificar se há notificações não lidas
$stmt_notif = $conn->prepare("SELECT COUNT(*) as total FROM notificacoes WHERE user_id = ? AND lida = 0 AND apagada = 0");
$stmt_notif->bind_param("i", $id_user);
$stmt_notif->execute();
$notifs_nao_lidas = $stmt_notif->get_result()->fetch_assoc()['total'];
$tem_notif = $notifs_nao_lidas > 0 ? 'tem-notif' : '';

/* ============================================================
   FUNÇÕES DA BASE DE DADOS
============================================================ */
function get_index_val($campo, $conn) {
    $stmt = $conn->prepare("SELECT valor FROM conteudo_index WHERE campo=? LIMIT 1");
    $stmt->bind_param("s", $campo);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $res ? $res["valor"] : "";
}

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

    /* ---------- TEXTOS SIMPLES ---------- */
    set_index_val("titulo",    $_POST["titulo"],    $conn);
    set_index_val("subtitulo", $_POST["subtitulo"], $conn);
    set_index_val("descricao", $_POST["descricao"], $conn);

    set_index_val("sobre_titulo", $_POST["sobre_titulo"], $conn);
    set_index_val("sobre_texto1", $_POST["sobre_texto1"], $conn);
    set_index_val("sobre_texto2", $_POST["sobre_texto2"], $conn);

    set_index_val("local_titulo", $_POST["local_titulo"], $conn);
    set_index_val("local_texto1", $_POST["local_texto1"], $conn);
    set_index_val("local_texto2", $_POST["local_texto2"], $conn);

    set_index_val("etapas_titulo", $_POST["etapas_titulo"], $conn);

    set_index_val("patrocinadores_titulo",         $_POST["patrocinadores_titulo"],         $conn);
    set_index_val("patrocinadores_agradecimento",  $_POST["patrocinadores_agradecimento"],  $conn);

    /* ---------- UPLOADS ---------- */
    if (!is_dir("uploads")) {
        mkdir("uploads", 0777, true);
    }

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
    } else if (!empty($_POST["video_url_manual"])) {
        set_index_val("video_url", $_POST["video_url_manual"], $conn);
    }

    if (!empty($_FILES["logo_upload"]["name"])) {
        $imgNome = $_FILES["logo_upload"]["name"];
        $imgTmp  = $_FILES["logo_upload"]["tmp_name"];
        $imgExt  = strtolower(pathinfo($imgNome, PATHINFO_EXTENSION));

        $permitidos = ["jpg", "jpeg", "png", "webp", "gif"];

        if (!in_array($imgExt, $permitidos)) {
            die("Erro: Formato de imagem não suportado para a logo.");
        }

        $novoNomeImg = time() . "_" . uniqid() . "." . $imgExt;
        $destinoImg  = "uploads/" . $novoNomeImg;

        if (move_uploaded_file($imgTmp, $destinoImg)) {
            set_index_val("logo", $destinoImg, $conn);
        }
    } else if (!empty($_POST["logo_manual"])) {
        set_index_val("logo", $_POST["logo_manual"], $conn);
    }

    $mensagemSucesso = "Conteúdo da página inicial atualizado com sucesso!";
}

/* ============================================================
   BUSCAR VALORES ATUAIS
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
    <title>Editar Index | Painel Premium</title>
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

            <?php if ($role == 1 || $role == 2): ?>
                <a href="admin.php">Painel</a>
                
            <?php endif; ?>



            <?php if ($role == 2): ?>
                <a href="#" class="danger" onclick="abrirPopupEliminar()"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>
            <?php endif; ?>

            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">
        <div class="cabecalho-dashboard">
            <a href="editar_site.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
            <h1 class="titulo-painel">Editar <span class="glow-text">Página Inicial</span></h1>
        </div>

        <?php if ($mensagemSucesso): ?>
            <div class="notif-card lida" style="border-left: 4px solid #2ecc71; margin-bottom: 20px;">
                <div class="notif-icone"><i class="fa-solid fa-circle-check" style="color: #2ecc71;"></i></div>
                <div class="notif-conteudo">
                    <p class="notif-mensagem"><?php echo htmlspecialchars($mensagemSucesso); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="secao glass-panel">
            
            <h2 class="secao-titulo"><i class="fa-solid fa-display"></i> Banner Principal (Hero)</h2>
            <div class="grid-form">
                <div class="form-group">
                    <label>Título Principal</label>
                    <input type="text" name="titulo" class="form-control" value="<?php echo htmlspecialchars($titulo); ?>">
                </div>
                <div class="form-group">
                    <label>Subtítulo</label>
                    <input type="text" name="subtitulo" class="form-control" value="<?php echo htmlspecialchars($subtitulo); ?>">
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3"><?php echo htmlspecialchars($descricao); ?></textarea>
                </div>
            </div>

            <div class="grid-form" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--glass-border);">
                <div class="form-group">
                    <label>Vídeo de Fundo (MP4)</label>
                    <input type="file" name="video_upload" class="form-control" accept="video/mp4">
                    <small>Ou URL manual:</small>
                    <input type="text" name="video_url_manual" class="form-control" placeholder="https://..." style="margin-top: 5px;">
                </div>
                <div class="form-group">
                    <label>Logo Principal (Imagem)</label>
                    <input type="file" name="logo_upload" class="form-control" accept="image/*">
                    <small>Ou URL manual:</small>
                    <input type="text" name="logo_manual" class="form-control" placeholder="img/logo.png" style="margin-top: 5px;">
                </div>
            </div>

            <div class="midia-preview">
                <?php if (!empty($video_url)): ?>
                    <div class="preview-box">
                        <small>Vídeo Atual</small>
                        <video src="<?php echo htmlspecialchars($video_url); ?>" muted loop autoplay></video>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($logo)): ?>
                    <div class="preview-box">
                        <small>Logo Atual</small>
                        <img src="<?php echo htmlspecialchars($logo); ?>" alt="Logo">
                    </div>
                <?php endif; ?>
            </div>

            <h2 class="secao-titulo" style="margin-top: 40px;"><i class="fa-solid fa-circle-info"></i> Secção "Sobre Nós"</h2>
            <div class="form-group">
                <label>Título</label>
                <input type="text" name="sobre_titulo" class="form-control" value="<?php echo htmlspecialchars($sobre_titulo); ?>">
            </div>
            <div class="grid-form">
                <div class="form-group">
                    <label>Parágrafo 1</label>
                    <textarea name="sobre_texto1" class="form-control" rows="4"><?php echo htmlspecialchars($sobre_texto1); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Parágrafo 2</label>
                    <textarea name="sobre_texto2" class="form-control" rows="4"><?php echo htmlspecialchars($sobre_texto2); ?></textarea>
                </div>
            </div>

            <h2 class="secao-titulo" style="margin-top: 40px;"><i class="fa-solid fa-location-dot"></i> Secção "Localização"</h2>
            <div class="form-group">
                <label>Título</label>
                <input type="text" name="local_titulo" class="form-control" value="<?php echo htmlspecialchars($local_titulo); ?>">
            </div>
            <div class="grid-form">
                <div class="form-group">
                    <label>Morada / Detalhes 1</label>
                    <textarea name="local_texto1" class="form-control" rows="3"><?php echo htmlspecialchars($local_texto1); ?></textarea>
                </div>
                <div class="form-group">
                    <label>Detalhes 2</label>
                    <textarea name="local_texto2" class="form-control" rows="3"><?php echo htmlspecialchars($local_texto2); ?></textarea>
                </div>
            </div>

            <h2 class="secao-titulo" style="margin-top: 40px;"><i class="fa-solid fa-list-check"></i> Etapas e Patrocinadores</h2>
            <div class="grid-form">
                <div class="form-group">
                    <label>Título das Etapas</label>
                    <input type="text" name="etapas_titulo" class="form-control" value="<?php echo htmlspecialchars($etapas_titulo); ?>">
                </div>
                <div class="form-group">
                    <label>Título dos Patrocinadores</label>
                    <input type="text" name="patrocinadores_titulo" class="form-control" value="<?php echo htmlspecialchars($pat_titulo); ?>">
                </div>
            </div>
            <div class="form-group">
                <label>Texto de Agradecimento aos Patrocinadores</label>
                <textarea name="patrocinadores_agradecimento" class="form-control" rows="2"><?php echo htmlspecialchars($pat_agrade); ?></textarea>
            </div>

            <div class="form-acoes" style="margin-top: 30px; border-top: 1px solid var(--glass-border); padding-top: 20px;">
                <button type="submit" class="btn-primario" style="width: 100%; justify-content: center; font-size: 1.1rem; padding: 15px;">
                    <i class="fa-solid fa-floppy-disk"></i> Guardar Todas as Alterações
                </button>
            </div>
        </form>
    </div>

   

    <script>
        function togglePainelMenu() {
            const menu = document.getElementById("painelLinks");
            const icon = document.getElementById("painel-icon");
            menu.classList.toggle("show");
            icon.textContent = menu.classList.contains("show") ? "✖" : "☰";
        }
    </script>
</body>
</html>