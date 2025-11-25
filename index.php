

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para suportar acentos -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ajusta a visualização para dispositivos móveis -->
    <title>GameJamForFun</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css"> <!-- Importa o arquivo de estilos CSS -->
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

    <video class="video-bg" autoplay muted loop>
        <source src="img/Game jaaam.mp4" type="video/mp4">
       
    </video>

    <div class="video-overlay"></div>
    <div class="video-text container">
 
    <div class="stack" style="--stacks: 3; " >
        <span style="--index: 0;">Game Jam For Fun</span>
        <span style="--index: 1;">Game Jam For Fun</span>
        <span style="--index: 2;">Game Jam For Fun</span>
    </div>
    <span class="right">Já imaginaste criar o teu próprio jogo?<p>Queres mostrar o teu talento? Esta é a oportunidade perfeita para ti!!</p></span>

     <!-- Logo abaixo do texto -->
     <div class="logo-container">
        <img src="img/loge.png" alt="Logo do Evento">
    </div>
    <!-- 🔹 Botões abaixo da logo -->
    <div class="button-container">
        <a href="inscrição.php" class="button" id = "text">Inscrição</a>
        <a href="docs/Regulamento.pdf"  class="button"  id = "text" target="_blank">Regulamento</a>
        <a href="docs/Declaração de Consentimento e Aceitação de participacaoGJFF.pdf"  class="button" id = "text" target="_blank">Consentimento</a>
    </div>
</div>
<section id="sobre-nos" class="sobre-nos">
    <div class="container">
        <!-- 🔹 Carrossel de imagens à esquerda -->
        <div class="carrossel">
        <div class="slides">
            <img src="img/img1.jpg" alt="Foto 1">
            <img src="img/img2.jpg" alt="Foto 2">
            <img src="img/img3.jpg" alt="Foto 3">
        </div>

    </div>

    <script>
        let slideIndex = 0;
        const slides = document.querySelectorAll(".slides img");

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove("active");
                if (i === index) slide.classList.add("active");
            });
        }

        function mudarSlide(n) {
            slideIndex = (slideIndex + n + slides.length) % slides.length;
            showSlide(slideIndex);
        }

        setInterval(() => {
            slideIndex = (slideIndex + 1) % slides.length;
            showSlide(slideIndex);
        }, 3000);

        document.addEventListener("DOMContentLoaded", () => {
            showSlide(slideIndex);
        });
    </script>

        <!-- 🔹 Texto sobre a organização à direita -->
        <div class="descricao">
            <h2>Sobre Nós</h2>
            <p> Bem-Vindo á  Game Jam For Fun! Somos uma comunidade de Alunos e 
                Professores que gostamos de criação de jogos, aos alunos damos o incentivo
                 da inovação e a criatividade. O nosso objetivo é proporcionar aos participantes 
                 um experiência inesquecível. </p>
            <p>Nesta 2ª Edição, promovemos mais um desafio e conexões entre os participantes de várias escolas. Esperamos que venham fazer parte desta jornada.</p>
        </div>
    </div>
</section>

<section id="localizacao" class="localizacao">
    <div class="container">
        <!-- 🔹 Texto à esquerda -->
        <div class="descrica">
            <h2>Onde Estamos</h2>
                    <p>Estamos localizados no Agrupamento de Escolas de Albergaria-a-Velha (AEAAV), Portugal,
                     onde é ministrado o curso Técnico de Gestão e Programação de Sistemas Informáticos (TGPSI)
                      com foco em programação e desenvolvimento digital.</p>
                    <p> Os alunos e professores do mesmo criaram este projeto "Game Jam For Fun" que é uma iniciativa
                     para promover a criação de jogos e a inovação tecnológica.  🎮</p>
         
        <a href="https://aeaav.pt" class="botao-visitar" target="_blank">Visitar</a>
        </div>
        <!-- 🔹 Mapa à direita com fundo vermelho -->
        <div class="mapa-container">
            <div class="mapa">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3025.4025973113253!2d-8.481936024834638!3d40.68713013913908!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd23757f50ae35e5%3A0xe53f1e9c0e6a9c4f!2sES%20de%20Albergaria-a-Velha!5e0!3m2!1spt-PT!2spt!4v1745095730800!5m2!1spt-PT!2spt" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

<!-- 🏆 Seção das fases da Game Jam For Fun -->
<div class="gamejam-section">
    <h1 class="gamejam-title"> Todas as Etapas🎮 - 2025 </h1>

    <div class="container-boxes">
        <div class="box">
            <h3>Inscrição</h3>
            <p>Inscrições entre dias 28 de abril a 14 de maio de 2025.</p>
            <p>Primeira fase: Apurar 16 equipas.</p>
        </div>

        <div class="box">
            <h3>1º dia</h3>
            
            <p>18:30 - Receção das equipas;</p>
            <p>19:30 - Abertura com intervenção dos Júris e patrocinadores;</p>
            <p>Divulgação do tema da Game Jam For Fun;</p>
            <p>Início da Criação dos 
                jogos com o Tema proposto.</p>
        </div>

        <div class="box">
            <h3>2º dia</h3>
            
            <p>Continuação da criação dos jogos com tema proposto.
            Durante os períodos da manhã e da tarde, a tensão arterial 
            dos participantes será monitorizada pelos alunos do curso de Técnico Auxiliar de Saúde</p>
            
        </div>

        <div class="box">
            <h3>3º dia</h3>
            
            <p>Entrega dos jogos desenvolvidos pelas equipas participantes;</p>
            <p>Receção aos júris e professores;</p>
            <p>Apresentações e avaliação dos jogos;</p>
            <p>Divulgação das equipas vencedoras, com atribuição dos 1.º, 2.º e 3.º lugares.</p>
        </div>
    </div>
</div>
<section id="patrocinadores" class="patrocinadores">
    <div class="container">
        <h1>Patrocinadores</h1>
        <div class="logos">
            <a href="https://www.facebook.com/pampas.pamplina/" target="_blank">
                <img src="img/p1.png" alt="Patrocinador 1">
            </a>
            <a href="https://reage.pt/" target="_blank">
                <img src="img/p2.svg" alt="Patrocinador 2">
            </a>
           <a href="https://jadegroupe.pt/" target="_blank">
    <img src="img/p3.png" alt="Patrocinador 3" class="logo-patrocinador">
</a>
            <a href="https://www.facebook.com/fornalha.albergaria/" target="_blank">
                <img src="img/p4.png" alt="Patrocinador 4">
            </a>

            <a href="https://www.facebook.com/resendeseixaspublicidade/" target="_blank">
                <img src="img/p5.png" alt="Patrocinador 5">
            </a>

             <a href="https://www.facebook.com/Papaduxo/?locale=pt_BR" target="_blank">
                <img src="img/p6.png" alt="Patrocinador 6">
            </a>

            
             <a href="https://www.loja-online.intermarche.pt/" target="_blank">
                <img src="img/p7.png" alt="Patrocinador 7">
            </a>

            
             <a href="https://www.facebook.com/people/Albamercado-suplda/100063969456853/" target="_blank">
                <img src="img/p9.png" alt="Patrocinador 9">
            </a>

            
             <a href="https://www.cm-albergaria.pt/" target="_blank">
                <img src="img/p10.png" alt="Patrocinador 10">
            </a>

               <a href="https://deltacafes.com/" target="_blank">
                <img src="img/p11.png" alt="Patrocinador 11">
            </a>
        </div>

        <!-- 🔹 Texto de agradecimento -->
        <p class="agradecimento">Agradecemos pelo patrocínio e participação no evento!</p>
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
                <li><a href="inscrição.php">Inscrição</a></li>
                <li><a href="contact.php">Contactos</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Criar Conta</a></li>
            </ul>
        </div>
        
        <!-- Contatos -->
        <div class="footer-contacts">
            <h4>Contactos</h4>
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