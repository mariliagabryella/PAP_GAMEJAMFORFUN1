<?php
session_start();

/* ============================================================
   CONEXÃO COM A BASE DE DADOS
   ============================================================ */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* ============================================================
   PROCESSAMENTO DO LOGIN
   ============================================================ */
$erroLogin = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha']);

    if ($email && $senha) {
        $stmt = $conn->prepare("
            SELECT id, nome, role_id, senha_hash, ativo, verificado
            FROM utilizadores 
            WHERE email = ?
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($senha, $user['senha_hash'])) {
                $_SESSION["email"]   = $email;
                $_SESSION["nome"]    = $user['nome'];
                $_SESSION["role_id"] = $user['role_id'];
                $_SESSION["id"]      = $user['id'];

                if ($user["verificado"] == 0) {
                    header("Location: verificar_pin.php?email=$email");
                    exit();
                }

                $update = $conn->prepare("UPDATE utilizadores SET ativo = NOW() WHERE email = ?");
                $update->bind_param("s", $email);
                $update->execute();

                if ($user['role_id'] == 1 || $user['role_id'] == 2) {
                    header("Location: admin.php");
                } else {
                    header("Location: painel_do_viewer.php");
                }
                exit();
            } else {
                $erroLogin = "Palavra-passe incorreta. Tenta novamente.";
            }
        } else {
            $erroLogin = "E-mail não encontrado.";
        }
        $stmt->close();
    } else {
        $erroLogin = "Preenche todos os campos corretamente.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameJamForFun - Iniciar Sessão</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>

    <?php include 'menu.php'; ?>

    <canvas id="interactive-bg"></canvas>
    <div class="video-overlay"></div>

    <div class="login-page-wrapper">
        <div class="split-layout">
            
            <div class="image-panel">
                <div class="image-content">
                    <div class="logo-area">
                        <h3><i class="fa-solid fa-gamepad"></i> GameJamForFun</h3> 
                    </div>
                    <div class="left-text">
                        <h2>BEM-VINDO À TUA<br><span>AVENTURA!</span></h2>
                    </div>
                </div>
            </div>

            <div class="form-panel">
                <h1>INICIAR SESSÃO</h1>
                <p class="subtitle">Insere as tuas credenciais para continuar</p>

                <?php if (!empty($erroLogin)): ?>
                    <div class="erro-mensagem">
                        <i class="fa-solid fa-circle-exclamation"></i> <?php echo $erroLogin; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="input-group">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" placeholder="O teu e-mail" required>
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="senha" placeholder="A tua palavra-passe" required>
                    </div>

                    <button type="submit" class="primary-btn">Entrar <i class="fa-solid fa-arrow-right-to-bracket"></i></button>
                </form>

                <p class="terms">
                    Ainda não tens conta? <a href="registar.php">Regista-te aqui</a>.
                </p>
            </div>

        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
    <script src="interactive-script.js"></script>

</body>
</html>