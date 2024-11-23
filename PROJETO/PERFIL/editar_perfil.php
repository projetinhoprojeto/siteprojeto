<?php
session_start(); // Certifique-se de que a sessão esteja iniciada

// Conexão com o banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=meu_banco_de_dados', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verificar se o formulário foi enviado via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefoneCelular = $_POST['telefoneCelular'];
    $endereco = $_POST['endereco'];
    $cep = $_POST['cep'];

    // Verificar o id do usuário logado
    $userId = $_SESSION['user_id']; // Supondo que o id do usuário esteja na sessão

    // Atualizar os dados no banco de dados
    $sql = "UPDATE usuarios SET nome = :nome, email = :email, telefoneCelular = :telefoneCelular, endereco = :endereco, cep = :cep WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefoneCelular', $telefoneCelular);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':id', $userId);

    if ($stmt->execute()) {
        echo "Dados atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar os dados.";
    }
}
?>
