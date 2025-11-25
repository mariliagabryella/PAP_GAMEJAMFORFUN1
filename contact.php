

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

        <form action="https://formsubmit.co/eventos.gr550@aeaav.pt" method="POST" class="contact-form">
            <!-- Campo de Nome -->
            <div class="form-group">
                <input type="text" name="name" placeholder="Nome" required>
                <hr class="form-line">
            </div>

            <!-- Campo de Email -->
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
                <hr class="form-line">
            </div>

            <!-- Campo de Mensagem -->
            <div class="form-group">
                <textarea name="message" placeholder="Mensagem" rows="5" required></textarea>
                <hr class="form-line">
            </div>

            <!-- Botão de envio -->
            <button type="submit" class="submit-btn">Enviar</button>
        </form>
    </div>

  

      <!-- Carrossel de fotos e mensagem -->
      <div class="carousel-container">
            <div class="carousel">
                <img src="img/fotogrupo.jpg" alt="Foto da Equipe 1">
                <img src="img/fotogrupo1.jpg" alt="Foto da Equipe 2">
            </div>
            <div class="team-info">
                <h3>Equipe: 🍪REO</h3>
                <p>"Um projeto feito com muito carinho e dedicação para poder entregar com a melhor qualidade para os nossos participantes!"</p>
            </div>
        </div>
    </div>  

</section>
    
    <footer class="footer">
    <div class="footer-container">
        <!-- Menu em coluna -->
        <div class="footer-menu">
            <h4>Menu</h4>
            <ul>
            <li><a href="index.php">Início</a></li>
                    <li><a href="index.php">SobreNós</a></li>
                    <li><a href="edicao1(1).php">Edição 1</a></li>
                    <li><a href="edicao2(1).php">Edição 2</a></li>
                    <li><a href="inscrição.php">Inscrição</a></li>
                    <li><a href="contact.php">Contactos</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Criar Conta</a></li>
            </ul>
        </div>
        
        <!-- Contatos -->
        <div class="footer-contacts">
            <h4>Contatos</h4>
            <ul>
                <li>Email do Evento: <a href="mailto:eventos.gr550@aeaav.pt">eventos.gr550@aeaav.pt</a></li>
                <li>Escola: Escola Secundária de Albergaria-A-Velha</li>
                <li>Site da Escola: <a href="https://aeaav.pt/" target="_blank">https://aeaav.pt/</a></li>
            </ul>
        </div>
    </div>
    <p class="footer-credit">© 2025 Game Jam For Fun. Todos os direitos reservados.</p>
</footer>





















</body>

<script src="script.js"></script>

</html>