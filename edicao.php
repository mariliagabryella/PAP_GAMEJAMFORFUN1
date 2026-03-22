<?php
session_start();
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 1;
include 'conteudo_edicao.php'; // Função edicao($id, 'campo')
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo edicao($id, 'titulo_pagina'); ?></title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style-edicao2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include 'menu.php'; ?>
<div class="pacman-bg">
    <div class="pacman"></div>
    <div class="fantasma"></div>
</div>
    <div class="conteudo"></div>

    <section id="edicao2" class="edicao">
        <div class="background"></div>
        <div class="container">

            <h1 class="titulo-principal">
                <?php echo edicao($id, 'titulo_evento'); ?>
                <span class="edicao-numero"><?php echo edicao($id, 'edicao_numero'); ?></span>
            </h1>

            <div class="data-evento">
                <div class="calendario-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <p><?php echo edicao($id, 'data_evento'); ?></p>
            </div>

            <div class="info-cards">

                <div class="info-card">
                    <div class="card-icon"><i class="fas fa-gamepad"></i></div>
                    <h3>Tema</h3>
                    <p><?php echo edicao($id, 'tema'); ?></p>
                </div>

                <div class="info-card">
                    <div class="card-icon"><i class="fas fa-users"></i></div>
                    <h3>Participantes</h3>
                    <p><?php echo edicao($id, 'participantes1'); ?></p>
                    <p><?php echo edicao($id, 'participantes2'); ?></p>
                </div>

                <div class="info-card">
                    <div class="card-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h3>Local</h3>
                    <p><?php echo edicao($id, 'local'); ?></p>
                </div>

            </div>

            <div class="descricao-evento">
                <h2>Sobre</h2>
                <?php echo edicao($id, 'descricao'); ?>
            </div>

            <div class="cronograma">
                <h2>Cronograma</h2>
                <?php echo edicao($id, 'cronograma'); ?>
            </div>

            <div class="carrossel-container">
                <div class="slides">
                    <?php echo edicao($id, 'carrossel'); ?>
                </div>
                <button class="prev" onclick="mudarSlide(-1)">❮</button>
                <button class="next" onclick="mudarSlide(1)">❯</button>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let slideIndex = 0;
                    // Procura todas as imagens que o PHP imprimiu dentro da div .slides
                    const slides = document.querySelectorAll(".slides img");

                    if (slides.length > 0) {
                        // Ativa a primeira imagem para ela ficar visível imediatamente!
                        slides[0].classList.add("active");

                        // Função para mudar a imagem ao clicar nas setas
                        window.mudarSlide = function(n) {
                            slides[slideIndex].classList.remove("active");
                            slideIndex += n;
                            
                            // Faz o carrossel dar a volta (loop)
                            if (slideIndex >= slides.length) slideIndex = 0;
                            if (slideIndex < 0) slideIndex = slides.length - 1;
                            
                            slides[slideIndex].classList.add("active");
                        };

                        // BÓNUS: Faz o carrossel passar sozinho a cada 4 segundos
                        setInterval(function() {
                            mudarSlide(1);
                        }, 4000);
                    }
                });
            </script>

        </div>
    </section>

    <section id="patrocinadores" class="patrocinadores">
        <div class="container">

            <h1><?php echo edicao($id, 'patrocinadores_titulo'); ?></h1>

            <div class="logos">
                <?php echo edicao($id, 'patrocinadores'); ?>
            </div>

            <p class="agradecimento">
                <?php echo edicao($id, 'patrocinadores_agradecimento'); ?>
            </p>

        </div>
    </section>

    <div class="social-icons">
        <?php include 'script.php'; ?>
    </div>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>

</body>
</html>