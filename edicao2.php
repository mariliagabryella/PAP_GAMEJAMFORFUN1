<?php 
require 'textos.php';
require 'bd_connection.php';
?>

<?php 
session_start();

$slug =[
    'Titulo_Edicao2',
    'Subtitulo_Edicao2',
    'Data_Edicao2',
    'Tema_Edicao2',
    'Descricao_tema_edicao2',
    'Participantes_Edicao2',
    'Descricao_participantes_edicao2',
    'Descricao1_participantes_edicao2',
    'Local_Edicao2',
    'Descricao_local_Edicao2',
    'Subtitulo_Sobre_Edicao2',
    'Descricao_Sobre_Edicao2',
    'Descricao1_Sobre_Edicao2',
    'Vencedores_Edicao2',
    'Vencedor1_Edicao2',
    'Vencedor2_Edicao2',
    'Vencedor3_Edicao2',
    'Descricao2_Sobre_Edicao2',
    'Subtitulo_Cronograma_Edicao2',
    'Dia1_Cronograma_Edicao2',
    'Descricao_Dia1_Edicao2',
    'Descricao1_Dia1_Edicao2',
    'Descricao2_Dia1_Edicao2',
    'Descricao3_Dia1_Edicao2',
    'Dia2_Cronograma_Edicao2',
    'Descricao_Dia2_Edicao2',
    'Descricao1_Dia2_Edicao2',
    'Descricao2_Dia2_Edicao2',
    'Descricao3_Dia2_Edicao2',
    'Dia3_Cronograma_Edicao2',
    'Descricao_Dia3_Edicao2',
    'Descricao1_Dia3_Edicao2',
    'Descricao2_Dia3_Edicao2',
    'Descricao3_Dia3_Edicao2',
    'Descricao4_Dia3_Edicao2',
    'Descricao5_Dia3_Edicao2',
    'Descricao6_Dia3_Edicao2',
    'Descricao7_Dia3_Edicao2',
    'Subtitulo_Patrocinadores_Edicao2',
    'Descricao_Patrocinadores_Edicao2'
    ];

$textos = getTextos($pdo, $slug);

if (!is_array($textos)) {
    $textos = [];
}
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameJamForFun - 2ª Edição</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style3.css">
    <link rel="stylesheet" href="css/style-edicao2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include 'menu.php'; ?>

    <div class="conteudo"></div>

    <section id="edicao2" class="edicao">
        <div class="background"></div>
        <div class="container">
            <h1 class="titulo-principal">
                <?php echo $textos['Titulo_Edicao2'] ?? ''; ?>
                <span class="edicao-numero"><?php echo $textos['Subtitulo_Edicao2'] ?? ''; ?></span>
            </h1>
            
            <div class="data-evento">
                <div class="calendario-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <p><?php echo $textos['Data_Edicao2'] ?? ''; ?></p>
            </div>
            
            <div class="info-cards">
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <h3><?php echo $textos['Tema_Edicao2'] ?? ''; ?></h3>
                    <p><?php echo $textos['Descricao_tema_edicao2'] ?? ''; ?></p>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3><?php echo $textos['Participantes_Edicao2'] ?? ''; ?></h3>
                    <p><?php echo $textos['Descricao_participantes_edicao2'] ?? ''; ?></p>
                    <p><?php echo $textos['Descricao1_participantes_edicao2'] ?? ''; ?></p>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3><?php echo $textos['Local_Edicao2'] ?? ''; ?></h3>
                    <p><?php echo $textos['Descricao_local_Edicao2'] ?? ''; ?></p>
                </div>
            </div>
            
            <div class="descricao-evento">
                <h2><?php echo $textos['Subtitulo_Sobre_Edicao2'] ?? ''; ?></h2>

                <p>
                        <?php echo $textos['Descricao_Sobre_Edicao2'] ?? ''; ?>
                </p>

                <p>
                    <?php echo $textos['Descricao1_Sobre_Edicao2'] ?? ''; ?>
                </p>
                
                <p>
                 <?php echo $textos['Vencedores_Edicao2'] ?? ''; ?></p>

                <p><?php echo $textos['Vencedor1_Edicao2'] ?? ''; ?></p>

                <p><?php echo $textos['Vencedor2_Edicao2'] ?? ''; ?></p>

                <p><?php echo $textos['Vencedor3_Edicao2'] ?? ''; ?></p>
                </p>

                <p>
                        <?php echo $textos['Descricao2_Sobre_Edicao2'] ?? ''; ?>
                </p>

            </div>
            
            <div class="cronograma">
                <h2><?php echo $textos['Subtitulo_Cronograma_Edicao2'] ?? ''; ?></h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date"><?php echo $textos['Dia1_Cronograma_Edicao2'] ?? ''; ?></div>
                        <div class="timeline-content">
                            <h4><?php echo $textos['Descricao_Dia1_Edicao2'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao1_Dia1_Edicao2'] ?? ''; ?></p>
                            <h4><?php echo $textos['Descricao2_Dia1_Edicao2'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao3_Dia1_Edicao2'] ?? ''; ?></p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date"><?php echo $textos['Dia2_Cronograma_Edicao2'] ?? ''; ?></div>
                        <div class="timeline-content">
                            <h4><?php echo $textos['Descricao_Dia2_Edicao2'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao1_Dia2_Edicao2'] ?? ''; ?></p>

                            <h4><?php echo $textos['Descricao2_Dia2_Edicao2'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao3_Dia2_Edicao2'] ?? ''; ?></p>
                                </p>

                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date"><?php echo $textos['Dia3_Cronograma_Edicao2'] ?? ''; ?></div>
                        <div class="timeline-content">
                            <h4><?php echo $textos['Descricao_Dia3_Edicao2'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao1_Dia3_Edicao2'] ?? ''; ?></p>

                            <h4><?php echo $textos['Descricao2_Dia3_Edicao2'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao3_Dia3_Edicao2'] ?? ''; ?></p>

                            <h4><?php echo $textos['Descricao4_Dia3_Edicao2'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao5_Dia3_Edicao2'] ?? ''; ?></p>

                            <h4><?php echo $textos['Descricao6_Dia3_Edicao2'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao7_Dia3_Edicao2'] ?? ''; ?></p>
                        </div>
                    </div>
                </div>
            </div>

             <div class="carrossel-container">
        <div class="slides">
            <img src="img/6125.jpg" alt="Foto do Evento 1">
            <img src="img/5971.jpg" alt="Foto do Evento 2">
            <img src="img/5983.jpg" alt="Foto do Evento 3">
            <img src="img/5995.jpg" alt="Foto do Evento 4">
            <img src="img/6006.jpg" alt="Foto do Evento 5">
            <img src="img/6033.jpg" alt="Foto do Evento 6">
            <img src="img/6039.jpg" alt="Foto do Evento 7">
            <img src="img/6109.jpg" alt="Foto do Evento 8">
            <img src="img/6114.jpg" alt="Foto do Evento 9">
            <img src="img/6117.jpg" alt="Foto do Evento 10">
        </div>
        <button class="prev" onclick="mudarSlide(-1)">❮</button>
        <button class="next" onclick="mudarSlide(1)">❯</button>
    </div>
</section>
            
           <section id="patrocinadores" class="patrocinadores">
    <div class="container">
        <h1><?php echo $textos['Subtitulo_Patrocinadores_Edicao2'] ?? ''; ?></h1>
        <div class="logos">
             <a href="https://www.facebook.com/pampas.pamplina/" target="_blank">
                <img src="img/p1.png" alt="Patrocinador 1">
            </a>
            <a href="https://reage.pt/" target="_blank">
                <img src="img/p2.svg" alt="Patrocinador 2">
            </a>
            <a href="https://jadegroupe.pt/" target="_blank">
                <img src="img/p3.png" alt="Patrocinador 3">
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
        <p class="agradecimento"><?php echo $textos['Descricao_Patrocinadores_Edicao2'] ?? ''; ?></p>
    </div>
</section>
    

    <div class="social-icons">
        <?php include 'script.php'; ?>
    </div>

   <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>
