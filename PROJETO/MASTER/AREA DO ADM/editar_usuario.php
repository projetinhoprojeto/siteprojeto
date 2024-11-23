<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meu_banco_de_dados";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Obtém os dados enviados pelo AJAX
$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$cep = $_POST['cep'];
$dataNascimento = $_POST['dataNascimento'];
$genero = $_POST['genero'];
$nomeMaterno = $_POST['nomeMaterno'];
$celular = $_POST['celular'];
$fixo = $_POST['fixo'];

// Atualiza os dados do usuário no banco de dados
$sql = "UPDATE usuarios SET nome=?, email=?, cpf=?, cep=?, data_nascimento=?, genero=?, nome_materno=?, telefoneCelular=?, telefoneFixo=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssi", $nome, $email, $cpf, $cep, $dataNascimento, $genero, $nomeMaterno, $celular, $fixo, $id);
$stmt->execute();

$stmt->close();
$conn->close();

// Retorna sucesso
echo "Usuário atualizado com sucesso!";
?>
