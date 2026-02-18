<?php
session_start();
include 'bd_connection.php';


// Apenas admins
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    die("Sem permissão.");
}

// Buscar dados
$stmt = $pdo->query("SELECT * FROM contactos_pagina WHERE id = 1");
$dados = $stmt->fetch(PDO::FETCH_ASSOC);

// Guardar alterações
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = "UPDATE contactos_pagina SET
        titulo = :titulo,
        subtitulo = :subtitulo,
        facebook = :facebook,
        instagram = :instagram,
        discord = :discord,
        email = :email
        WHERE id = 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
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

<h1>Editar Página de Contactos</h1>

<?php if (isset($_GET['msg'])): ?>
    <div style="background:#28a745;color:white;padding:10px;">Guardado com sucesso.</div>
<?php endif; ?>

<form method="POST">
    <label>Título:</label><br>
    <input type="text" name="titulo" value="<?= htmlspecialchars($dados['titulo']) ?>" required><br><br>

    <label>Subtítulo:</label><br>
    <textarea name="subtitulo" rows="3"><?= htmlspecialchars($dados['subtitulo']) ?></textarea><br><br>

    <label>Facebook:</label><br>
    <input type="text" name="facebook" value="<?= htmlspecialchars($dados['facebook']) ?>"><br><br>

    <label>Instagram:</label><br>
    <input type="text" name="instagram" value="<?= htmlspecialchars($dados['instagram']) ?>"><br><br>

    <label>Discord:</label><br>
    <input type="text" name="discord" value="<?= htmlspecialchars($dados['discord']) ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($dados['email']) ?>"><br><br>

    <button type="submit">Guardar</button>
</form>
