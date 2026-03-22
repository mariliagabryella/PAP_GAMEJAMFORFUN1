<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* Verificar login */
if (!isset($_SESSION["id"])) {
    header("Location: login.php?erro=Precisa+de+iniciar+sessao");
    exit();
}


/* Buscar dados do utilizador logado */
$userId = $_SESSION["id"];
$stmt = $conn->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$nome = $user["nome"];
$fotoLogado = $user["foto"] ?: "img/default.png";
$role = $user["role_id"];

/* Apenas admin master (1) e admin normal (2) podem editar */
if ($role != 1 && $role != 2) {
    die("Acesso negado.");
}

/* Buscar ID da inscrição */
$id = $_GET["id"] ?? null;
if (!$id) {
    die("ID inválido.");
}

/* Buscar dados da inscrição */
$stmt = $conn->prepare("SELECT * FROM inscricoes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$inscricao = $stmt->get_result()->fetch_assoc();

if (!$inscricao) {
    die("Inscrição não encontrada.");
}

/* Atualizar inscrição */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $instituicao = $_POST["instituicao"];
    $professor = $_POST["professor"];
    $email_professor = $_POST["email_professor"];
    $plataforma = $_POST["plataforma"];
    $linguagem = $_POST["linguagem"];
    $linguagem_outra = $_POST["linguagem_outra"];
    $num_participantes = $_POST["num_participantes"];
    $novo_estado = $_POST["estado"];

    // 1. Guardar o estado antigo para saber se houve mudança
    $estado_antigo = $inscricao['estado'];

    // 2. Atualizar todos os dados na base de dados
    $stmt = $conn->prepare("
        UPDATE inscricoes 
        SET instituicao=?, professor=?, email_professor=?, plataforma=?, linguagem=?, linguagem_outra=?, num_participantes=?, estado=?
        WHERE id=?
    ");

    $stmt->bind_param("ssssssisi", 
        $instituicao, $professor, $email_professor, $plataforma, 
        $linguagem, $linguagem_outra, $num_participantes, $novo_estado, $id
    );

    $stmt->execute();

    // 3. Se o estado mudou, CHAMAR os ficheiros existentes passando o ID
    if ($estado_antigo !== $novo_estado) {
        if ($novo_estado === 'aprovado') {
            header("Location: aprovar_inscricoes.php?id=" . $id);
            exit();
        } elseif ($novo_estado === 'rejeitado') {
            header("Location: rejeitar_inscricao.php?id=" . $id);
            exit();
        }
    }

    // 4. Se o estado for igual ao que estava, volta à tabela normalmente
    header("Location: admin_inscricoes.php?sucesso=1");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Inscrição | Painel Premium</title>
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

                <a href="#" class="danger" onclick="abrirPopupEliminar()"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>
            <?php endif; ?>

            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content form-page">
        <div class="cabecalho-dashboard">
            <a href="admin_inscricoes.php" class="btn-voltar"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
            <h1 class="titulo-painel">Editar <span class="glow-text">Inscrição #<?php echo $id; ?></span></h1>
        </div>

        <div class="glass-panel form-wrapper">
            <h2 class="secao-titulo"><i class="fa-solid fa-pen-to-square"></i> Detalhes da Inscrição</h2>
            
            <form method="POST" class="form-grid">
                <div class="form-group">
                    <label>Instituição</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-building"></i>
                        <input type="text" name="instituicao" value="<?php echo htmlspecialchars($inscricao['instituicao']); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Professor Responsável</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-chalkboard-user"></i>
                        <input type="text" name="professor" value="<?php echo htmlspecialchars($inscricao['professor']); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email do Professor</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email_professor" value="<?php echo htmlspecialchars($inscricao['email_professor']); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Plataforma</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-desktop"></i>
                        <input type="text" name="plataforma" value="<?php echo htmlspecialchars($inscricao['plataforma']); ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Linguagem</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-code"></i>
                        <input type="text" name="linguagem" value="<?php echo htmlspecialchars($inscricao['linguagem']); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Outra Linguagem</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-laptop-code"></i>
                        <input type="text" name="linguagem_outra" value="<?php echo htmlspecialchars($inscricao['linguagem_outra']); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nº de Participantes</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-users"></i>
                        <input type="number" name="num_participantes" value="<?php echo $inscricao['num_participantes']; ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Estado da Inscrição</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-flag"></i>
                        <select name="estado">
                            <option value="pendente" <?php if ($inscricao['estado']=="pendente") echo "selected"; ?>>Pendente</option>
                            <option value="aprovado" <?php if ($inscricao['estado']=="aprovado") echo "selected"; ?>>Aprovado</option>
                            <option value="rejeitado" <?php if ($inscricao['estado']=="rejeitado") echo "selected"; ?>>Rejeitado</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions full-width">
                    <button type="submit" class="btn-acao btn-primary btn-large">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Alterações
                    </button>
                </div>
            </form>
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
</body>
</html>