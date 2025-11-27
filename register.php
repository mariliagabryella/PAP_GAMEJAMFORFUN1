<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // 🔐 Criptografando a senha antes de salvar
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (email, senha) VALUES ('$email', '$senhaHash')";

    if (mysqli_query($conn, $sql)) {
        echo "Conta criada com sucesso!";
    } else {
        echo "Erro ao criar conta: " . mysqli_error($conn); // 🔹 Mostra erro SQL se houver
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
    <link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>
   <!-- 🔹 Canvas para o background interativo -->
   <canvas id="interactive-bg"></canvas>

    <!-- 🔹 Botão fora do formulário -->
  
    <!-- 🔹 Vídeo de fundo -->
    <video autoplay muted loop class="video-bg">
        <source src="img/game Jam anuncio 1.mov" type="video/mp4">
    </video>

    <!-- 🔹 Overlay escuro sobre o vídeo -->
    <div class="video-overlay"></div>

    <!-- 🔹 Formulário centralizado -->
    <div class="login-wrapper">
        <form action="register.php" method="POST">
            <h2>Criar Conta</h2>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <button type="submit">Criar Conta</button>

            <p>Já tem conta? <a href="login.php">Iniciar Sessão</a></p>
        </form>
    </div>
    <script src="interactive-script.js"></script> <!-- Script JS -->
</body>
</html>