<?php
// registar_log.php
function registar_log($conn, $id, $acao, $detalhe = null) {
    $stmt = $conn->prepare("
        INSERT INTO logs_atividade (id, acao, detalhe)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("iss", $id, $acao, $detalhe);
    $stmt->execute();
    $stmt->close();
}
