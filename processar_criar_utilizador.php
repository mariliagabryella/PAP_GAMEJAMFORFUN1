<?php
session_start();
include 'bd_connection.php';

// 1. SEGURANÇA: Apenas o Admin Master (role_id = 1) pode aceder a este script
if (!isset($_SESSION["role_id"]) || $_SESSION["role_id"] != 1) {
    header("Location: login.php");
    exit();
}

// 2. VERIFICA SE O FORMULÁRIO FOI ENVIADO
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Receber os dados e limpar espaços em branco
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha_hash = $_POST['senha']; // Mantém este nome
    $role_id = (int) $_POST['role_id']; 

    // Validar se o cargo escolhido é válido (2 = Admin, 3 = Viewer)
    if ($role_id !== 2 && $role_id !== 3) {
        die("Erro: Cargo de utilizador inválido.");
    }

    // 3. ENCRIPTAR A PASSWORD (Super importante para segurança)
    // Agora sim, a variável $senha_plana existe e vai ser encriptada
    $senha_hash = password_hash($senha_hash, PASSWORD_DEFAULT);

    // 4. TRATAR O UPLOAD DA FOTO DE PERFIL
    // Caminho da foto por defeito (caso ele não envie nenhuma)
    $caminho_foto = "img/default.png"; 

    // Verifica se foi enviado um ficheiro e se não tem erros
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        
        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        // Verifica se é mesmo uma imagem
        if (in_array($extensao, $extensoes_permitidas)) {
            $novo_nome_ficheiro = uniqid() . '.' . $extensao;
            $destino_pasta = 'img/' . $novo_nome_ficheiro;

            // Move a imagem temporária para a pasta final "img/"
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino_pasta)) {
                $caminho_foto = $destino_pasta; // Atualiza o caminho para guardar na BD
            } else {
                die("Erro ao guardar a imagem na pasta.");
            }
        } else {
            die("Erro: Formato de imagem não suportado. Usa apenas JPG, PNG, GIF ou WEBP.");
        }
    }

    // 5. INSERIR NA BASE DE DADOS
    try {
        // Verifica primeiro se o email já existe
        $stmt_check = $pdo->prepare("SELECT id FROM utilizadores WHERE email = ?");
        $stmt_check->execute([$email]);
        
        if ($stmt_check->rowCount() > 0) {
            die("Erro: Este email já está registado noutra conta. <a href='criar_utilizador.php'>Voltar</a>");
        }

        // CORREÇÃO: Usar a coluna "senha_hash" e o placeholder ":senha_hash"
        $sql = "INSERT INTO utilizadores (nome, email, senha_hash, role_id, foto) VALUES (:nome, :email, :senha_hash, :role_id, :foto)";
        $stmt = $pdo->prepare($sql);
        
        // CORREÇÃO: Ligar as variáveis corretas
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha_hash' => $senha_hash,
            ':role_id' => $role_id,
            ':foto' => $caminho_foto // Usar a variável do caminho
        ]);

        // 6. REDIRECIONAR COM MENSAGEM DE SUCESSO
        header("Location: admin.php?msg=utilizador_criado");
        exit();

    } catch (PDOException $e) {
        die("Erro na base de dados: " . $e->getMessage());
    }

} else {
    // Se alguém tentar aceder a este ficheiro diretamente pelo link sem preencher o formulário
    header("Location: criar_utilizador.php");
    exit();
}
?>