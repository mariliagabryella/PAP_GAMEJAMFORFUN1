<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* ============================================================
   VERIFICAR SE JÁ ESTÁ VALIDADO
   Adicionada a coluna 'verificado' à busca
   ============================================================ */
$stmt = $conn->prepare("SELECT id, role_id, ativo, verificado FROM utilizadores WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();
$stmt->close();

/* Se o utilizador já estiver verificado (verificado = 1), não precisa validar e entra direto */
if ($user["verificado"] == 1) {
    if ($user["role_id"] == 3) header("Location: painel_do_viewer.php");
    if ($user["role_id"] == 2) header("Location: admin.php");
    if ($user["role_id"] == 1) header("Location: admin.php");
    exit();
}

/* ============================================================
   PROCESSAR O PIN ENVIADO PELO FORMULÁRIO
   ============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pinInserido = trim($_POST["pin"]);

    $stmt = $conn->prepare("SELECT pin FROM verificacoes_pin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if (!$row) {
        $erro = "Nenhum PIN encontrado. Solicite novo código.";
    } else {
        $pinCorreto = $row["pin"];

        if ($pinInserido === $pinCorreto) {

            /* ============================================================
               SUCESSO! ATUALIZAR A BASE DE DADOS
               Aqui é que a magia acontece: passamos o 'verificado' para 1
               ============================================================ */
            $stmt = $conn->prepare("UPDATE utilizadores SET ativo = NOW(), verificado = 1 WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();

            /* Remover PIN da tabela para não ser usado de novo */
            $stmt = $conn->prepare("DELETE FROM verificacoes_pin WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();

            /* Login automático: Guardar os dados na sessão */
            $_SESSION["id"] = $user["id"];
            $_SESSION["role_id"] = $user["role_id"];

            /* Redirecionar para o painel correto */
            if ($user["role_id"] == 3) header("Location: painel_do_viewer.php");
            if ($user["role_id"] == 2) header("Location: admin.php");
            if ($user["role_id"] == 1) header("Location: admin.php");
            exit();

        } else {
            $erro = "PIN incorreto. Tente novamente.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Verificar PIN</title>
<link rel="stylesheet" href="css/loginstyle.css">
</head>
<body>

<div class="login-wrapper">
    <form method="POST">
        <h2>Verificação de Conta</h2>

        <p>Enviámos um código de 6 dígitos para o email:</p>
        <p><strong><?php echo htmlspecialchars($email); ?></strong></p>

        <label for="pin">Introduza o PIN:</label>
        <input type="text" id="pin" name="pin" maxlength="6" required>

        <?php if (!empty($erro)): ?>
            <p style="color:red; font-weight:bold;"><?php echo $erro; ?></p>
        <?php endif; ?>

        <button type="submit">Validar</button>

        <p><a href="reenviar_pin.php?email=<?php echo urlencode($email); ?>">Reenviar PIN</a></p>
    </form>
</div>

</body>
</html>