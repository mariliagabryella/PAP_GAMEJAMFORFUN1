<?php
session_start();
include 'bd_connection.php';   // <-- ligação correta

// Apenas admins
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    die("Sem permissão.");
}

// Buscar todas as edições
$edicoes = $pdo->query("SELECT id, titulo_evento, edicao_numero FROM edicoes ORDER BY id ASC");
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Edições</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>

<h1>Gerir Edições</h1>

<a href="criar_edicao.php" class="botao-nova-edicao">➕ Nova Edição</a>

<table class="tabela-edicoes">
    <tr>
        <th>ID</th>
        <th>Edição</th>
        <th>Ações</th>
    </tr>

   <?php foreach ($edicoes as $e): ?>

    <tr>
        <td><?= $e['id'] ?></td>
        <td><?= $e['titulo_evento'] ?> - <?= $e['edicao_numero'] ?></td>
        <td>
            <a href="editar_edicao.php?id=<?= $e['id'] ?>">✏️ Editar</a>
            <a href="edicao.php?id=<?= $e['id'] ?>" target="_blank">👁️ Ver</a>
            <a href="apagar_edicao.php?id=<?= $e['id'] ?>" onclick="return confirm('Tem a certeza que quer apagar esta edição?');">🗑️ Apagar</a>
        </td>
    </tr>
  <?php endforeach; ?>
</table>

</body>
</html>
