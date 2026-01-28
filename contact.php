
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para suportar acentos -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ajusta a visualização para dispositivos móveis -->
    <title>GameJamForFun</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style4.css"> <!-- Importa o arquivo de estilos CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/YOUR-FONT-AWESOME-KIT.js" crossorigin="anonymous"></script> <!-- Importa os ícones -->

</head>

<body>
    <?php include 'menu.php'; ?> <!-- Inclui o menu fixo na página -->


    <div class="conteudo">

    </div>

    <!-- Container onde os ícones sociais serão exibidos -->
    <div class="social-icons">
        <?php include 'script.php'; ?> <!-- Inclui o script PHP que gera os ícones dinamicamente -->
    </div>
       

  <section class="contact-form-section">
    <div class="contact-form-container">
        <h1>Entre em Contacto</h1>
        <p>Envie-nos uma mensagem e responderemos o mais breve possível!</p>

        <form action="processar_contacto.php" method="POST" class="contact-form">
            <div class="form-group">
                <input type="text" name="nome" placeholder="Nome" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="form-group">
                <textarea name="mensagem" placeholder="Mensagem" rows="5" required></textarea>
            </div>

            <button type="submit" class="submit-btn">Enviar</button>
        </form>

        <!-- Ícones sociais dentro da secção -->
        <div class="contact-social">
            <a href="https://facebook.com" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://discord.com" target="_blank"><i class="fa-brands fa-discord"></i></a>
            <a href="mailto:gamejamforfunteste@gmail.com"><i class="fa-solid fa-envelope"></i></a>
        </div>
    </div>
</section>

    
    <?php include 'footer.php'; ?>
</body>

<script src="script.js"></script>

</html>