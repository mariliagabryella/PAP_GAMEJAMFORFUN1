<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Tem de estar logado */
if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$emailSessao = $_SESSION["email"];

/* Conexão BD */
$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$stmt = $conn->prepare("SELECT id, nome, email, foto, role_id FROM utilizadores WHERE email = ?");
$stmt->bind_param("s", $emailSessao);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
$conn->close();

$nome = $user["nome"];
$email = $user["email"];
$foto = $user["foto"] ?: "img/default.png";
$role = $user["role_id"];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <div class="painel-menu">
        <div class="painel-user">
            <img src="<?php echo htmlspecialchars($foto); ?>" class="painel-foto" alt="Foto">
            <span class="painel-ola">
                Olá, <span class="destaque-nome"><?php echo htmlspecialchars($nome); ?></span>
        
                
            </span>
        </div>


        <div class="painel-links" id="painelLinks">
            <a href="index.php"><i class="fa-solid fa-house"></i>Site</a>
            <a href="editar_perfil.php" class="active"><i class="fa-solid fa-user-pen"></i>Perfil</a>

            <?php if ($role == 1): ?>
                <a href="admin.php"><i class="active"></i> Painel</a>
       

            <?php elseif ($role == 2): ?>
                <a href="admin.php"><i class="active"></i> Painel</a>
         <a href="eliminar_perfil.php" class="danger"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>

            <?php else: ?>
                <a href="painel_do_viewer.php"><i class="active"></i> Painel</a>
         <a href="eliminar_perfil.php" class="danger"><i class="fa-solid fa-user-xmark"></i> Eliminar Conta</a>
            <?php endif; ?>

            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <script>
    function togglePainelMenu() {
        const menu = document.getElementById("painelLinks");
        const icon = document.getElementById("painel-icon");
        menu.classList.toggle("show");
        icon.textContent = menu.classList.contains("show") ? "✖" : "☰";
    }
    </script>

    <div class="admin-content">
        <div class="cabecalho-dashboard">
            <h1 class="titulo-painel">Editar <span class="glow-text">Perfil</span></h1>
        </div>

        <form action="processar_editar_perfil.php" method="POST" enctype="multipart/form-data" class="form-card">
            
            <div class="form-group foto-upload-container">
                <label><i class="fa-solid fa-image"></i> Foto de Perfil:</label>
                
                <div class="foto-preview-wrapper" onclick="document.getElementById('fotoInput').click()">
                    <img id="fotoPreview" src="<?php echo htmlspecialchars($foto); ?>" alt="Preview da Foto">
                    
                    <div class="foto-overlay">
                        <i class="fa-solid fa-camera"></i>
                        <span>Alterar</span>
                    </div>
                </div>
                
                <input type="file" name="foto" id="fotoInput" accept="image/*" style="display: none;" onchange="previewImagem(event)">
            </div>

            <script>
                function previewImagem(event) {
                    const input = event.target;
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('fotoPreview').src = e.target.result;
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>

            <div class="form-group">
                <label><i class="fa-solid fa-user"></i> Nome Completo:</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" placeholder="Ex: Ana Silva" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-envelope"></i> Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="email@exemplo.com" required>
            </div>

            <div class="form-actions">
                <a href="index.php" class="btn-voltar-outline"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-floppy-disk"></i> Guardar Alterações</button>
            </div>
            
        </form>
    </div>


</body>
</html>