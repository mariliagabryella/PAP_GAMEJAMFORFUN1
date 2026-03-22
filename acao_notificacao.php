<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION["id"];
$acao = $_GET['acao'] ?? '';
$id_notif = $_GET['id'] ?? 0;

if ($id_notif > 0 && in_array($acao, ['ler', 'apagar', 'restaurar', 'destruir'])) {
    
    $conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
    if ($conn->connect_error) {
        die("Erro na conexão: " . $conn->connect_error);
    }

    if ($acao === 'ler') {
        $stmt = $conn->prepare("UPDATE notificacoes SET lida = 1 WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id_notif, $id_user);
        $stmt->execute();
    } 
    elseif ($acao === 'apagar') {
        // Soft delete: Apenas esconde a notificação mandando para o Lixo
        $stmt = $conn->prepare("UPDATE notificacoes SET apagada = 1 WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id_notif, $id_user);
        $stmt->execute();
    }
    elseif ($acao === 'restaurar') {
        // Tira do lixo
        $stmt = $conn->prepare("UPDATE notificacoes SET apagada = 0 WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id_notif, $id_user);
        $stmt->execute();
        header("Location: lixo_notificacoes.php"); // Volta para o lixo
        exit();
    }
    elseif ($acao === 'destruir') {
        // Hard delete: Apaga de vez da base de dados
        $stmt = $conn->prepare("DELETE FROM notificacoes WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id_notif, $id_user);
        $stmt->execute();
        header("Location: lixo_notificacoes.php"); // Volta para o lixo
        exit();
    }
    
    $conn->close();
}

header("Location: notificacoes_admin.php");
exit();
?>