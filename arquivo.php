<?php
$diretorioDestino = "uploads/";

// 🔹 Criar o diret�rio se n�o existir
if (!is_dir($diretorioDestino)) {
    mkdir($diretorioDestino, 0777, true);
}

// 🗂️ Verifica se há arquivos enviados
if (!empty($_FILES["autorizacao"]["name"][0])) {
    foreach ($_FILES["autorizacao"]["name"] as $key => $nomeArquivo) {
        $caminhoTemp = $_FILES["autorizacao"]["tmp_name"][$key];
        $caminhoFinal = $diretorioDestino . basename($nomeArquivo);

        // 🔄 Move o arquivo para o diretório desejado
        if (move_uploaded_file($caminhoTemp, $caminhoFinal)) {
            echo "✅ Arquivo $nomeArquivo enviado com sucesso!<br>";
        } else {
            echo "❌ Erro ao enviar o arquivo $nomeArquivo.<br>";
        }
    }
} else {
    echo "⚠ Nenhum arquivo foi enviado.";
}
?>