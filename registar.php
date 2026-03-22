<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameJamForFun - Registar Conta</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>

    <?php include 'menu.php'; ?>

    <canvas id="interactive-bg"></canvas>
    <div class="video-overlay"></div>

    <div class="login-page-wrapper">
        <div class="split-layout">
            
            <div class="image-panel">
                <div class="image-content">
                    <div class="logo-area">
                        <h3><i class="fa-solid fa-gamepad"></i> GameJamForFun</h3> 
                    </div>
                    <div class="left-text">
                        <h2>JUNTA-TE À<br><span>COMUNIDADE!</span></h2>
                    </div>
                </div>
            </div>

            <div class="form-panel">
                <h1>CRIAR CONTA</h1>
                <p class="subtitle">Preenche os teus dados para começares a tua jornada</p>

                <form action="processar_registo.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="avatar-upload">
                        <div class="avatar-preview">
                            <img id="imagePreview" src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Pré-visualização da Foto">
                        </div>
                        <div class="avatar-edit">
                            <input type="file" id="foto" name="foto" accept=".png, .jpg, .jpeg">
                            <label for="foto"><i class="fa-solid fa-camera"></i> Escolher Foto</label>
                        </div>
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="nome" name="nome" placeholder="O teu nome completo" required>
                    </div>

                    <div class="input-group">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="O teu e-mail" required>
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="senha" name="senha" placeholder="Cria uma palavra-passe" required>
                    </div>

                    <div class="password-checklist">
                        <p class="checklist-title"><i class="fa-solid fa-list-check"></i> Requisitos Mínimos:</p>
                        <ul class="password-requirements">
                            <li id="req-length" class="invalid"><i class="fa-solid fa-circle-xmark"></i> 10+ Caracteres</li>
                            <li id="req-upper" class="invalid"><i class="fa-solid fa-circle-xmark"></i> Letra MAIÚSCULA</li>
                            <li id="req-lower" class="invalid"><i class="fa-solid fa-circle-xmark"></i> Letra minúscula</li>
                            <li id="req-number" class="invalid"><i class="fa-solid fa-circle-xmark"></i> Um número (0-9)</li>
                            <li id="req-special" class="invalid"><i class="fa-solid fa-circle-xmark"></i> Símbolo (!@#$%...)</li>
                        </ul>
                    </div>

                    <button type="submit" class="primary-btn" id="btnRegisto" disabled>CRIAR CONTA <i class="fa-solid fa-user-plus"></i></button>
                </form>

                <p class="terms">
                    Já tens conta? <a href="login.php">Iniciar sessão</a>.
                </p>
            </div>

        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // 1. Script para mostrar a pré-visualização da foto redonda
        const fotoInput = document.getElementById('foto');
        const imagePreview = document.getElementById('imagePreview');

        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evento) {
                    imagePreview.src = evento.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        // 2. Script para validar os 5 requisitos da Password em tempo real
        const passInput = document.getElementById('senha');
        const btnRegisto = document.getElementById('btnRegisto');
        
        const requirements = {
            length:  { id: 'req-length',  regex: /.{10,}/ },
            upper:   { id: 'req-upper',   regex: /[A-Z]/ },
            lower:   { id: 'req-lower',   regex: /[a-z]/ },
            number:  { id: 'req-number',  regex: /[0-9]/ },
            special: { id: 'req-special', regex: /[^A-Za-z0-9]/ }
        };

        passInput.addEventListener('input', function() {
            const value = passInput.value;
            let formValido = true;

            for (const key in requirements) {
                const item = document.getElementById(requirements[key].id);
                const icon = item.querySelector('i');
                const isValid = requirements[key].regex.test(value);

                if (isValid) {
                    item.classList.add('valid');
                    item.classList.remove('invalid');
                    icon.className = "fa-solid fa-circle-check";
                } else {
                    item.classList.remove('valid');
                    item.classList.add('invalid');
                    icon.className = "fa-solid fa-circle-xmark";
                    formValido = false; // Se um falhar, o form não é válido
                }
            }

            // Ativa ou desativa o botão de submeter
            btnRegisto.disabled = !formValido;
        });
    </script>

    <script src="script.js"></script>
    <script src="interactive-script.js"></script>

</body>
</html>