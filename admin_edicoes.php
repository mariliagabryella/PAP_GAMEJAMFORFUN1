<?php
session_start();
include 'bd_connection.php';   // <-- ligação correta

// 1. VERIFICAÇÃO DE LOGIN
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] > 2) {
    die("Sem permissão.");
}

// 2. DADOS DO UTILIZADOR PARA O MENU
$user_id = $_SESSION["id"] ?? 0; 
$nome = $_SESSION["nome"] ?? "Utilizador";
$fotoLogado = "img/default_user.png";
$role = $_SESSION["role_id"] ?? 3;

// Buscar foto do admin (Opcional, mas mantém a consistência)
if ($user_id > 0) {
    $stmtUser = $pdo->query("SELECT foto FROM utilizadores WHERE id = $user_id");
    $userDados = $stmtUser->fetch(PDO::FETCH_ASSOC);
    if ($userDados && !empty($userDados['foto'])) {
        $fotoLogado = $userDados['foto'];
    }
}

// 3. BUSCAR TODAS AS EDIÇÕES
$edicoes = $pdo->query("SELECT id, titulo_evento, edicao_numero FROM edicoes ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gerir Edições | Painel Premium</title>
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
            <h1 class="titulo-painel">Gerir <span class="glow-text">Edições</span></h1>
        </div>

        <a href="criar_edicao.php" class="botao-nova-edicao"><i class="fa-solid fa-plus"></i> Nova Edição</a>

        <table class="tabela-edicoes">
            <tr>
                <th>ID</th>
                <th>Nome da Edição</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($edicoes as $e): ?>
            <tr>
                <td><strong>#<?= $e['id'] ?></strong></td>
                <td><?= htmlspecialchars($e['titulo_evento']) ?> - <?= htmlspecialchars($e['edicao_numero']) ?></td>
                <td>
                    <a href="editar_edicao.php?id=<?= $e['id'] ?>"><i class="fa-solid fa-pen"></i> Editar</a>
                    <a href="edicao.php?id=<?= $e['id'] ?>" target="_blank"><i class="fa-solid fa-eye"></i> Ver</a>
                    <a href="apagar_edicao.php?id=<?= $e['id'] ?>" onclick="return confirm('Tem a certeza que quer apagar esta edição?');"><i class="fa-solid fa-trash"></i> Apagar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script>
        function togglePainelMenu() {
            document.getElementById("painelLinks").classList.toggle("active");
        }
    </script>
</body>
</html>