<?php
session_start();
require 'enviar_email.php';

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$user_id = $_SESSION["id"];
$nome_user = $_SESSION["nome"];
$email_user = $_SESSION["email"];

/* Dados vindos do formulário */
$instituicao      = $_POST["instituiçao"];
$professor        = $_POST["professor"];
$email_professor  = $_POST["email_professor"];
$plataforma       = $_POST["plataforma"];
$linguagem        = $_POST["linguagem"];
$linguagem_outra  = $_POST["linguagem-outra"] ?? null;
$num_participantes = (int)$_POST["num_participantes"];

$participante1_nome  = $_POST["participante1"] ?? null;
$participante1_idade = $_POST["idade1"] ?? null;
$participante1_email = $_POST["email_aluno1"] ?? null;
$participante1_curso = $_POST["curso1"] ?? null;

$participante2_nome  = $_POST["participante2"] ?? null;
$participante2_idade = $_POST["idade2"] ?? null;
$participante2_email = $_POST["email_aluno2"] ?? null;
$participante2_curso = $_POST["curso2"] ?? null;

$participante3_nome  = $_POST["participante3"] ?? null;
$participante3_idade = $_POST["idade3"] ?? null;
$participante3_email = $_POST["email_aluno3"] ?? null;
$participante3_curso = $_POST["curso3"] ?? null;

$observacoes = $_POST["observacao"] ?? null;

/* Inserir na tabela inscricoes */
$stmt = $conn->prepare("
    INSERT INTO inscricoes (
        user_id, instituicao, professor, email_professor, plataforma,
        linguagem, linguagem_outra, num_participantes,
        participante1_nome, participante1_idade, participante1_email, participante1_curso,
        participante2_nome, participante2_idade, participante2_email, participante2_curso,
        participante3_nome, participante3_idade, participante3_email, participante3_curso,
        observacoes
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
");

$stmt->bind_param(
    "isssssssissssssisssss",
    $user_id,
    $instituicao,
    $professor,
    $email_professor,
    $plataforma,
    $linguagem,
    $linguagem_outra,
    $num_participantes,
    $participante1_nome,
    $participante1_idade,
    $participante1_email,
    $participante1_curso,
    $participante2_nome,
    $participante2_idade,
    $participante2_email,
    $participante2_curso,
    $participante3_nome,
    $participante3_idade,
    $participante3_email,
    $participante3_curso,
    $observacoes
);

$stmt->execute();

/* Notificação interna para o utilizador */
$stmt = $conn->prepare("
    INSERT INTO notificacoes (user_id, mensagem)
    VALUES (?, ?)
");
$msg_user = "A sua inscrição para a Game Jam For Fun 25 foi recebida e está pendente de aprovação.";
$stmt->bind_param("is", $user_id, $msg_user);
$stmt->execute();

/* Notificação interna para o admin (user_id do admin, ex: 1) */
$admin_id = 1;
$msg_admin = "Nova inscrição submetida por $nome_user.";
$stmt = $conn->prepare("
    INSERT INTO notificacoes (user_id, mensagem)
    VALUES (?, ?)
");
$stmt->bind_param("is", $admin_id, $msg_admin);
$stmt->execute();

/* Criar notificação para admins */
$conn->query("
    INSERT INTO notificacoes (user_id, mensagem, lida, data)
    SELECT id, 'Nova inscrição recebida', 0, NOW()
    FROM utilizadores
    WHERE role_id IN (1,2)
");


/* Email para o utilizador: inscrição recebida */
$mensagem_email = "
    <h2>Inscrição Recebida - Game Jam For Fun 25</h2>
    <p>Olá $nome_user,</p>
    <p>A sua inscrição foi recebida com sucesso.</p>
    <p>Irá receber um email assim que a sua inscrição for aprovada ou rejeitada pela organização.</p>
    <p>Obrigado pela sua participação!</p>
";

enviarEmail($email_user, "Inscrição recebida - Game Jam For Fun 25", $mensagem_email);

$conn->close();

/* Voltar ao painel viewer com mensagem */
header("Location: painel_do_viewer.php?msg=inscricao_ok");
exit();
?>
