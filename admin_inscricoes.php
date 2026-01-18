<?php
session_start();

if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

/* Buscar inscrições */
$sql = "SELECT i.*, u.nome AS nome_user
        FROM inscricoes i
        JOIN utilizadores u ON i.user_id = u.id
        ORDER BY i.data_inscricao DESC";
$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>Gestão de Inscrições</title>
<link rel="stylesheet" href="css/admin.css">
</head>
<body>

<?php include 'admin.php'; // se tiveres um menu de admin ?>

<div class="admin-content">
    <h1>Inscrições - Game Jam For Fun 25</h1>

    <table class="tabela-inscricoes" border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Utilizador</th>
            <th>Instituição</th>
            <th>Professor</th>
            <th>Email Professor</th>
            <th>Plataforma</th>
            <th>Linguagem</th>
            <th>Nº Participantes</th>
            <th>Estado</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>

        <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['nome_user']); ?></td>
            <td><?php echo htmlspecialchars($row['instituicao']); ?></td>
            <td><?php echo htmlspecialchars($row['professor']); ?></td>
            <td><?php echo htmlspecialchars($row['email_professor']); ?></td>
            <td><?php echo htmlspecialchars($row['plataforma']); ?></td>
            <td>
                <?php 
                echo htmlspecialchars($row['linguagem']);
                if (!empty($row['linguagem_outra'])) {
                    echo " (" . htmlspecialchars($row['linguagem_outra']) . ")";
                }
                ?>
            </td>
            <td><?php echo (int)$row['num_participantes']; ?></td>
            <td><?php echo $row['estado']; ?></td>
            <td><?php echo $row['data_inscricao']; ?></td>
            <td>
                <?php if ($row['estado'] == 'pendente'): ?>
                    <a href="aprovar_inscricao.php?id=<?php echo $row['id']; ?>">Aprovar</a> |
                    <a href="rejeitar_inscricao.php?id=<?php echo $row['id']; ?>">Rejeitar</a>
                <?php elseif ($row['estado'] == 'aprovado'): ?>
                    Aprovada
                <?php else: ?>
                    Rejeitada
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
