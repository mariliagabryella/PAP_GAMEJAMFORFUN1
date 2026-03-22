<?php
session_start();
include 'bd_connection.php';

// 1. VERIFICAÇÃO DE LOGIN E PERMISSÕES
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    die("Sem permissão.");
}

// 2. DADOS DO UTILIZADOR PARA O MENU LATERAL
$user_id = $_SESSION["id"] ?? 0; 
$nome = $_SESSION["nome"] ?? "Utilizador";
$fotoLogado = "img/default_user.png";
$role = $_SESSION["role_id"] ?? 3;

if ($user_id > 0) {
    $stmtUser = $pdo->query("SELECT foto FROM utilizadores WHERE id = $user_id");
    $userDados = $stmtUser->fetch(PDO::FETCH_ASSOC);
    if ($userDados && !empty($userDados['foto'])) {
        $fotoLogado = $userDados['foto'];
    }
}

// 3. LOGICA DA PÁGINA DE INSCRIÇÃO
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

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Inscrições | Painel Premium</title>
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

            <?php if ($role <= 2): ?>
                <a href="admin.php"><i class="active"></i> Painel</a>
            <?php endif; ?>

            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">
        <div class="cabecalho-dashboard">
                <a href="editar_site.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
            <h1 class="titulo-painel">Editar Página de <span class="glow-text">Inscrição</span></h1>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'guardado'): ?>
            <div class="notif-card lida" style="border-left: 4px solid #2ecc71; margin-bottom: 20px;">
                <div class="notif-icone"><i class="fa-solid fa-circle-check" style="color: #2ecc71;"></i></div>
                <div class="notif-conteudo">
                    <p class="notif-mensagem">Conteúdo guardado com sucesso!</p>
                </div>
            </div>
        <?php endif; ?>

        <div class="card-admin">
            <h2><i class="fa-solid fa-align-left"></i> Textos da Página</h2>
            <form method="POST">
                <div class="form-group-contact">
                    <label>Título Principal:</label>
                    <input type="text" name="titulo" value="<?= htmlspecialchars($pagina['titulo']) ?>" required>
                </div>
                <div class="form-group-contact">
                    <label>Subtítulo / Descrição:</label>
                    <textarea name="subtitulo" rows="3"><?= htmlspecialchars($pagina['subtitulo']) ?></textarea>
                </div>
                <button type="submit" name="guardar_pagina" class="btn-save" style="width: 100%; margin-top: 10px;">
                    <i class="fa-solid fa-floppy-disk"></i> GUARDAR TEXTOS
                </button>
            </form>
        </div>

        <div class="card-admin">
            <h2><i class="fa-solid fa-gamepad"></i> Gestão de Plataformas</h2>
            <ul class="list-group">
                <?php foreach ($plataformas as $p): ?>
                    <li class="list-item">
                        <span><?= htmlspecialchars($p['nome']) ?></span>
                        <a href="?del_plataforma=<?= $p['id'] ?>" class="btn-delete-small" onclick="return confirm('Apagar plataforma?');"><i class="fa-solid fa-trash"></i></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <form method="POST" class="form-inline">
                <input type="text" name="nome_plataforma" placeholder="Nome da nova plataforma..." required>
                <button type="submit" name="add_plataforma"><i class="fa-solid fa-plus"></i> Adicionar</button>
            </form>
        </div>

        <div class="card-admin">
            <h2><i class="fa-solid fa-code"></i> Gestão de Linguagens</h2>
            <ul class="list-group">
                <?php foreach ($linguagens as $l): ?>
                    <li class="list-item">
                        <span><?= htmlspecialchars($l['nome']) ?></span>
                        <a href="?del_linguagem=<?= $l['id'] ?>" class="btn-delete-small" onclick="return confirm('Apagar linguagem?');"><i class="fa-solid fa-trash"></i></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <form method="POST" class="form-inline">
                <input type="text" name="nome_linguagem" placeholder="Nome da nova linguagem..." required>
                <button type="submit" name="add_linguagem"><i class="fa-solid fa-plus"></i> Adicionar</button>
            </form>
        </div>

    </div>

    <script>
        function togglePainelMenu() {
            document.getElementById("painelLinks").classList.toggle("active");
        }
    </script>
</body>
</html>