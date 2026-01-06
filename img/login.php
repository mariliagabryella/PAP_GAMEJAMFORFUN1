<?php
// Arquivo duplicado de login removido. Redireciona para a página inicial.
header('Location: /index.php');
exit();

?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameJamForFun</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">

    <!-- 🔹 Importando estilos -->
    <link rel="stylesheet" href="loginstyle.css">
</head>
<body>
   <!-- 🔹 Canvas para o background interativo -->
   <canvas id="interactive-bg"></canvas>

    <!-- 🔹 Botão fora do formulário -->
    

    <video autoplay muted loop class="video-bg">
        <source src="img/game Jam anuncio 1.mov" type="video/mp4">
    </video>

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
    <script src="interactive-script.js"></script> <!-- Script JS -->
    
</body>
</html>