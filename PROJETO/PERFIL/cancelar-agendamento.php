<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'error' => 'Acesso negado. Faça login.']);
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meu_banco_de_dados";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Erro na conexão com o banco de dados.']);
    exit;
}

// Recebe o ID do agendamento
$data = json_decode(file_get_contents('php://input'), true);
$idAgendamento = $data['id'];

// Verifica se o ID do agendamento pertence ao usuário logado
$user_id = $_SESSION['user_id'];

$sql = "DELETE FROM agendamento WHERE id_agendamento = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $idAgendamento, $user_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Falha ao cancelar o agendamento.']);
}

$stmt->close();
$conn->close();
?>
