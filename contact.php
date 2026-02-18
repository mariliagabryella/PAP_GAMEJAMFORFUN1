<?php
include 'bd_connection.php';

$stmt = $pdo->query("SELECT * FROM contactos_pagina WHERE id = 1");
$info = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($info['titulo']) ?></title>

    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="css/style4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <?php include 'menu.php'; ?>

    <section class="contact-form-section">
        <div class="contact-form-container">

            <h1><?= htmlspecialchars($info['titulo']) ?></h1>
            <p><?= nl2br(htmlspecialchars($info['subtitulo'])) ?></p>

            <form action="processar_contacto.php" method="POST" class="contact-form">
                <div class="form-group">
                    <input type="text" name="nome" placeholder="Nome" required>
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <textarea name="mensagem" placeholder="Mensagem" rows="5" required></textarea>
                </div>

                <button type="submit" class="submit-btn">Enviar</button>
            </form>

            <div class="contact-social">

                <?php if (!empty($info['facebook'])): ?>
                    <a href="<?= htmlspecialchars($info['facebook']) ?>" target="_blank">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($info['instagram'])): ?>
                    <a href="<?= htmlspecialchars($info['instagram']) ?>" target="_blank">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($info['discord'])): ?>
                    <a href="<?= htmlspecialchars($info['discord']) ?>" target="_blank">
                        <i class="fa-brands fa-discord"></i>
                    </a>
                <?php endif; ?>

                <?php if (!empty($info['email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($info['email']) ?>">
                        <i class="fa-solid fa-envelope"></i>
                    </a>
                <?php endif; ?>

            </div>

        </div>
    </section>

    <?php include 'footer.php'; ?>
</body>

</html>
