<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para suportar acentos -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ajusta a visualização para dispositivos móveis -->
    <title>GameJamForFun</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style2.css"> <!-- Importa o arquivo de estilos CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://kit.fontawesome.com/YOUR-FONT-AWESOME-KIT.js" crossorigin="anonymous"></script> <!-- Importa os ícones -->

</head>

<body>
    <?php include 'menu.php'; ?> <!-- Inclui o menu fixo na página -->


    <div class="conteudo">
    
    </div>



    <section id="edicao1" class="edicao">
    <div class="container">
        <!-- 🔹 Resumo completo da Edição 1 -->
        <h2>Edição 1 - Game Jam For Fun 2024</h2>
        <p>No passado fim de semana (19 a 21 de abril), ocorreu a <strong>Game Jam 2024 - AEAAV</strong>, sob o lema <strong>"Game Jam for Fun"</strong>, nas instalações do <strong>Agrupamento de Escolas de Albergaria-a-Velha</strong>. Durante <strong>48 horas</strong>, <strong>10 equipas</strong>, compostas por <strong>30 alunos</strong>, dedicaram-se ao desafio de <strong>criar, desenhar, programar, desenvolver e prototipar um videojogo</strong> sobre o tema <strong>“As alterações climáticas”</strong>. O evento destacou-se pela colaboração e o espírito de entreajuda entre os participantes e equipas.</p>

        <p>Os participantes trouxeram o essencial para uma jornada intensa, enquanto a organização, liderada pelos docentes de Informática e alunos de TGPSI, foi exemplar, garantindo <strong>infraestrutura tecnológica, logística, alimentação e apoio técnico</strong>. Outros grupos da escola contribuíram de forma harmoniosa e voluntária para o sucesso da iniciativa.</p>

        <p>O evento iniciou-se com a receção na sexta-feira, seguida de palestras, e, posteriormente, foi revelado o tema da competição. As equipas mergulharam no <strong>processo criativo</strong>, explorando design, narrativa e programação, e trabalharam arduamente até domingo à tarde, quando submeteram os seus jogos numa plataforma específica. Às <strong>16h</strong>, os produtos finais foram apresentados, com a presença de <strong>familiares, amigos e um júri independente</strong>.</p>

        <p><strong>Três equipas foram destacadas:</strong></p>
        <ul>
            <li><strong>1º RDK (Clim'Pocalipse)</strong> – Agrupamento de Escolas de Estarreja</li>
            <li><strong>2º NoName (Be the hero)</strong> - Agrupamento de Escolas de Albergaria-a-Velha</li>
            <li><strong>3º The Fingers (Finger Temperature)</strong> - Agrupamento de Escolas de Albergaria-a-Velha</li>
        </ul>

        <p>A organização agradeceu a todos os que contribuíram para a realização do evento, incluindo os <strong>patrocinadores</strong>, pelo apoio essencial. Foi uma experiência enriquecedora e um verdadeiro sucesso!</p>
    </div>

    <!-- 🔹 Carrossel de fotos -->
    <div class="carrossel-container">
        <div class="slides">
            <img src="img/20240419_150940.jpg" alt="Foto do Evento 1">
            <img src="img/20240419_182414.jpg" alt="Foto do Evento 2">
            <img src="img/20240419_220524 (1).jpg" alt="Foto do Evento 3">
            <img src="img/20240421_131030.jpg" alt="Foto do Evento 4">
            <img src="img/20240421_174956.jpg" alt="Foto do Evento 5">
            <img src="img/20240421_165339.jpg" alt="Foto do Evento 6">
            <img src="img/20240421_165912.jpg" alt="Foto do Evento 7">
            <img src="img/20240421_131000.jpg" alt="Foto do Evento 8">
        </div>
        <button class="prev" onclick="mudarSlide(-1)">❮</button>
        <button class="next" onclick="mudarSlide(1)">❯</button>
    </div>
</section>

    <!-- Container onde os ícones sociais serão exibidos -->
    <div class="social-icons">
        <?php include 'script.php'; ?> <!-- Inclui o script PHP que gera os ícones dinamicamente -->
    </div>

  





    <footer class="footer">
    <div class="footer-container">
        <!-- Menu em coluna -->
        <div class="footer-menu">
            <h4>Menu</h4>
            <ul>
            <li><a href="index.php">Início</a></li>
                    <li><a href="index.php">SobreNós</a></li>
                    <li><a href="edicao1.php">Edição 1</a></li>
                    <li><a href="edicao2.php">Edição 2</a></li>
                    <li><a href="inscrição.php">Inscrição</a></li>
                    <li><a href="contact.php">Contatos</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Registrar</a></li>
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