<?php 
require 'textos.php';
require 'bd_connection.php';
?>

<?php 
session_start();

$slug =[
    'Titulo-Edicao1',
    'Subtitulo-Edicao1',
    'Data-Edicao1',
    'Tema-Edicao1',
    'Descricao_tema_edicao1',
    'Participantes-Edicao1',
    'Descricao_participantes_edicao1',
    'Descricao1_participantes_edicao1',
    'Local-Edicao1',
    'Descricao_local',
    'Subtitulo_Sobre_Edicao1',
    'Descricao_Sobre_Edicao1',
    'Descricao1_Sobre_Edicao1',
    'Vencedores_Edicao1',
    'Vencedor1_Edicao1',
    'Vencedor2_Edicao1',
    'Vencedor3_Edicao1',
    'Descricao2_Sobre_Edicao1',
    'Subtitulo_Cronograma_Edicao1',
    'Dia1_Cronograma_Edicao1',
    'Descricao_Dia1_Edicao1',
    'Descricao1_Dia1_Edicao1',
    'Descricao2_Dia1_Edicao1',
    'Descricao3_Dia1_Edicao1',
    'Dia2_Cronograma_Edicao1',
    'Descricao_Dia2_Edicao1',
    'Descricao1_Dia2_Edicao1',
    'Descricao2_Dia2_Edicao1',
    'Descricao3_Dia2_Edicao1',
    'Dia3_Cronograma_Edicao1',
    'Descricao_Dia3_Edicao1',
    'Descricao1_Dia3_Edicao1',
    'Descricao2_Dia3_Edicao1',
    'Descricao3_Dia3_Edicao1',
    'Descricao4_Dia3_Edicao1',
    'Descricao5_Dia3_Edicao1',
    'Subtitulo_Patrocinadores_Edicao1',
    'Descricao_Patrocinadores_Edicao1'
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
    <title>GameJamForFun - 1ª Edição</title>
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
                <?php echo $textos['Titulo-Edicao1'] ?? ''; ?>
                <span class="edicao-numero"><?php echo $textos['Subtitulo-Edicao1'] ?? ''; ?></span>
            </h1>
            
            <div class="data-evento">
                <div class="calendario-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <p><?php echo $textos['Data-Edicao1'] ?? ''; ?></p>
            </div>
            
            <div class="info-cards">
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <h3><?php echo $textos['Tema-Edicao1'] ?? ''; ?></h3>
                    <p><?php echo $textos['Descricao_tema_edicao1'] ?? ''; ?></p>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3><?php echo $textos['Participantes-Edicao1'] ?? ''; ?></h3>
                    <p><?php echo $textos['Descricao_participantes_edicao1'] ?? ''; ?></p>
                    <p><?php echo $textos['Descricao1_participantes_edicao1'] ?? ''; ?></p>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3><?php echo $textos['Local-Edicao1'] ?? ''; ?></h3>
                    <p><?php echo $textos['Descricao_local'] ?? ''; ?></p>
                </div>
            </div>
            
            <div class="descricao-evento">
              <h2><?php echo $textos['Subtitulo_Sobre_Edicao1'] ?? ''; ?></h2>

                <p>
                     <?php echo $textos['Descricao_Sobre_Edicao1'] ?? ''; ?>
                </p>

                <p>
                    <?php echo $textos['Descricao1_Sobre_Edicao1'] ?? ''; ?>
                </p>
                
                <p>
                 <?php echo $textos['Vencedores_Edicao1'] ?? ''; ?></p>

                <p><?php echo $textos['Vencedor1_Edicao1'] ?? ''; ?></p>

                <p><?php echo $textos['Vencedor2_Edicao1'] ?? ''; ?></p>

                <p><?php echo $textos['Vencedor3_Edicao1'] ?? ''; ?></p>
                </p>

                <p>
                    <?php echo $textos['Descricao2_Sobre_Edicao1'] ?? ''; ?>

                </p>

            </div>
            
            <div class="cronograma">
                <h2><?php echo $textos['Cronograma_Edicao1'] ?? ''; ?></h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date"><?php echo $textos['Dia1_Cronograma_Edicao1'] ?? ''; ?></div>
                        <div class="timeline-content">
                            <h4><?php echo $textos['Descricao_Dia1_Edicao1'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao1_Dia1_Edicao1'] ?? ''; ?></p>
                            <h4><?php echo $textos['Descricao2_Dia1_Edicao1'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao3_Dia1_Edicao1'] ?? ''; ?></p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date"><?php echo $textos['Dia2_Cronograma_Edicao1'] ?? ''; ?></div>
                        <div class="timeline-content">
                            <h4><?php echo $textos['Descricao_Dia2_Edicao1'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao1_Dia2_Edicao1'] ?? ''; ?></p>

                            <h4><?php echo $textos['Descricao2_Dia2_2_Edicao1'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao3_Dia2_Edicao1'] ?? ''; ?></p>

                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date"><?php echo $textos['Dia3_Cronograma_Edicao1'] ?? ''; ?></div>
                        <div class="timeline-content">
                            <h4><?php echo $textos['Descricao_Dia3_Edicao1'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao1_Dia3_Edicao1'] ?? ''; ?></p>

                            <h4><?php echo $textos['Descricao2_Dia3_Edicao1'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao3_Dia3_Edicao1'] ?? ''; ?></p>
                            <h4><?php echo $textos['Descricao4_Dia3_Edicao1'] ?? ''; ?></h4>
                            <p><?php echo $textos['Descricao5_Dia3_Edicao1'] ?? ''; ?></p>
                        </div>
                    </div>
                </div>
            </div>

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
            
           <section id="patrocinadores" class="patrocinadores">
    <div class="container">
        <h1><?php echo $textos['Subtitulo_Patrocinadores_Edicao1'] ?? ''; ?></h1>
        <div class="logos">
             
            <a href="https://reage.pt/" target="_blank">
                <img src="img/p2.svg" alt="Patrocinador 1">
            </a>
            <a href="https://jadegroupe.pt/" target="_blank">
                <img src="img/p3.png" alt="Patrocinador 2">
            </a>
            
            <a href="https://www.facebook.com/resendeseixaspublicidade/" target="_blank">
                <img src="img/p5.png" alt="Patrocinador 3">
            </a>


             <a href="https://www.loja-online.intermarche.pt/" target="_blank">
                <img src="img/p7.png" alt="Patrocinador 4">
            </a>
            
             <a href="https://www.cm-albergaria.pt/" target="_blank">
                <img src="img/p10.png" alt="Patrocinador 5">
            </a>

               <a href="https://deltacafes.com/" target="_blank">
                <img src="img/p11.png" alt="Patrocinador 6">
            </a>

              <a href="https://www.print4fun3d.com/" target="_blank">
                <img src="img/logo3d.jpg" alt="Patrocinador 7">
            </a>

              <a href="https://mindera.com/gaming" target="_blank">
                <img src="img/mg-logo.jpg" alt="Patrocinador 8">
            </a>
        </div>


        <!-- 🔹 Texto de agradecimento -->
        <p class="agradecimento"><?php echo $textos['Descricao_Patrocinadores_Edicao1'] ?? ''; ?></p>
    </div>
</section>
    

    <div class="social-icons">
        <?php include 'script.php'; ?>
    </div>

    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
</body>
</html>
