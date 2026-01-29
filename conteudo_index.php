<?php
function index_conteudo($campo) {
    static $cache = [];

    if (!isset($cache[$campo])) {
        $conn = new mysqli("127.0.0.1", "root", "", "gamejamforfun2");
        $stmt = $conn->prepare("SELECT valor FROM conteudo_index WHERE campo=? LIMIT 1");
        $stmt->bind_param("s", $campo);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $cache[$campo] = $res ? $res["valor"] : "";
    }

    return $cache[$campo];
}
?>
