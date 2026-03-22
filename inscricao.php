<?php
session_start();

// Se o utilizador não estiver logado, redireciona para o login
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

include 'bd_connection.php';

// Buscar conteúdo da página
$stmt = $pdo->query("SELECT * FROM inscricao_pagina WHERE id = 1");
$info = $stmt->fetch(PDO::FETCH_ASSOC);

// Buscar plataformas
$plataformas = $pdo->query("SELECT * FROM inscricao_plataformas ORDER BY nome ASC")->fetchAll();

// Buscar linguagens
$linguagens = $pdo->query("SELECT * FROM inscricao_linguagens ORDER BY nome ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($info['titulo']) ?></title>

    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include 'menu.php'; ?>

    <div class="conteudo"></div>

    <div class="social-icons">
        <?php include 'script.php'; ?>
    </div>

    <div class="form-container">

        <!-- TÍTULO E SUBTÍTULO DINÂMICOS -->
        <h1>
            <?= htmlspecialchars($info['titulo']) ?>
            <p><?= htmlspecialchars($info['subtitulo']) ?></p>
        </h1>

        <form action="processar_inscricao.php" method="POST">
            <input type="hidden" name="_captcha" value="false">

            <label for="instituicao">Instituição Escolar:</label>
            <input type="text" id="instituicao" name="instituicao" required>

            <label for="professor">Nome do Professor Responsável:</label>
            <input type="text" id="professor" name="professor" required>

            <label for="email_professor">E-mail do Professor:</label>
            <input type="email" id="email_professor" name="email_professor" required>

            <!-- PLATAFORMAS DINÂMICAS -->
            <label for="plataforma">Plataforma de Desenvolvimento:</label>
            <select id="plataforma" name="plataforma" required>
                <option value="">Escolha uma opção...</option>
                <?php foreach ($plataformas as $p): ?>
                    <option value="<?= htmlspecialchars($p['nome']) ?>">
                        <?= htmlspecialchars($p['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- LINGUAGENS DINÂMICAS -->
            <label for="linguagem">Linguagem de Programação:</label>
            <select id="linguagem" name="linguagem" onchange="toggleEscreverLinguagem(this)" required>
                <option value="">Escolha uma opção...</option>
                <?php foreach ($linguagens as $l): ?>
                    <option value="<?= htmlspecialchars($l['nome']) ?>">
                        <?= htmlspecialchars($l['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Campo de texto para "Outra" -->
            <div id="outra-linguagem" style="display: none; margin-top: 10px;">
                <label for="linguagem-outra">Escreva a Linguagem:</label>
                <input type="text" id="linguagem-outra" name="linguagem-outra" placeholder="Digite aqui...">
            </div>

            <!-- Número de participantes -->
            <label for="num_participantes">Número de Participantes:</label>
            <select id="num_participantes" name="num_participantes" onchange="mostrarCampos()">
                <option value="1">1 Participante</option>
                <option value="2">2 Participantes</option>
                <option value="3">3 Participantes</option>
            </select>

            <!-- PARTICIPANTES -->
            <?php for ($i = 1; $i <= 3; $i++): ?>
                <div id="participante<?= $i ?>" style="<?= $i === 1 ? '' : 'display:none;' ?>">
                    <label>Nome do Participante <?= $i ?>:</label>
                    <input type="text" name="participante<?= $i ?>">

                    <label>Idade:</label>
                    <input type="number" name="idade<?= $i ?>">

                    <label>E-mail:</label>
                    <input type="email" name="email_aluno<?= $i ?>">

                    <label>Curso/Turma:</label>
                    <input type="text" name="curso<?= $i ?>">

                    <h1 class="divider">. . . . . . . . . . . . .</h1>
                </div>
            <?php endfor; ?>

            <label for="observacao">Observações Médicas:</label>
            <textarea id="observacao" name="observacao" rows="4"></textarea>

            <button type="submit">Game On</button>

        </form>
    </div>

    <script>
        function toggleEscreverLinguagem(select) {
            document.getElementById("outra-linguagem").style.display =
                select.value === "Outra" ? "block" : "none";
        }

        function mostrarCampos() {
            const total = document.getElementById("num_participantes").value;
            for (let i = 1; i <= 3; i++) {
                document.getElementById("participante" + i).style.display =
                    i <= total ? "block" : "none";
            }
        }
    </script>

<?php include 'footer.php'; ?>
</body>
</html>
