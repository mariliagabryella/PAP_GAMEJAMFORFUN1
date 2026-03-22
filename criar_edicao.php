<?php
session_start();
include 'bd_connection.php'; // ligação correta à BD

// Apenas Admin Master (1) e Admin (2)
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    die("Sem permissão para aceder a esta página.");
}

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    try {
        // 1. Inserir a nova Edição
        $sql = "INSERT INTO edicoes (
            titulo_pagina, titulo_evento, edicao_numero, data_evento,
            tema, participantes1, participantes2, local, descricao,
            cronograma, patrocinadores_titulo, patrocinadores_agradecimento
        ) VALUES (
            :titulo_pagina, :titulo_evento, :edicao_numero, :data_evento,
            :tema, :participantes1, :participantes2, :local, :descricao,
            :cronograma, :patrocinadores_titulo, :patrocinadores_agradecimento
        )";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':titulo_pagina' => $_POST["titulo_pagina"],
            ':titulo_evento' => $_POST["titulo_evento"],
            ':edicao_numero' => $_POST["edicao_numero"],
            ':data_evento' => $_POST["data_evento"],
            ':tema' => $_POST["tema"],
            ':participantes1' => $_POST["participantes1"],
            ':participantes2' => $_POST["participantes2"],
            ':local' => $_POST["local"],
            ':descricao' => $_POST["descricao"],
            ':cronograma' => $_POST["cronograma"],
            ':patrocinadores_titulo' => $_POST["patrocinadores_titulo"],
            ':patrocinadores_agradecimento' => $_POST["patrocinadores_agradecimento"]
        ]);

        // 2. Apanhar o ID da edição que acabámos de criar
        $nova_edicao_id = $pdo->lastInsertId();

        // 3. Processar Upload das Fotos do Carrossel
        if (!empty($_FILES['fotos_carrossel']['name'][0])) {
            $pasta_carrossel = 'img/carrossel/';
            if (!is_dir($pasta_carrossel)) mkdir($pasta_carrossel, 0777, true);

            foreach ($_FILES['fotos_carrossel']['name'] as $key => $name) {
                if ($_FILES['fotos_carrossel']['error'][$key] == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['fotos_carrossel']['tmp_name'][$key];
                    $extensao = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    $novo_nome = uniqid('carrossel_') . '.' . $extensao;
                    $destino = $pasta_carrossel . $novo_nome;

                    if (move_uploaded_file($tmp_name, $destino)) {
                        $sql_foto = "INSERT INTO fotos_carrossel (edicao_id, caminho) VALUES (?, ?)";
                        $pdo->prepare($sql_foto)->execute([$nova_edicao_id, $destino]);
                    }
                }
            }
        }

        // 4. Processar Upload dos Logótipos dos Patrocinadores
        if (!empty($_FILES['logos_patrocinadores']['name'][0])) {
            $pasta_patrocinadores = 'img/patrocinadores/';
            if (!is_dir($pasta_patrocinadores)) mkdir($pasta_patrocinadores, 0777, true);

            foreach ($_FILES['logos_patrocinadores']['name'] as $key => $name) {
                if ($_FILES['logos_patrocinadores']['error'][$key] == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['logos_patrocinadores']['tmp_name'][$key];
                    $extensao = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    $novo_nome = uniqid('patrocinador_') . '.' . $extensao;
                    $destino = $pasta_patrocinadores . $novo_nome;

                    if (move_uploaded_file($tmp_name, $destino)) {
                        $sql_patroc = "INSERT INTO patrocinadores (edicao_id, logo) VALUES (?, ?)";
                        $pdo->prepare($sql_patroc)->execute([$nova_edicao_id, $destino]);
                    }
                }
            }
        }

        // Redireciona com sucesso
        header("Location: admin_edicoes.php?msg=criada");
        exit;

    } catch (PDOException $e) {
        die("Erro ao criar a edição: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Nova Edição</title>

    <script src="https://cdn.tiny.cloud/1/88cghqoghdad9ff815vom8yl8or773zmi26pvjk1edd43lsz/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
        selector: '.editor-html',
        height: 250,
        menubar: false,
        plugins: 'link lists',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link | removeformat',
        content_style: 'body { background:#050816; color:#fff; }'
    });
    </script>

    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<h1>Criar Nova Edição</h1>

<form method="POST" enctype="multipart/form-data" class="admin-form">

    <div class="form-group">
        <label>Título da Página</label>
        <input type="text" name="titulo_pagina" required>
    </div>

    <div class="form-group">
        <label>Título do Evento</label>
        <input type="text" name="titulo_evento" required>
    </div>

    <div class="form-group">
        <label>Número da Edição</label>
        <input type="text" name="edicao_numero" required>
    </div>

    <div class="form-group">
        <label>Data do Evento</label>
        <input type="text" name="data_evento" required>
    </div>

    <div class="form-group">
        <label>Tema</label>
        <input type="text" name="tema">
    </div>

    <div class="form-group">
        <label>Participantes (linha 1)</label>
        <input type="text" name="participantes1">
    </div>

    <div class="form-group">
        <label>Participantes (linha 2)</label>
        <input type="text" name="participantes2">
    </div>

    <div class="form-group">
        <label>Local</label>
        <input type="text" name="local">
    </div>

    <div class="form-group">
        <label>Descrição</label>
        <textarea name="descricao" class="editor-html"></textarea>
    </div>

    <div class="form-group">
        <label>Cronograma</label>
        <textarea name="cronograma" class="editor-html"></textarea>
    </div>

    <hr style="border-color: #374151; margin: 30px 0;">

    <h3><i class="fa-solid fa-images"></i> Imagens e Parceiros</h3>

    <div class="form-group">
        <label>Fotos do Carrossel (Podes selecionar várias)</label>
        <input type="file" name="fotos_carrossel[]" multiple accept="image/*">
        <small style="color: #9ca3af;">Pressiona CTRL para escolheres mais do que uma imagem.</small>
    </div>

    <div class="form-group">
        <label>Título dos Patrocinadores</label>
        <input type="text" name="patrocinadores_titulo">
    </div>

    <div class="form-group">
        <label>Agradecimento</label>
        <input type="text" name="patrocinadores_agradecimento">
    </div>

    <div class="form-group">
        <label>Logótipos dos Patrocinadores (Podes selecionar vários)</label>
        <input type="file" name="logos_patrocinadores[]" multiple accept="image/*">
    </div>

    <button type="submit" class="btn-primary" style="margin-top: 20px;">
        <i class="fa-solid fa-floppy-disk"></i> Criar Edição
    </button>
</form>

</body>
</html>