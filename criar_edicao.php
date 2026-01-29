<?php
session_start();
include 'bd_connection.php'; // ligação correta à BD

// Apenas Admin Master (1) e Admin (2)
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    die("Sem permissão para aceder a esta página.");
}

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

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

    header("Location: admin_edicoes.php?msg=criada");
    exit;
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
</head>

<body>

<h1>Criar Nova Edição</h1>

<form method="POST">

    <label>Título da Página</label>
    <input type="text" name="titulo_pagina" required>

    <label>Título do Evento</label>
    <input type="text" name="titulo_evento" required>

    <label>Número da Edição</label>
    <input type="text" name="edicao_numero" required>

    <label>Data do Evento</label>
    <input type="text" name="data_evento" required>

    <label>Tema</label>
    <input type="text" name="tema">

    <label>Participantes (linha 1)</label>
    <input type="text" name="participantes1">

    <label>Participantes (linha 2)</label>
    <input type="text" name="participantes2">

    <label>Local</label>
    <input type="text" name="local">

    <label>Descrição</label>
    <textarea name="descricao" class="editor-html"></textarea>

    <label>Cronograma</label>
    <textarea name="cronograma" class="editor-html"></textarea>

    <label>Título dos Patrocinadores</label>
    <input type="text" name="patrocinadores_titulo">

    <label>Agradecimento</label>
    <input type="text" name="patrocinadores_agradecimento">

    <button type="submit">Criar Edição</button>
</form>

</body>
</html>
