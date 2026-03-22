<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ============================================================
   1. VERIFICAR LOGIN E CONEXÃO
============================================================ */
if (!isset($_SESSION["id"])) {
    header("Location: login.php?erro=Sessão+expirada");
    exit();
}

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* ============================================================
   2. DADOS DO UTILIZADOR LOGADO (QUEM ESTÁ A OPERAR)
============================================================ */
$userIdSessao = $_SESSION["id"];
$roleSessao = (int)$_SESSION["role_id"];

/* ============================================================
   3. DADOS DO UTILIZADOR ALVO (QUEM VAI RECEBER A PASS)
============================================================ */
if (!isset($_GET["id"])) {
    header("Location: admin.php");
    exit();
}

$idAlvo = (int) $_GET["id"];

// SEGURANÇA: Só Admins (1 e 2) ou o PRÓPRIO utilizador podem estar aqui
if ($roleSessao != 1 && $roleSessao != 2 && $userIdSessao !== $idAlvo) {
    die("Acesso negado. Não tens permissão para alterar esta password.");
}

// Buscar dados do utilizador que vai sofrer a alteração
$stmt = $conn->prepare("SELECT nome, email, foto FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $idAlvo);
$stmt->execute();
$userAlvo = $stmt->get_result()->fetch_assoc();

if (!$userAlvo) {
    die("Utilizador alvo não encontrado.");
}

// Buscar dados de quem está logado para o menu superior
$stmtMenu = $conn->prepare("SELECT nome, foto FROM utilizadores WHERE id = ?");
$stmtMenu->bind_param("i", $userIdSessao);
$stmtMenu->execute();
$dadosMenu = $stmtMenu->get_result()->fetch_assoc();

$nomeMenu = $dadosMenu["nome"];
$fotoMenu = $dadosMenu["foto"] ?: "img/default.png";

/* ============================================================
   4. PROCESSAR ALTERAÇÃO DE PASSWORD (LÓGICA SERVER-SIDE)
============================================================ */
$erro = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pass = $_POST["password"];
    $confirmPass = $_POST["confirm_password"];

    // Validação de complexidade (Regex)
    $hasUpper   = preg_match('@[A-Z]@', $pass);
    $hasLower   = preg_match('@[a-z]@', $pass);
    $hasNumber  = preg_match('@[0-9]@', $pass);
    $hasSpecial = preg_match('@[^\w]@', $pass);

    if ($pass !== $confirmPass) {
        $erro = "As passwords não coincidem!";
    } elseif (strlen($pass) < 10) {
        $erro = "A password deve ter pelo menos 10 caracteres.";
    } elseif (!$hasUpper || !$hasLower || !$hasNumber || !$hasSpecial) {
        $erro = "A password não cumpre os requisitos de segurança.";
    } else {
        $novaPassHash = password_hash($pass, PASSWORD_DEFAULT);
        
        $stmtUpdate = $conn->prepare("UPDATE utilizadores SET senha_hash=? WHERE id=?");
        $stmtUpdate->bind_param("si", $novaPassHash, $idAlvo);
        
        if ($stmtUpdate->execute()) {
            // Redirecionamento inteligente
            $destino = ($roleSessao == 3) ? "painel_do_viewer.php?sucesso=pass" : "admin.php?sucesso=pass";
            header("Location: $destino");
            exit();
        } else {
            $erro = "Erro ao atualizar a base de dados.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Segurança da Conta | Game Jam</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <div class="painel-menu">
        <div class="painel-user">
            <img src="<?php echo htmlspecialchars($fotoMenu); ?>" class="painel-foto">
            <span class="painel-ola">Olá, <span class="destaque-nome"><?php echo htmlspecialchars($nomeMenu); ?></span></span>
        </div>
        <div class="painel-links" id="painelLinks">
            <a href="index.php"><i class="fa-solid fa-house"></i>Site</a>
            <a href="editar_perfil.php"><i class="fa-solid fa-user-pen"></i> Perfil</a>
            <?php
                $voltar = ($roleSessao == 3) ? "painel_do_viewer.php" : "admin.php";
                echo "<a href='$voltar'><i class='active'></i> Painel</a>";
            ?>
         <a href="eliminar_perfil.php" class="danger"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>
            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">
        <div class="cabecalho-dashboard">
            <h1 class="titulo-painel">Atualizar <span class="glow-text">Segurança</span></h1>
        </div>

        <form method="POST" class="form-card">
            <?php if($erro): ?>
                <div class="msg-erro"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $erro; ?></div>
            <?php endif; ?>

            <div class="user-highlight">
                <p>Alterar password de:</p>
                <h3><i class="fa-solid fa-user-shield"></i> <?php echo htmlspecialchars($userAlvo["nome"]); ?></h3>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-key"></i> Nova Password:</label>
                <input type="password" name="password" id="passInput" placeholder="••••••••••••" required>
            </div>

            <div class="password-checklist">
                <p><i class="fa-solid fa-list-check"></i> Requisitos Mínimos:</p>
                <ul>
                    <li id="req-length"><i class="fa-solid fa-circle-xmark"></i> 10+ Caracteres</li>
                    <li id="req-upper"><i class="fa-solid fa-circle-xmark"></i> Letra MAIÚSCULA</li>
                    <li id="req-lower"><i class="fa-solid fa-circle-xmark"></i> Letra minúscula</li>
                    <li id="req-number"><i class="fa-solid fa-circle-xmark"></i> Um número (0-9)</li>
                    <li id="req-special"><i class="fa-solid fa-circle-xmark"></i> Símbolo (!@#$%...)</li>
                </ul>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-lock"></i> Confirmar Password:</label>
                <input type="password" name="confirm_password" placeholder="Repete a password" required>
            </div>

            <div class="form-actions">
                <?php 
                    $voltar = ($roleSessao == 3) ? "painel_do_viewer.php" : "admin.php";
                ?>
                <a href="<?php echo $voltar; ?>" class="btn-voltar-outline"><i class="fa-solid fa-arrow-left"></i> Cancelar</a>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-shield-check"></i> Salvar Password</button>
            </div>
        </form>
    </div>

    <script>
        const passInput = document.getElementById('passInput');
        
        const requirements = {
            length:  { id: 'req-length',  regex: /.{10,}/ },
            upper:   { id: 'req-upper',   regex: /[A-Z]/ },
            lower:   { id: 'req-lower',   regex: /[a-z]/ },
            number:  { id: 'req-number',  regex: /[0-9]/ },
            special: { id: 'req-special', regex: /[^A-Za-z0-9]/ }
        };

        passInput.addEventListener('input', function() {
            const value = passInput.value;

            for (const key in requirements) {
                const item = document.getElementById(requirements[key].id);
                const icon = item.querySelector('i');
                const isValid = requirements[key].regex.test(value);

                if (isValid) {
                    item.classList.add('valid');
                    icon.className = "fa-solid fa-circle-check";
                } else {
                    item.classList.remove('valid');
                    icon.className = "fa-solid fa-circle-xmark";
                }
            }
        });
    </script>

</body>
</html>