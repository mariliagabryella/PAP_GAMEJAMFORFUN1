
<!DOCTYPE html>

<html lang="pt">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres para suportar acentos -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Ajusta a visualização para dispositivos móveis -->
    <title>GameJamForFun</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style1.css"> <!-- Importa o arquivo de estilos CSS -->
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


    <div class="form-container">
        <h1>Inscrição - <p>Game Jam For Fun 25</p>
        </h1>


        <form action="https://formsubmit.co/eventos.gr550@aeaav.pt" method="POST">
            <input type="hidden" name="_captcha" value="false">
            <label for="instituiçao">Instituição Escolar:</label>
            <input type="text" id="instituiçao" name="instituiçao" required>



            <label for="professor">Nome do Professor Responsável:</label>
            <input type="text" id="professor" name="professor" required>

            <label for="email_professor">E-mail do Professor:</label>
            <input type="email" id="email_professor" name="email_professor" required>

            <label for="plataforma">Plataforma de Desenvolvimento:</label>
            <select id="plataforma" name="plataforma" required>
                <option value="">Escolha uma opção...</option>
                <option value="Unity">Unity</option>
                <option value="Unreal Engine">Unreal Engine</option>
                <option value="GameMaker">GameMaker</option>
                <option value="Roblox Studio">Roblox Studio</option>
                <option value="Construct 3D">Construct 3D</option>


            </select>

            <!-- Linguagem de Programação -->
            <label for="linguagem">Linguagem de Programação:</label>
            <select id="linguagem" name="linguagem" onchange="toggleEscreverLinguagem(this)" required>
                <option value="">Escolha uma opção...</option>
                <option value="C#">C#</option>
                <option value="Python">Python</option>
                <option value="Luau">Lua</option>
                <option value="Outra">Outra</option>
            </select>

            <!-- Campo de texto para "Outra" -->
            <div id="outra-linguagem" style="display: none; margin-top: 10px;">
                <label for="linguagem-outra">Escreva a Linguagem:</label>
                <input type="text" id="linguagem-outra" name="linguagem-outra" placeholder="Digite aqui...">
            </div>




            <!-- 🔹 Escolha do número de participantes -->
            <label for="num_participantes">Número de Participantes:</label>
            <select id="num_participantes" name="num_participantes" onchange="mostrarCampos()">
                <option value="1">1 Participante</option>
                <option value="2">2 Participantes</option>
                <option value="3">3 Participantes</option>
            </select>

            <!-- 🔹 Campos dos Participantes (Inicialmente escondidos) -->
            <div id="participante1">
                <label for="participante1">Nome do Participante :</label>
                <input type="text" id="participante1_input" name="participante1">

                <label for="idade1">Idade:</label>
                <input type="number" id="idade1" name="idade1">

                <label for="email_aluno1">E-mail:</label>
                <input type="email" id="email_aluno1" name="email_aluno1">

                <label for="curso1">Curso/Turma:</label>
                <input type="text" id="curso1" name="curso1">
                <h1 class="divider">-------------------</h1>
            </div>
               
            <div id="participante2" style="display: none;">
                <label for="participante2">Nome do Participante :</label>
                <input type="text" id="participante2_input" name="participante2">

                <label for="idade2">Idade:</label>
                <input type="number" id="idade2" name="idade2">

                <label for="email_aluno2">E-mail:</label>
                <input type="email" id="email_aluno2" name="email_aluno2">

                <label for="curso2">Curso/Turma:</label>
                <input type="text" id="curso2" name="curso2">
                <h1 class="divider">-------------------</h1>
            </div>
            
            <div id="participante3" style="display: none;">
                <label for="participante3">Nome do Participante :</label>
                <input type="text" id="participante3_input" name="participante3">

                <label for="idade3">Idade:</label>
                <input type="number" id="idade3" name="idade3">

                <label for="email_aluno3">E-mail:</label>
                <input type="email" id="email_aluno3" name="email_aluno3">

                <label for="curso3">Curso/Turma:</label>
                <input type="text" id="curso3" name="curso3">
                <h1 class="divider">-------------------</h1>
            </div>
            
          
            <label for="observacao">Observações Médicas:</label>
            <textarea id="observacao" name="observacao" rows="4"></textarea>

            <!-- 📨 Botão de envio -->
            <button type="submit">Game On</button>
        </form>


    </div>
    </div>


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