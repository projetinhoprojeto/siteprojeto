<?php

$conn = new mysqli ('localhost', 'root', '', 'meu_banco_de_dados');

$sql = "SELECT user_name, data_login, expiracao FROM logins WHERE expiracao > NOW()";
$resultado = $conn->query($sql);

$usuariosLogados = [];

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $dataLogin = date("d/m/Y H:i", strtotime($row['data_login']));
        $dataExpiracao = date("d/m/Y H:i", strtotime($row['expiracao']));

        $usuariosLogados[] = [
            'user_name' => $row['user_name'],
            'data_login' => $dataLogin,
            'expiracao' => $dataExpiracao
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($usuariosLogados);
?>
