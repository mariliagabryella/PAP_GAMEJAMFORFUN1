<?php
session_start();

// 1. CONEXÃO À BASE DE DADOS
$conn = new mysqli('127.0.0.1', 'root', '', 'gamejamforfun2');
$conn->set_charset("utf8mb4");

// 2. BUSCAR OS DADOS DO UTILIZADOR LOGADO
$user_id = $_SESSION["id"] ?? 0; 
$nome = $_SESSION["nome"] ?? "Utilizador"; 
$fotoLogado = "img/default_user.png"; 
$role = $_SESSION["role_id"] ?? 3;

if ($user_id > 0) {
    $resUser = $conn->query("SELECT foto FROM utilizadores WHERE id = '$user_id'");
    if ($resUser && $resUser->num_rows > 0) {
        $userDados = $resUser->fetch_assoc();
        if (!empty($userDados['foto'])) {
            $fotoLogado = $userDados['foto'];
        }
    }
}

$EDICAO_ID = isset($_GET["id"]) ? intval($_GET["id"]) : 1;
$mensagem = "";

// 3. GUARDAR ALTERAÇÕES (SÓ EXECUTA QUANDO O FORMULÁRIO É SUBMETIDO)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["guardar_edicao"])) {
    
    // --- LÓGICA DO CRONOGRAMA ---
    $titulos = $_POST['cron_titulo'] ?? [];
    $descricoes = $_POST['cron_desc'] ?? [];
    $dias = $_POST['cron_dia'] ?? [];
    $cron_html = "";
    
    // Só cria HTML se existirem etapas enviadas (assim permite apagar todas)
    if (!empty($titulos)) {
        $cron_html = '<div class="timeline">' . "\n";
        $dia_at = "";

        for ($i = 0; $i < count($titulos); $i++) {
            $d = htmlspecialchars($dias[$i]);
            $t = htmlspecialchars($titulos[$i]);
            $de = htmlspecialchars($descricoes[$i]);
            
            if (empty($d) && empty($t)) continue;

            if ($d !== $dia_at) {
                if ($dia_at !== "") $cron_html .= "</div></div>\n";
                $cron_html .= "<div class=\"timeline-item\"><div class=\"timeline-date\">$d</div><div class=\"timeline-content\">\n";
                $dia_at = $d;
            }
            $cron_html .= "<h4>$t</h4><p>$de</p>\n";
        }
        if ($dia_at !== "") $cron_html .= "</div></div>\n";
        $cron_html .= "</div>";
    }

    // --- LÓGICA DAS FOTOS DO CARROSSEL ---
    $fotos_finais = []; // DECLARADA AQUI PARA EVITAR O WARNING DA LINHA 115

    if (isset($_POST['fotos_existentes']) && is_array($_POST['fotos_existentes'])) {
        $fotos_finais = $_POST['fotos_existentes'];
    }

    if (isset($_FILES['fotos_novas']) && !empty($_FILES['fotos_novas']['name'][0])) {
        $pasta_destino = __DIR__ . "/img/"; 
        if (!is_dir($pasta_destino)) {
            mkdir($pasta_destino, 0777, true);
        }

        foreach ($_FILES['fotos_novas']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['fotos_novas']['error'][$key] === 0) { 
                $nome_original = basename($_FILES['fotos_novas']['name'][$key]);
                $novo_nome = time() . "_" . preg_replace("/[^a-zA-Z0-9\.]/", "", $nome_original);
                
                $caminho_final_absoluto = $pasta_destino . $novo_nome;
                $caminho_relativo = "img/" . $novo_nome;

                if (move_uploaded_file($tmp_name, $caminho_final_absoluto)) {
                    $fotos_finais[] = $caminho_relativo;
                } else {
                    die("❌ ERRO: Não foi possível guardar a foto na pasta 'img/'.");
                }
            }
        }
    }

    $carrossel_html = "";
    foreach ($fotos_finais as $caminho_foto) {
        $carrossel_html .= '<img src="' . htmlspecialchars($caminho_foto) . '">' . "\n";
    }

    // --- ATUALIZAR A BASE DE DADOS (AGORA SÓ HÁ UM UPDATE, DENTRO DO IF) ---
    $sql = "UPDATE edicoes SET 
        titulo_pagina=?, titulo_evento=?, edicao_numero=?, data_evento=?, 
        tema=?, local=?, participantes1=?, participantes2=?, 
        descricao=?, cronograma=?, 
        patrocinadores_titulo=?, patrocinadores_agradecimento=?, carrossel=? 
        WHERE id=?";
        
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("❌ Erro fatal ao preparar Base de Dados: " . $conn->error);
    }
    
    $stmt->bind_param("sssssssssssssi", 
        $_POST['titulo_pagina'], $_POST['titulo_evento'], $_POST['edicao_numero'], $_POST['data_evento'], 
        $_POST['tema'], $_POST['local'], $_POST['participantes1'], $_POST['participantes2'], 
        $_POST['descricao'], $cron_html, 
        $_POST['pat_titulo'], $_POST['pat_agradece'], $carrossel_html, $EDICAO_ID);
    
    if ($stmt->execute()) {
        $mensagem = "✅ Edição, cronograma e fotos atualizados com sucesso!";
    } else {
        die("❌ Erro fatal ao Guardar na BD: " . $stmt->error);
    }
}

// 4. BUSCAR DADOS ATUAIS DA EDIÇÃO PARA MOSTRAR NO FORMULÁRIO
$res = $conn->query("SELECT * FROM edicoes WHERE id=$EDICAO_ID");
$edicao = $res->fetch_assoc();

if (!$edicao) {
    $edicao = [
        'titulo_pagina' => '', 'titulo_evento' => '', 'edicao_numero' => '', 'data_evento' => '',
        'tema' => '', 'local' => '', 'participantes1' => '', 'participantes2' => '',
        'descricao' => '', 'cronograma' => '', 'patrocinadores_titulo' => '', 'patrocinadores_agradecimento' => '', 'carrossel' => ''
    ];
}

// --- EXTRAIR AS FOTOS DO HTML (MÉTODO DIRETO) ---
$fotosAtuais = []; // A variável é criada aqui para nunca dar erro!
if (!empty($edicao['carrossel'])) {
    preg_match_all('/src="([^"]+)"/i', $edicao['carrossel'], $matches);
    if (!empty($matches[1])) {
        $fotosAtuais = $matches[1];
    }
}

// --- EXTRAIR AS ETAPAS DO CRONOGRAMA ---
$etapas = [];
if (!empty($edicao['cronograma'])) {
    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($edicao['cronograma'], 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($dom);
    $items = $xpath->query("//div[contains(@class, 'timeline-item')]");
    foreach ($items as $item) {
        $dia_node = $xpath->query(".//div[contains(@class, 'timeline-date')]", $item)->item(0);
        $dia = $dia_node ? $dia_node->nodeValue : "";
        $h4s = $xpath->query(".//h4", $item);
        $ps = $xpath->query(".//p", $item);
        for ($i = 0; $i < $h4s->length; $i++) {
            $etapas[] = ['dia' => $dia, 'titulo' => $h4s->item($i)->nodeValue, 'desc' => $ps->item($i)->nodeValue ?? ""];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Edição | Painel Premium</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    
    <style>
        .lista-fotos-ordenavel {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }
        .foto-item {
            position: relative;
            cursor: grab;
            background: #1e293b;
            padding: 5px;
            border-radius: 8px;
            border: 2px dashed #475569;
        }
        .foto-item:active { cursor: grabbing; }
        .foto-item img {
            height: 100px;
            border-radius: 5px;
            display: block;
        }
        .btn-remover-foto {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
        }
        .input-file-modern {
            background: #1e293b;
            padding: 10px;
            border-radius: 8px;
            color: #fff;
            width: 100%;
            border: 1px dashed #475569;
        }
        /* Estilos para os cartões da timeline */
        .etapa-card {
            background: #1e293b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid #334155;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .etapa-card input, .etapa-card textarea {
            background: #0f172a;
            border: 1px solid #334155;
            color: white;
            padding: 8px;
            border-radius: 4px;
        }
        .del-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 5px 10px;
            font-weight: bold;
        }
    </style>
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
            <a href="admin_edicoes.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
            <h1 class="titulo-painel">Gerir <span class="glow-text">Edição do Evento</span></h1>
        </div>

        <?php if ($mensagem): ?>
            <div class="notif-card lida" style="border-left: 4px solid #2ecc71; margin-bottom: 20px;">
                <div class="notif-icone"><i class="fa-solid fa-circle-check" style="color: #2ecc71;"></i></div>
                <div class="notif-conteudo">
                    <p class="notif-mensagem"><?php echo $mensagem; ?></p>
                </div>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            
            <div class="card">
                <h3>📌 Cabeçalho e Identificação</h3>
                <div class="grid">
                    <div><label>Título da Página</label><input type="text" name="titulo_pagina" value="<?= htmlspecialchars($edicao['titulo_pagina']) ?>"></div>
                    <div><label>Título do Evento</label><input type="text" name="titulo_evento" value="<?= htmlspecialchars($edicao['titulo_evento']) ?>"></div>
                    <div><label>Número da Edição</label><input type="text" name="edicao_numero" value="<?= htmlspecialchars($edicao['edicao_numero']) ?>"></div>
                </div>
            </div>

            <div class="card">
                <h3>🗂️ Informações da Página Inicial</h3>
                <div class="grid">
                    <div><label>Tema</label><input type="text" name="tema" value="<?= htmlspecialchars($edicao['tema']) ?>"></div>
                    <div><label>Local</label><input type="text" name="local" value="<?= htmlspecialchars($edicao['local']) ?>"></div>
                    <div><label>Data</label><input type="text" name="data_evento" value="<?= htmlspecialchars($edicao['data_evento']) ?>"></div>
                    <div><label>Equipas (Linha 1)</label><input type="text" name="participantes1" value="<?= htmlspecialchars($edicao['participantes1']) ?>"></div>
                    <div><label>Escolas (Linha 2)</label><input type="text" name="participantes2" value="<?= htmlspecialchars($edicao['participantes2']) ?>"></div>
                </div>
            </div>

            <div class="card">
                <h3>📝 História</h3>
                <textarea name="descricao" id="editor_v5"><?= htmlspecialchars($edicao['descricao']) ?></textarea>
            </div>

            <div class="card">
                <h3>📸 Fotos do Carrossel</h3>
                
                <div style="margin-bottom: 20px;">
                    <label><strong>Organizar Fotos Atuais <small style="color: #94a3b8;">(Arrasta para mudar a ordem. Clica no X para apagar)</small>:</strong></label>
                    <div id="lista-fotos-ordenavel" class="lista-fotos-ordenavel">
                        <?php if (empty($fotosAtuais)): ?>
                            <p style="color:#94a3b8; width: 100%;">Nenhuma foto atualmente.</p>
                        <?php else: ?>
                            <?php foreach ($fotosAtuais as $foto): ?>
                                <div class="foto-item">
                                    <img src="<?= htmlspecialchars($foto) ?>" alt="Foto Carrossel">
                                    <input type="hidden" name="fotos_existentes[]" value="<?= htmlspecialchars($foto) ?>">
                                    <button type="button" class="btn-remover-foto" onclick="this.parentElement.remove()" title="Remover Foto"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <label><i class="fa-solid fa-upload"></i> Adicionar Novas Fotos <small style="color:#94a3b8;">(Serão adicionadas ao final do carrossel)</small></label><br><br>
                    <input type="file" name="fotos_novas[]" multiple accept="image/*" class="input-file-modern">
                </div>
            </div>
            
            <div class="card">
                <h3>⏱️ Cronograma</h3>
                <div id="lista-etapas">
                    <?php if(empty($etapas)): ?>
                         <p style="color:#94a3b8; margin-bottom:15px;">Sem etapas. Clica em "+ Adicionar Etapa" para começar.</p>
                    <?php else: ?>
                        <?php foreach ($etapas as $e): ?>
                        <div class="etapa-card">
                            <input type="text" name="cron_dia[]" value="<?= htmlspecialchars($e['dia']) ?>" placeholder="Dia">
                            <input type="text" name="cron_titulo[]" value="<?= htmlspecialchars($e['titulo']) ?>" placeholder="Hora/Título">
                            <textarea name="cron_desc[]" rows="1" placeholder="Descrição"><?= htmlspecialchars($e['desc']) ?></textarea>
                            <button type="button" class="del-btn" onclick="this.parentElement.remove()">Eliminar</button>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn-add" onclick="addEtapa()" style="padding: 10px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer;">+ Adicionar Etapa</button>
            </div>

            <div class="card">
                <h3>🤝 Patrocinadores</h3>
                <div class="grid">
                    <div><label>Título</label><input type="text" name="pat_titulo" value="<?= htmlspecialchars($edicao['patrocinadores_titulo']) ?>"></div>
                    <div><label>Texto</label><input type="text" name="pat_agradece" value="<?= htmlspecialchars($edicao['patrocinadores_agradecimento']) ?>"></div>
                </div>
            </div>

            <button type="submit" name="guardar_edicao" class="btn-save" style="width: 100%; margin-top: 20px; padding: 15px; background: #10b981; color: white; font-size: 16px; border: none; border-radius: 8px; cursor: pointer;">
                <i class="fa-solid fa-floppy-disk"></i> GUARDAR ALTERAÇÕES
            </button>
        </form>
    </div>

    <script>
        ClassicEditor.create(document.querySelector('#editor_v5')).catch(e => console.error(e));
        
        function togglePainelMenu() { document.getElementById("painelLinks").classList.toggle("active"); }
        
        function addEtapa() {
            // Remove a mensagem de "Sem etapas" se existir
            const msg = document.querySelector('#lista-etapas p');
            if(msg) msg.remove();

            const div = document.createElement('div');
            div.className = 'etapa-card';
            div.innerHTML = `
                <input type="text" name="cron_dia[]" placeholder="Dia">
                <input type="text" name="cron_titulo[]" placeholder="Hora/Título">
                <textarea name="cron_desc[]" rows="1" placeholder="Descrição"></textarea>
                <button type="button" class="del-btn" onclick="this.parentElement.remove()">Eliminar</button>
            `;
            document.getElementById('lista-etapas').appendChild(div);
        }

        // Ativa o Drag & Drop para as fotos
        document.addEventListener('DOMContentLoaded', function() {
            var listaFotos = document.getElementById('lista-fotos-ordenavel');
            if(listaFotos && listaFotos.children.length > 0 && !listaFotos.querySelector('p')) {
                new Sortable(listaFotos, {
                    animation: 150,
                    ghostClass: 'bg-blue-100'
                });
            }
        });
    </script>
</body>
</html>