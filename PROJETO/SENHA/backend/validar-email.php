<?php
// Verifica se o campo 'email' foi enviado via POST
if (!isset($_POST['email'])) {
    echo 'erro';
    exit;
}

$email = trim(strtolower($_POST['email'])); // Remove espaços e converte para minúsculas

// Verifica se o e-mail é válido
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'email_invalido';
    exit;
}

try {
    // Exemplo de conexão ao banco de dados
    $conn = new PDO("mysql:host=localhost;dbname=meu_banco_de_dados", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificação se o e-mail existe no banco de dados
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE LOWER(email) = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // E-mail encontrado
        echo 'registrado';
    } else {
        // E-mail não encontrado
        echo 'nao_encontrado';
    }
} catch (PDOException $e) {
    // Erro na conexão com o banco de dados
    echo 'erro';
}
?>
