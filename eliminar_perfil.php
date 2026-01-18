<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nome = $_SESSION["usuarioNome"] ?? "Utilizador";
?>

<!-- ============================
     POPUP DE CONFIRMAÇÃO
=============================== -->
<div id="popup-eliminar" class="popup-overlay">
    <div class="popup-box">
        <h2>Eliminar Conta</h2>

        <p>Tem a certeza que deseja eliminar a sua conta,
            <strong><?php echo htmlspecialchars($nome); ?></strong>?
        </p>

        <p class="alerta">Esta ação é permanente e não pode ser desfeita.</p>

        <div class="popup-botoes">
            <a href="processar_eliminar_perfil.php" class="btn-eliminar">SIM, eliminar conta</a>
            <button onclick="fecharPopupEliminar()" class="btn-cancelar">Cancelar</button>
        </div>
    </div>
</div>

<script>
function abrirPopupEliminar() {
    document.getElementById("popup-eliminar").classList.add("show");
}

function fecharPopupEliminar() {
    document.getElementById("popup-eliminar").classList.remove("show");
}
</script>
