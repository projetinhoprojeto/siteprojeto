<?php
// Configuração do banco de dados
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "meu_banco_de_dados";  // Nome do seu banco de dados

// Conectando ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se há erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recebe a resposta e a pergunta enviada via POST
$respostaUsuario = isset($_POST['resposta']) ? trim($_POST['resposta']) : "";
$pergunta = isset($_POST['pergunta']) ? trim($_POST['pergunta']) : "";

// Preparar a consulta de acordo com a pergunta recebida
$sql = "";
switch ($pergunta) {
    case "nome_materno":
        $sql = "SELECT nome_materno FROM usuarios WHERE nome_materno = ?";
        break;
    case "cep":
        $sql = "SELECT cep FROM usuarios WHERE cep = ?";
        break;
    case "data_nascimento":
        $sql = "SELECT data_nascimento FROM usuarios WHERE data_nascimento = ?";
        break;
    default:
        echo json_encode(['sucesso' => false, 'mensagem' => 'Pergunta inválida']);
        exit;
}

// Executar a consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $respostaUsuario);
$stmt->execute();
$stmt->bind_result($respostaCorreta);

$sucesso = false;

if ($stmt->fetch()) {
    // Formatar a resposta dependendo da pergunta
    if ($pergunta === "cep") {
       /* $respostaUsuario = str_replace('-', '', $respostaUsuario); // Remover traço do CEP
        $respostaCorreta = str_replace('-', '', $respostaCorreta); // Formatar CEP do BD*/
    } elseif ($pergunta === "data_nascimento") {
        /* yyyy-m-dd */
    }

    // Comparar a resposta do usuário com a resposta correta do banco de dados
    if (strtolower($respostaUsuario) === strtolower($respostaCorreta)) {
        $sucesso = true;
    }
}

$stmt->close();
$conn->close();

// Retornar o resultado da verificação
header('Content-Type: application/json');
echo json_encode(['sucesso' => $sucesso]);
?>
