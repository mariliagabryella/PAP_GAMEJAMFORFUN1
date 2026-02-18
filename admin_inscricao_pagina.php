<?php
session_start();
include 'bd_connection.php';

// Apenas admins
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    die("Sem permissão.");
}

// Buscar conteúdo da página
$stmt = $pdo->query("SELECT * FROM inscricao_pagina WHERE id = 1");
$pagina = $stmt->fetch(PDO::FETCH_ASSOC);

// Buscar plataformas
$plataformas = $pdo->query("SELECT * FROM inscricao_plataformas ORDER BY nome ASC")->fetchAll();

// Buscar linguagens
$linguagens = $pdo->query("SELECT * FROM inscricao_linguagens ORDER BY nome ASC")->fetchAll();

// Guardar título/subtítulo
if (isset($_POST['guardar_pagina'])) {
    $stmt = $pdo->prepare("UPDATE inscricao_pagina SET titulo = :titulo, subtitulo = :subtitulo WHERE id = 1");
    $stmt->execute([
        ':titulo' => $_POST['titulo'],
        ':subtitulo' => $_POST['subtitulo']
    ]);
    header("Location: admin_inscricao_pagina.php?msg=guardado");
    exit;
}

// Adicionar plataforma
if (isset($_POST['add_plataforma'])) {
    $stmt = $pdo->prepare("INSERT INTO inscricao_plataformas (nome) VALUES (:nome)");
    $stmt->execute([':nome' => $_POST['nome_plataforma']]);
    header("Location: admin_inscricao_pagina.php");
    exit;
}

// Apagar plataforma
if (isset($_GET['del_plataforma'])) {
    $stmt = $pdo->prepare("DELETE FROM inscricao_plataformas WHERE id = :id");
    $stmt->execute([':id' => $_GET['del_plataforma']]);
    header("Location: admin_inscricao_pagina.php");
    exit;
}

// Adicionar linguagem
if (isset($_POST['add_linguagem'])) {
    $stmt = $pdo->prepare("INSERT INTO inscricao_linguagens (nome) VALUES (:nome)");
    $stmt->execute([':nome' => $_POST['nome_linguagem']]);
    header("Location: admin_inscricao_pagina.php");
    exit;
}

// Apagar linguagem
if (isset($_GET['del_linguagem'])) {
    $stmt = $pdo->prepare("DELETE FROM inscricao_linguagens WHERE id = :id");
    $stmt->execute([':id' => $_GET['del_linguagem']]);
    header("Location: admin_inscricao_pagina.php");
    exit;
}
?>

<h1>Editar Página de Inscrição</h1>

<?php if (isset($_GET['msg'])): ?>
    <div style="background:#28a745;color:white;padding:10px;">Guardado com sucesso.</div>
<?php endif; ?>

<h2>Conteúdo da Página</h2>
<form method="POST">
    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?= htmlspecialchars($pagina['titulo']) ?>" required><br><br>

    <label>Subtítulo:</label><br>
    <textarea name="subtitulo" rows="3"><?= htmlspecialchars($pagina['subtitulo']) ?></textarea><br><br>

    <button type="submit" name="guardar_pagina">Guardar</button>
</form>

<hr>

<h2>Plataformas</h2>
<ul>
    <?php foreach ($plataformas as $p): ?>
        <li>
            <?= htmlspecialchars($p['nome']) ?>
            <a href="?del_plataforma=<?= $p['id'] ?>" style="color:red;">[apagar]</a>
        </li>
    <?php endforeach; ?>
</ul>

<form method="POST">
    <input type="text" name="nome_plataforma" placeholder="Nova plataforma" required>
    <button type="submit" name="add_plataforma">Adicionar</button>
</form>

<hr>

<h2>Linguagens</h2>
<ul>
    <?php foreach ($linguagens as $l): ?>
        <li>
            <?= htmlspecialchars($l['nome']) ?>
            <a href="?del_linguagem=<?= $l['id'] ?>" style="color:red;">[apagar]</a>
        </li>
    <?php endforeach; ?>
</ul>

<form method="POST">
    <input type="text" name="nome_linguagem" placeholder="Nova linguagem" required>
    <button type="submit" name="add_linguagem">Adicionar</button>
</form>
