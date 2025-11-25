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
                Game Jam For Fun
                <span class="edicao-numero">2ª Edição</span>
            </h1>
            
            <div class="data-evento">
                <div class="calendario-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <p>23, 24 e 25 de Maio 2025</p>
            </div>
            
            <div class="info-cards">
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <h3>Tema</h3>
                    <p>O tema escolhido deste ano foi "Desliga-te"!!</p>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Participantes</h3>
                    <p>Tivemos 14 equipas!!</p>
                    <p>Tivemos equipas da nossa escola e de outra escolas de Estarreja e da José Estevão.</p>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Local</h3>
                    <p>Escola Secundária de Albergaria-a-Velha</p>
                </div>
            </div>
            
            <div class="descricao-evento">
                <h2>Sobre a 2ª Edição</h2>

                <p>
                    Entre os dias 23 e 25 de maio, decorreu a segunda edição da Game Jam for Fun, organizada pelo 
                     os alunos do curso Técnico de Gestão e Programação de Sistemas
                     Informáticos (TGPSI). O evento reuniu 14 equipas de várias escolas do distrito, desafiadas a criar 
                     um jogo original em apenas 48 horas.
                </p>

                <p>
                    A sessão de abertura contou com a presença de várias personalidades ligadas à educação e à tecnologia.
                     Destaque para o engenheiro Manu, que deu uma palestra inspiradora sobre como começar uma carreira em 
                     desenvolvimento de jogos.
                </p>

                <p>
                    O tema revelado para esta edição foi “DESLIGA-TE”, incentivando à reflexão sobre o uso excessivo da 
                    tecnologia e redes sociais. As equipas demonstraram criatividade, foco e espírito de equipa durante todo o evento.
                </p>

                <p>
                   No domingo, os jogos foram avaliados por um painel de jurados de excelência, com representantes do ensino superior, 
                   empresas e organizações ligadas à informática e educação.
                </p>
                
                <p>
                 🏆 Vencedores:</p>

                <p>🥇 1.º lugar: Os Guri – Escola Secundária de Albergaria-a-Velha</p>

                <p>🥈 2.º lugar: Os Bacanos – Escola Secundária de Estarreja</p>

                <p>🥉 3.º lugar: Equipa da Escola Secundária José Estêvão</p>
                </p>

                <p>
                    O evento terminou com um lanche-convívio, num clima de celebração e agradecimento. Mais do que jogos, 
                    os participantes criaram memórias, laços e experiências marcantes.
                </p>

            </div>
            
            <div class="cronograma">
                <h2>Cronograma</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">Dia 23</div>
                        <div class="timeline-content">
                            <h4>18:30 - Abertura</h4>
                            <p>Receção das equipas</p>
                            <h4>19:30 - Início da Game Jam</h4>
                            <p>Apresentação do evento e anúncio do tema</p>
                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">Dia 24</div>
                        <div class="timeline-content">
                            <h4>- All Day - desenvolvimento dos jogos</h4>
                            <p>Criação dos jogos</p>

                            <h4>- All Day - Monitoramento da tensão arterial</h4>
                            <p> Durante os períodos da manhã e da tarde, a tensão arterial dos 
                                participantes será monitorizada pelos alunos do curso de Técnico 
                                Auxiliar de Saúde</p>

                        </div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">Dia 25</div>
                        <div class="timeline-content">
                            <h4>12:00 - Entrega</h4>
                            <p>Prazo final para submissão dos jogos</p>

                            <h4>14:30 - Palestra</h4>
                            <p>Palestra sobre desenvolvimento de jogos</p>

                            <h4>15:00 - Apresentações</h4>
                            <p>Apresentação dos jogos desenvolvidos</p>

                            <h4>18:00 - Divulgação dos vencedoras</h4>
                            <p>Premiação das equipas vencedoras</p>
                        </div>
                    </div>
                </div>
            </div>

             <div class="carrossel-container">
        <div class="slides">
            <img src="img/" alt="Foto do Evento 1">
            <img src="img/" alt="Foto do Evento 2">
            <img src="img/" alt="Foto do Evento 3">
            <img src="img/" alt="Foto do Evento 4">
            <img src="img/" alt="Foto do Evento 5">
            <img src="img/" alt="Foto do Evento 6">
            <img src="img/" alt="Foto do Evento 7">
            <img src="img/" alt="Foto do Evento 8">
        </div>
        <button class="prev" onclick="mudarSlide(-1)">❮</button>
        <button class="next" onclick="mudarSlide(1)">❯</button>
    </div>
</section>
            
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
        <p class="agradecimento">Agradecemos pelo patrocínio e participação no evento!</p>
    </div>
</section>
    

    <div class="social-icons">
        <?php include 'script.php'; ?>
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-menu">
                <h4>Menu</h4>
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="index.php">SobreNós</a></li>
                    <li><a href="edicao1.php">Edição 1</a></li>
                    <li><a href="edicao2(1).php">Edição 2</a></li>
                    <li><a href="inscrição.php">Inscrição</a></li>
                    <li><a href="contact.php">Contactos</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Criar Conta</a></li>
                </ul>
            </div>
            
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

    <script src="script.js"></script>
</body>
</html>
