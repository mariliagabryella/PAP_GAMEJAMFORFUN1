<?php
/* ============================================================
   FICHEIRO: conteudo_edicao.php (VERSÃO PDO)
   - Carrega TODOS os campos da tabela edicoes
   - Carrega carrossel e patrocinadores
   - Função edicao($id, 'campo')
============================================================ */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ============================================================
   CONEXÃO COM A BASE DE DADOS (PDO)
============================================================ */
include 'bd_connection.php'; // usa $pdo

/* ============================================================
   CARREGAR TODOS OS CAMPOS DA EDIÇÃO
============================================================ */
function getEdicaoData($id) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM edicoes WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);

    return $dados ?: [];
}

/* ============================================================
   CARREGAR CARROSSEL (HTML)
============================================================ */
function getEdicaoCarrossel($id) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT imagem, legenda 
        FROM edicoes_carrossel 
        WHERE id_edicao = :id
        ORDER BY ordem ASC, id ASC
    ");
    $stmt->execute([':id' => $id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = "";
    foreach ($rows as $row) {
        $img = htmlspecialchars($row['imagem']);
        $alt = htmlspecialchars($row['legenda'] ?? '');
        $html .= "<img src='$img' alt='$alt'>";
    }

    return $html;
}

/* ============================================================
   CARREGAR PATROCINADORES (HTML)
============================================================ */
function getEdicaoPatrocinadores($id) {
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT logo, link 
        FROM edicoes_patrocinadores 
        WHERE id_edicao = :id
        ORDER BY ordem ASC, id ASC
    ");
    $stmt->execute([':id' => $id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = "";
    foreach ($rows as $row) {
        $logo = htmlspecialchars($row['logo']);
        $link = htmlspecialchars($row['link']);
        $html .= "<a href='$link' target='_blank'><img src='$logo'></a>";
    }

    return $html;
}

/* ============================================================
   FUNÇÃO PRINCIPAL: edicao($id, 'campo')
============================================================ */
function edicao($id, $campo) {
    static $cache = [];

    // Carregar dados apenas uma vez
    if (!isset($cache[$id])) {
        $cache[$id] = getEdicaoData($id);
    }

    // Campos especiais (HTML)
    if ($campo === "carrossel") {
        return getEdicaoCarrossel($id);
    }

    if ($campo === "patrocinadores") {
        return getEdicaoPatrocinadores($id);
    }

    // Campos normais da tabela edicoes
    return $cache[$id][$campo] ?? "";
}
