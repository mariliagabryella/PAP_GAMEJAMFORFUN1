<?php
/* ============================================================
   INICIAR SESSÃO
   ============================================================ */
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha']);

    if ($email && $senha) {

        /* ------------------------------------------------------------
           BUSCAR UTILIZADOR PELO EMAIL
        ------------------------------------------------------------ */
        $stmt = $conn->prepare("
            SELECT id, nome, role_id, senha_hash 
            FROM utilizadores 
            WHERE email = ?
        ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        /* ------------------------------------------------------------
           VERIFICA SE O UTILIZADOR EXISTE
        ------------------------------------------------------------ */
        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            /* ------------------------------------------------------------
               VERIFICA SENHA
            ------------------------------------------------------------ */
            if (password_verify($senha, $user['senha_hash'])) {

                /* ------------------------------------------------------------
                   GUARDA DADOS NA SESSÃO
                ------------------------------------------------------------ */
                $_SESSION["usuarioEmail"]   = $email;
                $_SESSION["usuarioNome"]    = $user['nome'];
                $_SESSION["role_id"]        = $user['role_id'];
                $_SESSION["id"]  = $user['id'];

                /* ------------------------------------------------------------
                   ATUALIZA O CAMPO "ativo" COM O HORÁRIO DO ÚLTIMO LOGIN
                ------------------------------------------------------------ */
                $update = $conn->prepare("UPDATE utilizadores SET ativo = NOW() WHERE email = ?");
                $update->bind_param("s", $email);
                $update->execute();

                /* ------------------------------------------------------------
                   REDIRECIONAMENTO POR TIPO DE UTILIZADOR
                ------------------------------------------------------------ */
                if ($user['role_id'] == 1) {
                    header("Location: admin.php"); // Admin Master
                    exit();
                }

                if ($user['role_id'] == 2) {
                    header("Location: admin.php"); // Admin
                    exit();
                }

                if ($user['role_id'] == 3) {
                    header("Location: viewer_painel.php"); // Viewer
                    exit();
                }

            } else {
                $erroLogin = "Senha incorreta.";
            }

        } else {
            $erroLogin = "Usuário não encontrado.";
        }

        $stmt->close();

    } else {
        $erroLogin = "Preencha todos os campos corretamente.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameJamForFun - Login</title>

    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/loginstyle.css">
</head>

<body>

    <?php include 'menu.php'; ?> 

    <div class="conteudo"></div>

    <div class="social-icons">
        <?php include 'script.php'; ?>
    </div>

    <canvas id="interactive-bg"></canvas>
    <div class="video-overlay"></div>

    <div class="login-wrapper">
        <form action="login.php" method="POST">
            <h2>Login</h2>

            <?php if (!empty($erroLogin)): ?>
                <p style="color: #ff8080; margin-bottom: 10px;">
                    <?php echo $erroLogin; ?>
                </p>
            <?php endif; ?>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>
        </form>
    </div>

    <script src="interactive-script.js"></script>

</body>
</html>
