<?php
session_start();
include 'conteudo_index.php';
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameJamForFun</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <?php include 'menu.php'; ?>

    <div class="conteudo"></div>

    <div class="social-icons">
        <?php include 'script.php'; ?>
    </div>

    <!-- ============================
         VÍDEO DE FUNDO DINÂMICO
    ============================= -->
    <video class="video-bg" autoplay muted loop>
        <source src="<?php echo index_conteudo('video_url'); ?>" type="video/mp4">
    </video>

    <div class="video-overlay"></div>

    <!-- ============================
         HERO / TÍTULO PRINCIPAL
    ============================= -->
    <div class="video-text container">

        <div class="stack" style="--stacks: 3;">
            <span style="--index: 0;"><?php echo index_conteudo('titulo'); ?></span>
            <span style="--index: 1;"><?php echo index_conteudo('titulo'); ?></span>
            <span style="--index: 2;"><?php echo index_conteudo('titulo'); ?></span>
        </div>

        <span class="right">
            <?php echo index_conteudo('subtitulo'); ?>
            <p><?php echo index_conteudo('descricao'); ?></p>
        </span>

        <div class="logo-container">
            <img src="<?php echo index_conteudo('logo'); ?>" alt="Logo do Evento">
        </div>

        <div class="button-container">
            <a href="inscrição.php" class="button" id="text">Inscrição</a>
            <a href="docs/Regulamento.pdf" class="button" id="text" target="_blank">Regulamento</a>
            <a href="docs/Declaração de Consentimento e Aceitação de participacaoGJFF.pdf" class="button" id="text" target="_blank">Consentimento</a>
        </div>
    </div>

    <!-- ============================
         SOBRE NÓS (DINÂMICO)
    ============================= -->
    <section id="sobre-nos" class="sobre-nos">
        <div class="container">

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

                setInterval(() => {
                    slideIndex = (slideIndex + 1) % slides.length;
                    showSlide(slideIndex);
                }, 3000);

                document.addEventListener("DOMContentLoaded", () => {
                    showSlide(slideIndex);
                });
            </script>

            <div class="descricao">
                <h2><?php echo index_conteudo('sobre_titulo'); ?></h2>
                <p><?php echo index_conteudo('sobre_texto1'); ?></p>
                <p><?php echo index_conteudo('sobre_texto2'); ?></p>
            </div>

        </div>
    </section>

    <!-- ============================
         LOCALIZAÇÃO (DINÂMICO)
    ============================= -->
    <section id="localizacao" class="localizacao">
        <div class="container">

            <div class="descrica">
                <h2><?php echo index_conteudo('local_titulo'); ?></h2>
                <p><?php echo index_conteudo('local_texto1'); ?></p>
                <p><?php echo index_conteudo('local_texto2'); ?></p>

                <a href="https://aeaav.pt" class="botao-visitar" target="_blank">Visitar</a>
            </div>

            <div class="mapa-container">
                <div class="mapa">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3025.4025973113253!2d-8.481936024834638!3d40.68713013913908!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd23757f50ae35e5%3A0xe53f1e9c0e6a9c4f!2sES%20de%20Albergaria-a-Velha!5e0!3m2!1spt-PT!2spt!4v1745095730800!5m2!1spt-PT!2spt"
                        width="100%" height="300" style="border:0;" allowfullscreen loading="lazy"></iframe>
                </div>
            </div>

        </div>
    </section>

    <!-- ============================
         ETAPAS (DINÂMICO)
    ============================= -->
    <div class="gamejam-section">
        <h1 class="gamejam-title"><?php echo index_conteudo('etapas_titulo'); ?></h1>

        <div class="container-boxes">

            <div class="box">
                <h3>Inscrição</h3>
                <p>Inscrições entre 28 de abril e 14 de maio de 2025.</p>
                <p>Primeira fase: Apurar 16 equipas.</p>
            </div>

            <div class="box">
                <h3>1º dia</h3>
                <p>18:30 - Receção das equipas;</p>
                <p>19:30 - Abertura com intervenção dos Júris e patrocinadores;</p>
                <p>Divulgação do tema da Game Jam For Fun;</p>
                <p>Início da criação dos jogos com o tema proposto.</p>
            </div>

            <div class="box">
                <h3>2º dia</h3>
                <p>Continuação da criação dos jogos com o tema proposto.</p>
                <p>Monitorização da tensão arterial pelos alunos do curso Técnico Auxiliar de Saúde.</p>
            </div>

            <div class="box">
                <h3>3º dia</h3>
                <p>Entrega dos jogos;</p>
                <p>Receção aos júris e professores;</p>
                <p>Apresentações e avaliação dos jogos;</p>
                <p>Divulgação das equipas vencedoras.</p>
            </div>

        </div>
    </div>

    <!-- ============================
         PATROCINADORES (DINÂMICO)
    ============================= -->
    <section id="patrocinadores" class="patrocinadores">
        <div class="container">
            <h1><?php echo index_conteudo('patrocinadores_titulo'); ?></h1>

            <div class="logos">
                <a href="https://www.facebook.com/pampas.pamplina/" target="_blank"><img src="img/p1.png"></a>
                <a href="https://reage.pt/" target="_blank"><img src="img/p2.svg"></a>
                <a href="https://jadegroupe.pt/" target="_blank"><img src="img/p3.png"></a>
                <a href="https://www.facebook.com/fornalha.albergaria/" target="_blank"><img src="img/p4.png"></a>
                <a href="https://www.facebook.com/resendeseixaspublicidade/" target="_blank"><img src="img/p5.png"></a>
                <a href="https://www.facebook.com/Papaduxo/?locale=pt_BR" target="_blank"><img src="img/p6.png"></a>
                <a href="https://www.loja-online.intermarche.pt/" target="_blank"><img src="img/p7.png"></a>
                <a href="https://www.facebook.com/people/Albamercado-suplda/100063969456853/" target="_blank"><img src="img/p9.png"></a>
                <a href="https://www.cm-albergaria.pt/" target="_blank"><img src="img/p10.png"></a>
                <a href="https://deltacafes.com/" target="_blank"><img src="img/p11.png"></a>
            </div>

            <p class="agradecimento"><?php echo index_conteudo('patrocinadores_agradecimento'); ?></p>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>

</body>

</html>
