<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meu_banco_de_dados";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Pega o e-mail enviado via POST
$email = $_POST['email'];

// Proteção contra SQL Injection
$email = mysqli_real_escape_string($conn, $email);

// Verifica se o e-mail existe no banco de dados
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // E-mail encontrado
    echo 'success';
    
} else {
    // E-mail não encontrado
    echo 'error';
}

// Fecha a conexão
$conn->close();
?>
