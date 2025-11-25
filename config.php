<?php
//$esrvidor = "pdb1053.awardspace.net";
//$usuario = "4623811_gamejam"; // 🔹 Substitua pelo seu usuário do MySQL
//$senha = "pwBD2025!2F"; // 🔹 Substitua pela sua senha do MySQL
//$banco = "4623811_gamejam"; // 🔹 Nome do banco de dados


$servidor = "localhost";
$usuario = "root"; // 🔹 Substitua pelo seu usuário do MySQL
$senha = ""; // 🔹 Substitua pela sua senha do MySQL
$banco = "gamejam"; // 🔹 Nome do banco de dados


// 🔹 Melhor conexão com tratamento de erros
$conn = mysqli_connect($servidor, $usuario, $senha, $banco);

if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

// 🔹 Define charset para evitar problemas com caracteres especiais
mysqli_set_charset($conn, "utf8");

?>
