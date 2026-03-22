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

/* Dados vindos do formulário (Corrigido o 'c' de instituicao) */
$instituicao      = $_POST["instituicao"]; 
$professor        = $_POST["professor"];
$email_professor  = $_POST["email_professor"];
$plataforma       = $_POST["plataforma"];
$linguagem        = $_POST["linguagem"];
$linguagem_outra  = $_POST["linguagem-outra"] ?? null;
$num_participantes = (int)$_POST["num_participantes"];

$participante1_nome  = $_POST["participante1"] ?? null;
$participante1_idade = !empty($_POST["idade1"]) ? (int)$_POST["idade1"] : null;
$participante1_email = $_POST["email_aluno1"] ?? null;
$participante1_curso = $_POST["curso1"] ?? null;

$participante2_nome  = $_POST["participante2"] ?? null;
$participante2_idade = !empty($_POST["idade2"]) ? (int)$_POST["idade2"] : null;
$participante2_email = $_POST["email_aluno2"] ?? null;
$participante2_curso = $_POST["curso2"] ?? null;

$participante3_nome  = $_POST["participante3"] ?? null;
$participante3_idade = !empty($_POST["idade3"]) ? (int)$_POST["idade3"] : null;
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

/* Bind Param corrigido: 
   i = inteiro, s = string 
   Mapeamento exato para as 21 variáveis abaixo!
*/
/* Bind Param corrigido com 21 letras exatas! */
$stmt->bind_param(
    "issssssisissisississs",
    $user_id,              // 1. i
    $instituicao,          // 2. s
    $professor,            // 3. s
    $email_professor,      // 4. s
    $plataforma,           // 5. s
    $linguagem,            // 6. s
    $linguagem_outra,      // 7. s
    $num_participantes,    // 8. i
    $participante1_nome,   // 9. s
    $participante1_idade,  // 10. i
    $participante1_email,  // 11. s
    $participante1_curso,  // 12. s
    $participante2_nome,   // 13. s
    $participante2_idade,  // 14. i
    $participante2_email,  // 15. s
    $participante2_curso,  // 16. s
    $participante3_nome,   // 17. s
    $participante3_idade,  // 18. i
    $participante3_email,  // 19. s
    $participante3_curso,  // 20. s
    $observacoes           // 21. s
);

$stmt->execute();
$stmt->close();

/* Notificação interna para o utilizador */
$stmt = $conn->prepare("
    INSERT INTO notificacoes (user_id, mensagem)
    VALUES (?, ?)
");
$msg_user = "A sua inscrição para a Game Jam For Fun 25 foi recebida e está pendente de aprovação.";
$stmt->bind_param("is", $user_id, $msg_user);
$stmt->execute();
$stmt->close();

/* Notificação interna para o admin (user_id do admin, ex: 1) */
$admin_id = 1;
$msg_admin = "Nova inscrição submetida por $nome_user.";
$stmt = $conn->prepare("
    INSERT INTO notificacoes (user_id, mensagem)
    VALUES (?, ?)
");
$stmt->bind_param("is", $admin_id, $msg_admin);
$stmt->execute();
$stmt->close();

/* Criar notificação para todos os admins (Roles 1 e 2) */
$conn->query("
    INSERT INTO notificacoes (user_id, mensagem, lida, data)
    SELECT id, 'Nova inscrição recebida', 0, NOW()
    FROM utilizadores
    WHERE role_id IN (1,2)
");

/* Email para o utilizador: PENDENTE (Tema Gaming) */
$mensagem_email = '
<!DOCTYPE html>
<html>
<head>
<style>
  @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap");
</style>
</head>
<body style="margin:0; padding:0; background-color: #0f172a;">
<div style="font-family: \'Poppins\', Arial, sans-serif; background-color: #0f172a; padding: 40px 20px; color: #cbd5e1;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #1e293b; border: 2px solid #f59e0b; border-radius: 12px; box-shadow: 0 0 20px rgba(245, 158, 11, 0.2); overflow: hidden;">
        
        <div style="background-color: #f59e0b; padding: 25px 20px; text-align: center;">
            <h1 style="margin: 0; color: #0f172a; font-size: 26px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">&#8987; Status: Loading...</h1>
        </div>
        
        <div style="padding: 40px 30px; font-size: 16px; line-height: 1.7;">
            <h2 style="color: #ffffff; font-size: 24px; margin-top: 0;">Olá, Player 1 (<strong>' . $nome_user . '</strong>)!</h2>
            
            <p>O teu progresso foi guardado com sucesso. A tua candidatura para a <strong>Game Jam For Fun 25</strong> está neste momento <span style="color: #f59e0b; font-weight: 700; text-shadow: 0 0 8px rgba(245,158,11,0.5);">PENDENTE</span>.</p>
            
            <p>A nossa equipa de Game Masters está a rever os teus atributos. Como os <i>slots</i> para este servidor são limitados, precisamos de algum tempo para analisar todas as candidaturas e garantir o melhor <i>matchmaking</i> possível.</p>
            
            <p>Não desligues a consola! Fica atento(a) a esta caixa de email para receberes a notificação final com o resultado.</p>
            
            <hr style="border: none; border-top: 1px solid #334155; margin: 30px 0;">
            <p style="margin: 0; color: #94a3b8; font-size: 15px;">GlHF (Good Luck, Have Fun),<br><strong style="color: #ffffff;">A Organização - Game Jam For Fun 25</strong></p>
        </div>
        
    </div>
</div>
</body>
</html>';

// O envio mantém-se igual (apenas para garantir que tens esta linha logo abaixo)
enviarEmail($email_user, "Inscricao recebida - Game Jam For Fun 25", $mensagem_email);

$conn->close();

/* Voltar ao painel viewer com mensagem */
header("Location: painel_do_viewer.php?msg=inscricao_ok");
exit();
?>