<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION["id"];
$nome_user = $_SESSION["nome"] ?? "Utilizador";
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Conta | Game Jam</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Silkscreen&display=swap');

        body {
            margin: 0;
            padding: 0;
            background-color: #000; /* Fundo Todo Preto */
            color: #fff;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .card-eliminar {
            background: #0a0a0a;
            border: 1px solid #333;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .icon-warning {
            font-size: 50px;
            color: #ef4444;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 10px rgba(239, 68, 68, 0.3));
        }

        h2 {
            font-family: 'Silkscreen', cursive;
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #fff;
        }

        p {
            color: #94a3b8;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .botoes-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn {
            padding: 14px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s;
            border: none;
            font-size: 1rem;
        }

        .btn-confirmar {
            background-color: #ef4444;
            color: white;
        }

        .btn-confirmar:hover {
            background-color: #b91c1c;
            transform: scale(1.02);
        }

        .btn-cancelar {
            background-color: transparent;
            color: #94a3b8;
            border: 1px solid #333;
        }

        .btn-cancelar:hover {
            background-color: #1a1a1a;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="card-eliminar">
        <div class="icon-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        
        <h2>Adeus, <?php echo htmlspecialchars($nome_user); ?>?</h2>
        
        <p>Estás prestes a eliminar a tua conta. Esta ação é permanente e todos os teus dados de inscrição serão removidos do sistema.</p>

        <div class="botoes-container">
            <a href="processar_eliminar_perfil.php" class="btn btn-confirmar">
                <i class="fa-solid fa-user-xmark"></i> Sim, Eliminar Conta
            </a>
            
            <a href="painel_do_viewer.php" class="btn btn-cancelar">
                Cancelar e Voltar
            </a>
        </div>
    </div>

</body>
</html>