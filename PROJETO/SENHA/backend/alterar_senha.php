<?php
// Conectar ao banco de dados
$servername = "localhost";  // Servidor do MySQL
$username = "root";  // Nome de usuário do MySQL
$password = "";  // Senha do MySQL
$dbname = "meu_banco_de_dados";  // Nome do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Pega os dados enviados pelo formulário
$email = $_POST['email'];
$nova_senha = $_POST['nova_senha'];

// Proteção contra SQL Injection
$email = mysqli_real_escape_string($conn, $email);
$nova_senha = mysqli_real_escape_string($conn, $nova_senha);

// Verificar se o e-mail está cadastrado
$sql_check = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql_check);

if ($result->num_rows > 0) {
    // E-mail encontrado, atualizar a senha
    $senha_hash = $nova_senha;
    $sql_update = "UPDATE usuarios SET senha = '$senha_hash' WHERE email = '$email'";

    if ($conn->query($sql_update) === TRUE) {
        echo "Senha alterada com sucesso!";
        header('Location: ../../LOGIN/login.html');
    } else {
        echo "Erro ao atualizar a senha: " . $conn->error;
    }
} else {
    // E-mail não encontrado, exibir mensagem de erro
    echo '<div style="color: red;">E-mail não encontrado!</div>  <br>
           <a class="voltar" href="../ESQUECI SENHA/esquecisenha.html"> <i class="bi bi-arrow-bar-left"> Voltar </a> ';
}

// Fecha a conexão
$conn->close();
?>
