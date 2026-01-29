<?php
// editar_edicao.php
session_start();

// Apenas admins (1 e 2)
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    die("Sem permissão para aceder a esta página.");
}

$EDICAO_ID = isset($_GET["id"]) ? intval($_GET["id"]) : 1;

$host = '127.0.0.1';
$dbname = 'gamejamforfun2';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Erro BD: " . $conn->connect_error);
}

$mensagem = "";
$nome = $_SESSION["usuarioNome"] ?? "Utilizador"; $role = $_SESSION["role_id"] ?? 0; $fotoLogado = $_SESSION["usuarioFoto"] ?? "img/default-user.png";

/* ============================================================
   GUARDAR CAMPOS DE TEXTO DA EDIÇÃO
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["guardar_edicao"])) {

    $titulo_pagina   = $_POST["titulo_pagina"] ?? "";
    $titulo_evento   = $_POST["titulo_evento"] ?? "";
    $edicao_numero   = $_POST["edicao_numero"] ?? "";
    $data_evento     = $_POST["data_evento"] ?? "";
    $tema            = $_POST["tema"] ?? "";
    $participantes1  = $_POST["participantes1"] ?? "";
    $participantes2  = $_POST["participantes2"] ?? "";
    $local           = $_POST["local"] ?? "";
    $descricao       = $_POST["descricao"] ?? "";
    $cronograma      = $_POST["cronograma"] ?? "";
    $pat_titulo      = $_POST["patrocinadores_titulo"] ?? "";
    $pat_agradece    = $_POST["patrocinadores_agradecimento"] ?? "";

    $stmt = $conn->prepare("UPDATE edicoes 
        SET titulo_pagina=?, titulo_evento=?, edicao_numero=?, data_evento=?, tema=?, 
            participantes1=?, participantes2=?, local=?, descricao=?, cronograma=?,
            patrocinadores_titulo=?, patrocinadores_agradecimento=?
        WHERE id=?");
    $stmt->bind_param(
        "ssssssssssssi",
        $titulo_pagina,
        $titulo_evento,
        $edicao_numero,
        $data_evento,
        $tema,
        $participantes1,
        $participantes2,
        $local,
        $descricao,
        $cronograma,
        $pat_titulo,
        $pat_agradece,
        $EDICAO_ID
    );

    if ($stmt->execute()) {
        $mensagem = "Conteúdo da edição atualizado com sucesso.";
    } else {
        $mensagem = "Erro ao atualizar edição: " . $stmt->error;
    }
    $stmt->close();
}

/* ============================================================
   UPLOAD IMAGENS CARROSSEL
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["upload_carrossel"])) {

    if (!empty($_FILES["carrossel_imagens"]["name"][0])) {

        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES["carrossel_imagens"]["tmp_name"] as $idx => $tmpName) {
            if (!is_uploaded_file($tmpName)) continue;

            $nomeOriginal = basename($_FILES["carrossel_imagens"]["name"][$idx]);
            $ext = pathinfo($nomeOriginal, PATHINFO_EXTENSION);
            $novoNome = time() . "_" . uniqid() . "." . $ext;
            $destino = $uploadDir . $novoNome;

            if (move_uploaded_file($tmpName, $destino)) {
                $legenda = $_POST["carrossel_legenda"][$idx] ?? "";

                $stmt = $conn->prepare("INSERT INTO edicoes_carrossel (id_edicao, imagem, legenda, ordem) 
                                        VALUES (?, ?, ?, 0)");
                $stmt->bind_param("iss", $EDICAO_ID, $destino, $legenda);
                $stmt->execute();
                $stmt->close();
            }
        }

        $mensagem = "Imagens do carrossel enviadas com sucesso.";
    }
}

/* ============================================================
   APAGAR IMAGEM DO CARROSSEL
============================================================ */
if (isset($_GET["del_carrossel"])) {
    $idDel = intval($_GET["del_carrossel"]);

    $stmt = $conn->prepare("SELECT imagem FROM edicoes_carrossel WHERE id=? AND id_edicao=?");
    $stmt->bind_param("ii", $idDel, $EDICAO_ID);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $ficheiro = $row["imagem"];
        if (is_file($ficheiro)) {
            @unlink($ficheiro);
        }
    }
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM edicoes_carrossel WHERE id=? AND id_edicao=?");
    $stmt->bind_param("ii", $idDel, $EDICAO_ID);
    $stmt->execute();
    $stmt->close();

    $mensagem = "Imagem do carrossel apagada.";
}

/* ============================================================
   ATUALIZAR ORDEM DO CARROSSEL
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["guardar_ordem_carrossel"])) {
    if (!empty($_POST["ordem_carrossel"])) {
        foreach ($_POST["ordem_carrossel"] as $idCar => $ordem) {
            $idCar = intval($idCar);
            $ordem = intval($ordem);
            $stmt = $conn->prepare("UPDATE edicoes_carrossel SET ordem=? WHERE id=? AND id_edicao=?");
            $stmt->bind_param("iii", $ordem, $idCar, $EDICAO_ID);
            $stmt->execute();
            $stmt->close();
        }
        $mensagem = "Ordem do carrossel atualizada.";
    }
}

/* ============================================================
   UPLOAD LOGOS PATROCINADORES
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["upload_patrocinador"])) {

    if (!empty($_FILES["patrocinador_logo"]["name"][0])) {

        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES["patrocinador_logo"]["tmp_name"] as $idx => $tmpName) {
            if (!is_uploaded_file($tmpName)) continue;

            $nomeOriginal = basename($_FILES["patrocinador_logo"]["name"][$idx]);
            $ext = pathinfo($nomeOriginal, PATHINFO_EXTENSION);
            $novoNome = time() . "_" . uniqid() . "." . $ext;
            $destino = $uploadDir . $novoNome;

            if (move_uploaded_file($tmpName, $destino)) {
                $link = $_POST["patrocinador_link"][$idx] ?? "#";

                $stmt = $conn->prepare("INSERT INTO edicoes_patrocinadores (id_edicao, logo, link, ordem) 
                                        VALUES (?, ?, ?, 0)");
                $stmt->bind_param("iss", $EDICAO_ID, $destino, $link);
                $stmt->execute();
                $stmt->close();
            }
        }

        $mensagem = "Patrocinadores adicionados com sucesso.";
    }
}

/* ============================================================
   APAGAR PATROCINADOR
============================================================ */
if (isset($_GET["del_patrocinador"])) {
    $idDel = intval($_GET["del_patrocinador"]);

    $stmt = $conn->prepare("SELECT logo FROM edicoes_patrocinadores WHERE id=? AND id_edicao=?");
    $stmt->bind_param("ii", $idDel, $EDICAO_ID);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $ficheiro = $row["logo"];
        if (is_file($ficheiro)) {
            @unlink($ficheiro);
        }
    }
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM edicoes_patrocinadores WHERE id=? AND id_edicao=?");
    $stmt->bind_param("ii", $idDel, $EDICAO_ID);
    $stmt->execute();
    $stmt->close();

    $mensagem = "Patrocinador apagado.";
}

/* ============================================================
   ATUALIZAR ORDEM PATROCINADORES
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["guardar_ordem_patrocinadores"])) {
    if (!empty($_POST["ordem_patrocinador"])) {
        foreach ($_POST["ordem_patrocinador"] as $idPat => $ordem) {
            $idPat = intval($idPat);
            $ordem = intval($ordem);
            $stmt = $conn->prepare("UPDATE edicoes_patrocinadores SET ordem=? WHERE id=? AND id_edicao=?");
            $stmt->bind_param("iii", $ordem, $idPat, $EDICAO_ID);
            $stmt->execute();
            $stmt->close();
        }
        $mensagem = "Ordem dos patrocinadores atualizada.";
    }
}

/* ============================================================
   BUSCAR DADOS ATUAIS DA EDIÇÃO
============================================================ */
$edicao = [];
$stmt = $conn->prepare("SELECT * FROM edicoes WHERE id=?");
$stmt->bind_param("i", $EDICAO_ID);
$stmt->execute();
$res = $stmt->get_result();
if ($res && $res->num_rows === 1) {
    $edicao = $res->fetch_assoc();
}
$stmt->close();

/* Carrossel */
$carrossel = [];
$resCar = $conn->query("SELECT * FROM edicoes_carrossel WHERE id_edicao = {$EDICAO_ID} ORDER BY ordem ASC, id ASC");
if ($resCar) {
    $carrossel = $resCar->fetch_all(MYSQLI_ASSOC);
}

/* Patrocinadores */
$patrocinadores = [];
$resPat = $conn->query("SELECT * FROM edicoes_patrocinadores WHERE id_edicao = {$EDICAO_ID} ORDER BY ordem ASC, id ASC");
if ($resPat) {
    $patrocinadores = $resPat->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Edição #<?php echo $EDICAO_ID; ?></title>
    <link rel="stylesheet" href="css/style3.css">
    <style>
        body { background:#050816; color:#fff; font-family: Arial, sans-serif; }
        .container-edicao { max-width: 1100px; margin: 40px auto; background:#0b1020; padding:20px 30px; border-radius:10px; }
        h1, h2 { margin-bottom:10px; }
        label { display:block; margin-top:10px; font-weight:bold; }
        input[type="text"], textarea { width:100%; padding:8px; border-radius:5px; border:1px solid #333; background:#050816; color:#fff; }
        textarea { min-height:120px; }
        .btn { margin-top:15px; padding:8px 16px; border:none; border-radius:5px; cursor:pointer; }
        .btn-primary { background:#ff0044; color:#fff; }
        .btn-secondary { background:#1f2937; color:#fff; }
        .grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:15px; margin-top:10px; }
        .card-mini { background:#111827; padding:10px; border-radius:8px; text-align:center; }
        .card-mini img { max-width:100%; max-height:120px; object-fit:cover; border-radius:5px; }
        .msg { margin-bottom:15px; padding:10px; border-radius:5px; background:#064e3b; color:#bbf7d0; }
        .ordem-input { width:60px; text-align:center; }
        a.apagar { color:#f87171; display:inline-block; margin-top:5px; }
        .tabs { display:flex; gap:10px; margin-bottom:15px; flex-wrap:wrap; }
        .tab-btn { padding:8px 14px; border-radius:5px; border:none; cursor:pointer; background:#111827; color:#fff; }
        .tab-btn.active { background:#ff0044; }
        .tab-content { display:none; }
        .tab-content.active { display:block; }
    </style>

    <!-- TinyMCE (editor WYSIWYG) -->
  <script src="https://cdn.tiny.cloud/1/your-api-key-88cghqoghdad9ff815vom8yl8or773zmi26pvjk1edd43lsz/tinymce/6/tinymce.min.js" referrerpolicy="origin">

    tinymce.init({
        selector: '.editor-html',
        height: 250,
        menubar: false,
        plugins: 'link lists',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link | removeformat',
        content_style: 'body { background:#050816; color:#fff; }'
    });
    </script>
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



<div class="container-edicao">
    <h1>Editar Edição #<?php echo $EDICAO_ID; ?></h1>

    <?php if ($mensagem): ?>
        <div class="msg"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <div class="tabs">
        <button class="tab-btn active" data-tab="tab-geral">Geral</button>
        <button class="tab-btn" data-tab="tab-carrossel">Carrossel</button>
        <button class="tab-btn" data-tab="tab-patrocinadores">Patrocinadores</button>
    </div>

    <!-- ===================== TAB GERAL ===================== -->
    <div id="tab-geral" class="tab-content active">
        <form method="post">
            <h2>Informação Geral</h2>

            <label>Título da Página</label>
            <input type="text" name="titulo_pagina" value="<?php echo htmlspecialchars($edicao['titulo_pagina'] ?? ''); ?>">

            <label>Título do Evento</label>
            <input type="text" name="titulo_evento" value="<?php echo htmlspecialchars($edicao['titulo_evento'] ?? ''); ?>">

            <label>Número da Edição (ex: 1ª Edição)</label>
            <input type="text" name="edicao_numero" value="<?php echo htmlspecialchars($edicao['edicao_numero'] ?? ''); ?>">

            <label>Data do Evento</label>
            <input type="text" name="data_evento" value="<?php echo htmlspecialchars($edicao['data_evento'] ?? ''); ?>">

            <label>Tema</label>
            <input type="text" name="tema" value="<?php echo htmlspecialchars($edicao['tema'] ?? ''); ?>">

            <label>Participantes (linha 1)</label>
            <input type="text" name="participantes1" value="<?php echo htmlspecialchars($edicao['participantes1'] ?? ''); ?>">

            <label>Participantes (linha 2)</label>
            <input type="text" name="participantes2" value="<?php echo htmlspecialchars($edicao['participantes2'] ?? ''); ?>">

            <label>Local</label>
            <input type="text" name="local" value="<?php echo htmlspecialchars($edicao['local'] ?? ''); ?>">

            <h2>Descrição</h2>
            <textarea name="descricao" class="editor-html"><?php echo htmlspecialchars($edicao['descricao'] ?? ''); ?></textarea>

            <h2>Cronograma</h2>
            <textarea name="cronograma" class="editor-html"><?php echo htmlspecialchars($edicao['cronograma'] ?? ''); ?></textarea>

            <h2>Patrocinadores (Texto)</h2>
            <label>Título</label>
            <input type="text" name="patrocinadores_titulo" value="<?php echo htmlspecialchars($edicao['patrocinadores_titulo'] ?? ''); ?>">

            <label>Agradecimento</label>
            <textarea name="patrocinadores_agradecimento"><?php echo htmlspecialchars($edicao['patrocinadores_agradecimento'] ?? ''); ?></textarea>

            <button type="submit" name="guardar_edicao" class="btn btn-primary">Guardar Conteúdo</button>
        </form>
    </div>

    <!-- ===================== TAB CARROSSEL ===================== -->
    <div id="tab-carrossel" class="tab-content">
        <h2>Carrossel de Imagens</h2>

        <form method="post" enctype="multipart/form-data">
            <label>Adicionar novas imagens</label>
            <input type="file" name="carrossel_imagens[]" multiple>

            <p>Podes opcionalmente escrever legendas (na mesma ordem das imagens):</p>
            <div id="legendas-carrossel"></div>

            <button type="submit" name="upload_carrossel" class="btn btn-primary">Enviar Imagens</button>
        </form>

        <hr>

        <form method="post">
            <h3>Imagens atuais</h3>
            <div class="grid">
                <?php foreach ($carrossel as $c): ?>
                    <div class="card-mini">
                        <img src="<?php echo htmlspecialchars($c['imagem']); ?>" alt="">
                        <div>ID: <?php echo $c['id']; ?></div>
                        <div>
                            Ordem: 
                            <input type="number" class="ordem-input" 
                                   name="ordem_carrossel[<?php echo $c['id']; ?>]" 
                                   value="<?php echo (int)$c['ordem']; ?>">
                        </div>
                        <a class="apagar" 
                           href="editar_edicao.php?id=<?php echo $EDICAO_ID; ?>&del_carrossel=<?php echo $c['id']; ?>"
                           onclick="return confirm('Apagar esta imagem do carrossel?');">
                           Apagar
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" name="guardar_ordem_carrossel" class="btn btn-secondary">Guardar Ordem</button>
        </form>
    </div>

    <!-- ===================== TAB PATROCINADORES ===================== -->
    <div id="tab-patrocinadores" class="tab-content">
        <h2>Patrocinadores (Logos)</h2>

        <form method="post" enctype="multipart/form-data">
            <label>Adicionar novos patrocinadores</label>
            <input type="file" name="patrocinador_logo[]" multiple>

            <p>Links (na mesma ordem dos logos):</p>
            <div id="links-patrocinadores"></div>

            <button type="submit" name="upload_patrocinador" class="btn btn-primary">Enviar Patrocinadores</button>
        </form>

        <hr>

        <form method="post">
            <h3>Patrocinadores atuais</h3>
            <div class="grid">
                <?php foreach ($patrocinadores as $p): ?>
                    <div class="card-mini">
                        <img src="<?php echo htmlspecialchars($p['logo']); ?>" alt="">
                        <div>ID: <?php echo $p['id']; ?></div>
                        <div>Link: <small><?php echo htmlspecialchars($p['link']); ?></small></div>
                        <div>
                            Ordem: 
                            <input type="number" class="ordem-input" 
                                   name="ordem_patrocinador[<?php echo $p['id']; ?>]" 
                                   value="<?php echo (int)$p['ordem']; ?>">
                        </div>
                        <a class="apagar" 
                           href="editar_edicao.php?id=<?php echo $EDICAO_ID; ?>&del_patrocinador=<?php echo $p['id']; ?>"
                           onclick="return confirm('Apagar este patrocinador?');">
                           Apagar
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" name="guardar_ordem_patrocinadores" class="btn btn-secondary">Guardar Ordem</button>
        </form>
    </div>
</div>

<script>
// Tabs simples
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(tc => tc.classList.remove('active'));

        btn.classList.add('active');
        document.getElementById(btn.dataset.tab).classList.add('active');
    });
});

// Campos de legenda e links (simples, só texto livre)
const legendasDiv = document.getElementById('legendas-carrossel');
if (legendasDiv) {
    legendasDiv.innerHTML = '<textarea name="carrossel_legenda[]" placeholder="Legenda 1 (opcional)"></textarea>';
}

const linksDiv = document.getElementById('links-patrocinadores');
if (linksDiv) {
    linksDiv.innerHTML = '<input type="text" name="patrocinador_link[]" placeholder="Link 1 (opcional)">';
}
</script>

</body>
</html>
