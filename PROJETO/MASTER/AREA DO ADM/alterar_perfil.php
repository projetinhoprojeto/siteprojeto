<?php
$password = '';

$id = $_POST['id'];
$perfil = $_POST['perfil'];

$conn = new mysqli('localhost', 'root', $password, 'meu_banco_de_dados');

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "UPDATE usuarios SET perfil = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $perfil, $id);

if ($stmt->execute()) {
    echo "Perfil atualizado com sucesso!";
} else {
    echo "Erro ao atualizar o perfil.";
}

$stmt->close();
$conn->close();
?>
