<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conectar ao banco de dados
$servername = "localhost"; // Altere conforme necessário
$username = "root"; // Altere conforme necessário
$password = ""; // Altere conforme necessário
$dbname = "formulario_db"; // Altere conforme necessário

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Conexão falhou: " . $conn->connect_error]));
}

// Obter dados do formulário
$nome = $_POST['nome'];
$senha = $_POST['senha'];

// Preparar e executar a consulta
$sql = "SELECT * FROM usuarios WHERE nome = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    
    // Verifique a senha
    if (password_verify($senha, $usuario['senha'])) {
        // Credenciais corretas
        echo json_encode(['success' => true]);
        exit();
    }
}

// Senha ou usuário incorretos
echo json_encode(['success' => false, 'message' => "Nome de usuário ou senha incorretos."]);

// Fechar conexão
$stmt->close();
$conn->close();
?>
