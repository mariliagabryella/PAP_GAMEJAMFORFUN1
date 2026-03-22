<?php

/* ============================================================
   INICIAR SESSÃO E LIGAR À BASE DE DADOS (Usando PDO)
   ============================================================ */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Usamos o teu ficheiro padrão para não haver falhas de conexão
include 'bd_connection.php'; 

/* ============================================================
   BUSCAR DADOS DO UTILIZADOR LOGADO
   ============================================================ */
$userId = $_SESSION["id"] ?? null;

if (!$userId) {
    header("Location: login.php?erro=Precisa+de+iniciar+sessao");
    exit();
}

// Usar PDO para ir buscar os dados
$stmt = $pdo->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$nome = $user["nome"];
$fotoLogado = !empty($user["foto"]) ? $user["foto"] : "img/default_user.png";
$role = $user["role_id"];

/* ============================================================
   BUSCAR INSCRIÇÕES (Com tratamento de erros)
   ============================================================ */
try {
    // ATENÇÃO: Se a coluna na BD não for "user_id", altera na linha abaixo (ex: u.id = i.utilizador_id)
    $sql = "SELECT i.*, u.nome AS nome_user
            FROM inscricoes i
            LEFT JOIN utilizadores u ON i.user_id = u.id
            ORDER BY i.data_inscricao DESC";
            
    $stmt_inscricoes = $pdo->query($sql);
    $inscricoes = $stmt_inscricoes->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Se houver um erro de colunas, agora vai aparecer no ecrã em vez de ficar tudo em branco!
    die("Erro ao carregar as inscrições da Base de Dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Inscrições | Painel Premium</title>
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
                <a href="editar_site.php">Editar Site</a>
                <a href="#" class="danger" onclick="abrirPopupEliminar()"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>
            <?php endif; ?>

            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">

        <div class="cabecalho-dashboard">
            <h1 class="titulo-painel">Game Jam <span class="glow-text">Inscrições</span></h1>
        </div>

        <section class="secao glass-panel">
            <h2 class="secao-titulo"><i class="fa-solid fa-file-signature"></i> Lista de Participantes</h2>
            
            <div class="tabela-container">
                <table class="tabela-users">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Utilizador</th>
                            <th>Instituição</th>
                            <th>Professor</th>
                            <th>Plataforma</th>
                            <th>Linguagem</th>
                            <th>Participantes</th>
                            <th>Estado</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($inscricoes)): ?>
                            <tr>
                                <td colspan="10" style="text-align: center; padding: 20px;">Nenhuma inscrição encontrada.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($inscricoes as $row): ?>
                                <tr>
                                    <td class="text-muted">#<?php echo $row['id']; ?></td>
                                    <td class="fw-bold"><?php echo !empty($row['nome_user']) ? htmlspecialchars($row['nome_user']) : "<i>N/A</i>"; ?></td>
                                    <td><?php echo htmlspecialchars($row['instituicao'] ?? ''); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($row['professor'] ?? ''); ?><br>
                                        <span style="font-size: 0.75rem; color: #9ca3af;"><?php echo htmlspecialchars($row['email_professor'] ?? ''); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['plataforma'] ?? ''); ?></td>
                                    <td>
                                        <?php 
                                        echo htmlspecialchars($row['linguagem'] ?? '');
                                        if (!empty($row['linguagem_outra'])) {
                                            echo " <span class='text-muted'>(" . htmlspecialchars($row['linguagem_outra']) . ")</span>";
                                        }
                                        ?>
                                    </td>
                                    <td><i class="fa-solid fa-users text-muted"></i> <?php echo (int)($row['num_participantes'] ?? 0); ?></td>
                                    
                                    <td>
                                        <?php if (($row['estado'] ?? '') == 'pendente'): ?>
                                            <span class="badge badge-pendente"><i class="fa-solid fa-clock"></i> Pendente</span>
                                        <?php elseif (($row['estado'] ?? '') == 'aprovado'): ?>
                                            <span class="badge badge-aprovado"><i class="fa-solid fa-check"></i> Aprovado</span>
                                        <?php else: ?>
                                            <span class="badge badge-rejeitado"><i class="fa-solid fa-xmark"></i> Rejeitado</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <td class="text-muted" style="font-size: 0.85rem;"><?php echo date("d/m/Y", strtotime($row['data_inscricao'])); ?></td>

                                    <td class="acoes">
                                        <?php if (($row['estado'] ?? '') == 'pendente'): ?>
                                            <a href="aprovar_inscricoes.php?id=<?php echo $row['id']; ?>" class="acao aprovar tooltip" title="Aprovar"><i class="fa-solid fa-check-circle"></i></a>
                                            <a href="rejeitar_inscricao.php?id=<?php echo $row['id']; ?>" class="acao rejeitar tooltip" title="Rejeitar"><i class="fa-solid fa-circle-xmark"></i></a>
                                        <?php endif; ?>
                                        <a href="editar_inscricao.php?id=<?php echo $row['id']; ?>" class="acao editar tooltip" title="Editar"><i class="fa-solid fa-pen"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
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