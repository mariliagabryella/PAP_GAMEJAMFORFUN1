<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");

$userId = $_SESSION["id"];
$stmt = $conn->prepare("SELECT nome, foto, role_id FROM utilizadores WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

$nome = $admin["nome"];
$foto = $admin["foto"] ?: "img/default.png";
$role = (int)$admin["role_id"];

/* Apenas Admin Master e Admin Normal */
if (!in_array($role, [1,2])) {
    die("Acesso negado.");
}

/* ============================================================
   PROCESSAR RESPOSTA DO ADMIN
============================================================ */
if (isset($_POST["resposta"])) {

    $resposta = $_POST["resposta"];
    $contactoId = $_POST["contacto_id"];

    /* Buscar email e user_id do viewer */
    $stmt = $conn->prepare("SELECT email, user_id FROM contactos WHERE id = ?");
    $stmt->bind_param("i", $contactoId);
    $stmt->execute();
    $dados = $stmt->get_result()->fetch_assoc();

    $emailViewer = $dados["email"];
    $id_viewer = $dados["user_id"];

    /* Guardar resposta */
    $stmt = $conn->prepare("
        UPDATE contactos 
        SET resposta=?, data_resposta=NOW(), user_id_respondeu=? 
        WHERE id=?
    ");
    $stmt->bind_param("sii", $resposta, $userId, $contactoId);
    $stmt->execute();

    /* Enviar email ao viewer */
    // PHPMailer aqui (o teu código)

    /* Criar notificação interna para o viewer */
    $stmt = $conn->prepare("
        INSERT INTO notificacoes (user_id, mensagem, lida, data)
        VALUES (?, ?, 0, NOW())
    ");

    $mensagemNotif = "Recebeste uma resposta ao teu pedido de contacto.";
    $stmt->bind_param("is", $id_viewer, $mensagemNotif);
    $stmt->execute();

    header("Location: admin_contacto.php?respondido=1");
    exit();
}

/* ============================================================
   BUSCAR CONTACTOS
============================================================ */
$contactos = $conn->query("SELECT * FROM contactos ORDER BY data_envio DESC");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Contactos Recebidos</title>
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<?php include 'menu_admin.php'; ?>

<div class="conteudo-admin">
    <h2>Contactos Recebidos</h2>

    <?php if (isset($_GET["responder"])): 
        $idResponder = (int)$_GET["responder"];
        $dados = $conn->query("SELECT * FROM contactos WHERE id=$idResponder")->fetch_assoc();
    ?>

    <!-- FORMULÁRIO DE RESPOSTA -->
    <div class="perfil-card" style="margin-bottom:20px;">
        <h3>Responder a <?php echo htmlspecialchars($dados["nome"]); ?></h3>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($dados["email"]); ?></p>
        <p><strong>Mensagem:</strong><br><?php echo nl2br(htmlspecialchars($dados["mensagem"])); ?></p>

        <form method="POST">
            <textarea name="resposta" required placeholder="Escreva a resposta..." rows="5"></textarea>
            <input type="hidden" name="contacto_id" value="<?php echo $idResponder; ?>">
            <button type="submit" class="btn-guardar">Enviar Resposta</button>
        </form>
    </div>

    <?php endif; ?>

    <!-- LISTA DE CONTACTOS -->
    <div class="tabela-container">
        <table class="tabela-users">
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Mensagem</th>
                <th>Data</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>

            <?php while ($c = $contactos->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($c["nome"]); ?></td>
                <td><?php echo htmlspecialchars($c["email"]); ?></td>
                <td><?php echo nl2br(htmlspecialchars(substr($c["mensagem"], 0, 40))); ?>...</td>
                <td><?php echo date("d/m/Y H:i", strtotime($c["data_envio"])); ?></td>

                <td>
                    <?php if ($c["resposta"]): ?>
                        <span class="badge badge-verde">Respondido</span>
                    <?php else: ?>
                        <span class="badge badge-vermelho">Pendente</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="admin_contacto.php?responder=<?php echo $c['id']; ?>" class="acao editar">
                        <i class="fa-solid fa-reply"></i>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>

        </table>
    </div>
</div>

</body>
</html>
