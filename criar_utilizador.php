<?php
session_start();
include 'bd_connection.php'; 

/* Apenas adminmaster (role_id = 1) pode criar utilizadores */
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

// DADOS DO UTILIZADOR PARA O MENU LATERAL
$user_id = $_SESSION["id"] ?? 0; 
$nome = $_SESSION["nome"] ?? "Admin Master";
$fotoLogado = "img/default.png";

if ($user_id > 0) {
    $stmtUser = $pdo->query("SELECT foto FROM utilizadores WHERE id = $user_id");
    $userDados = $stmtUser->fetch(PDO::FETCH_ASSOC);
    if ($userDados && !empty($userDados['foto'])) {
        $fotoLogado = $userDados['foto'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Criar Utilizador | Painel Premium</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <div class="painel-menu">
        <div class="painel-user">
            <img src="<?php echo htmlspecialchars($fotoLogado); ?>" class="painel-foto" alt="Foto">
            <span class="painel-ola">Olá, <span class="destaque-nome"><?php echo htmlspecialchars($nome); ?></span></span>
        </div>

     

        <div class="painel-links" id="painelLinks">
            <a href="index.php"><i class="fa-solid fa-house"></i> Site</a>
            <a href="editar_perfil.php"><i class="fa-solid fa-user-pen"></i> Perfil</a>
            <a href="admin.php" class="active"><i class="fa-solid fa-gauge"></i> Painel</a>
            <a href="logout.php" class="btn-sair"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
        </div>
    </div>

    <div class="admin-content">
        <div class="cabecalho-dashboard">
            <h1 class="titulo-painel">Registar <span class="glow-text">Novo Utilizador</span></h1>
        </div>

        <form action="processar_criar_utilizador.php" method="POST" enctype="multipart/form-data" class="form-card">
            
<div class="form-group foto-upload-container">
    <label><i class="fa-solid fa-image"></i> Foto de Perfil (Opcional):</label>
    
    <div class="foto-preview-wrapper" onclick="document.getElementById('fotoInput').click()">
        <img id="fotoPreview" src="img/default.png" alt="Preview da Foto">
        
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
                <label><i class="fa-solid fa-id-card-clip"></i> Tipo de Utilizador:</label>
                <select name="role_id" class="form-select" required>
                    <option value="" disabled selected>-- Selecione o Cargo --</option>
                    <option value="2">Admin</option>
                    <option value="3">Utilizador</option>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-user"></i> Nome Completo:</label>
                <input type="text" name="nome" placeholder="Ex: Ana Silva" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-envelope"></i> Email:</label>
                <input type="email" name="email" placeholder="email@exemplo.com" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-lock"></i> Senha de Acesso:</label>
                <input type="password" name="senha" placeholder="••••••••" required>
            </div>

            <div class="form-actions">
                <a href="admin.php" class="btn-voltar-outline"><i class="fa-solid fa-arrow-left"></i> Cancelar / Voltar</a>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-user-plus"></i> Criar Conta</button>
            </div>
            
        </form>
    </div>

    <script>
        function togglePainelMenu() {
            document.getElementById("painelLinks").classList.toggle("active");
        }
    </script>
</body>
</html>