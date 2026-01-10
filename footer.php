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


    <footer class="footer">
        <div class="footer-container">
            <div class="footer-menu">
                <h4>Menu</h4>
                <ul>
                    <li><a href="/PAP_GAMEJAMFORFUN1/index.php">Início</a></li>
                    <li><a href="/PAP_GAMEJAMFORFUN1/inscrição.php">Inscrição</a></li>
                    <li><a href="/PAP_GAMEJAMFORFUN1/contact.php">Contactos</a></li> 
                    <?php if (isset($_SESSION["usuarioEmail"])): ?> <li>
                        <a href="/PAP_GAMEJAMFORFUN1/logout.php">Logout</a></li> 
                        <?php else: ?> <li><a href="/PAP_GAMEJAMFORFUN1/login.php">Login</a></li> 
                            <?php endif; ?>
                </ul>
            </div>
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

</html>