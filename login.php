<?php
session_start(); // Inicia a sessão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura os dados do formulário
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha']); // Apenas captura a senha digitada
    
    if ($email && $senha) { // Verifica se email e senha foram preenchidos
        // Armazena o email na sessão para identificar o usuário logado
        $_SESSION["usuarioEmail"] = $email;

        // Redireciona para a página inicial
        header("Location: index.php");
        exit();
    } else {
        echo "Por favor, preencha todos os campos corretamente.";
    }

}

?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameJamForFun</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/YOUR-FONT-AWESOME-KIT.js" crossorigin="anonymous"></script> <!-- Importa os ícones -->


    <!-- 🔹 Importando estilos -->
    <link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>
    <?php include 'menu.php'; ?> <!-- Inclui o menu fixo na página -->


    <div class="conteudo">

    </div>

    <!-- Container onde os ícones sociais serão exibidos -->
    <div class="social-icons">
        <?php include 'script.php'; ?> <!-- Inclui o script PHP que gera os ícones dinamicamente -->
    </div>
       
   <!-- 🔹 Canvas para o background interativo -->
   <canvas id="interactive-bg"></canvas>


    <!-- 🔹 Overlay escuro sobre o vídeo -->
    <div class="video-overlay"></div>

    <!-- 🔹 Formulário centralizado -->
    <div class="login-wrapper">
        <form action="login.php" method="POST">
            <h2>Login</h2>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Entrar</button>

            <p>Não tem conta? <a href="register.php">Criar Conta</a></p>
        </form>
    </div>
    <script src="js/interactive-script.js"></script> <!-- Script JS -->
    
    
</body>
</html>