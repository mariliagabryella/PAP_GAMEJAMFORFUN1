<?php 
require 'textos.php';
require 'bd_connection.php';
?>

<?php 
session_start();

$slug =[
    'titulo_do_index',
    'subtitulo_do_index',
    'subtitulo_do_index1',
    'sobrenos_titulo',
    'texto_sobrenos',
    'texto_sobrenos1',
    'titulo_ondeestamos',
    'texto_ondeestamos',
    'texto_ondeestamos1',
    'titudo_etapas',
    'subtitulo_etapas',
    'texto_etapas_inscrições',
    'texto_etapas_inscrições1',
    'subtitulo_etapas_dia_um',
    'texto_etapas_dia_um',
    'texto_etapas_dia_um1',
    'texto_etapas_dia_um2',
    'texto_etapas_dia_um3',
    'subtitulo_etapas_dia_dois',
    'texto_etapas_dia_dois',
    'texto_etapas_dia_dois1',
    'subtitulo_etapas_dia_tres',
    'texto_etapas_dia_tres',
    'texto_etapas_dia_tres1',
    'texto_etapas_dia_tres2',
    'texto_etapas_dia_tres3',
    'patrocinio_titulo',
    'agradecimentos_texto'
];

$textos = getTextos($pdo, $slug);

if (!is_array($textos)) {
    $textos = [];
}
?>

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
   
    <?php include 'menu.php'; ?>
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
 
    <div class="stack" >
        <span><?php echo $textos['titulo_do_index'] ?? ''; ?></span>
    </div>
    <span class="right"><?php echo $textos['subtitulo_do_index'] ?? ''; ?></p></span>

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
            <button class="prev" onclick="mudarSlide(-1)">❮</button>
            <button class="next" onclick="mudarSlide(1)">❯</button>
        </div>

        <!-- 🔹 Texto sobre a organização à direita -->
        <div class="descricao">
            <h2><?php echo $textos['sobrenos_titulo'] ?? ''; ?></h2>
            <p><?php echo $textos['texto_sobrenos'] ?? ''; ?></p>
            
        </div>
    </div>
</section>

<section id="localizacao" class="localizacao">
    <div class="container">
        <!-- 🔹 Texto à esquerda -->
        <div class="descrica">
            <h2><?php echo $textos['titulo_ondeestamos'] ?? ''; ?></h2>
                    <p><?php echo $textos['texto_ondeestamos'] ?? ''; ?></p>
         
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
    <h1 class="gamejam-title"> <?php echo $textos['titudo_etapas'] ?? ''; ?> </h1>

    <div class="container-boxes">
        <div class="box">
            <h3><?php echo $textos['subtitulo_etapas'] ?? ''; ?></h3>
            <p><?php echo $textos['texto_etapas_inscrições'] ?? ''; ?></p>
            <p><?php echo $textos['texto_etapas_inscrições1'] ?? ''; ?></p>
        </div>

        <div class="box">
            <h3><?php echo $textos['subtitulo_etapas_dia_um'] ?? ''; ?></h3>
            
            <p><?php echo $textos['texto_etapas_dia_um'] ?? ''; ?></p>
            <p><?php echo $textos['texto_etapas_dia_um1'] ?? ''; ?></p>
            <p><?php echo $textos['texto_etapas_dia_um2'] ?? ''; ?></p>
            <p><?php echo $textos['texto_etapas_dia_um3'] ?? ''; ?></p>
        </div>

        <div class="box">
            <h3><?php echo $textos['subtitulo_etapas_dia_dois'] ?? ''; ?></h3>
            
            <p><?php echo $textos['texto_etapas_dia_dois'] ?? ''; ?></p>
            <p><?php echo $textos['texto_etapas_dia_dois1'] ?? ''; ?></p>
        </div>

        <div class="box">
            <h3><?php echo $textos['subtitulo_etapas_dia_tres'] ?? ''; ?></h3>
            
            <p><?php echo $textos['texto_etapas_dia_tres'] ?? ''; ?></p>
            <p><?php echo $textos['texto_etapas_dia_tres1'] ?? ''; ?></p>
            <p><?php echo $textos['texto_etapas_dia_tres2'] ?? ''; ?></p>
            <p><?php echo $textos['texto_etapas_dia_tres3'] ?? ''; ?></p>
        </div>
    </div>
</div>
<section id="patrocinadores" class="patrocinadores">
    <div class="container">
        <h1><?php echo $textos['patrocinios_titulo'] ?? ''; ?></h1>
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
        <p class="agradecimento"><?php echo $textos['agradecimento_texto'] ?? ''; ?></p>
    </div>
</section>
 <?php include 'footer.php'; ?>
</body>
<script src="script.js"></script>

</html>