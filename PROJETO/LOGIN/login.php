<?php

session_start(); // Iniciar a sessão
date_default_timezone_set('America/Sao_Paulo');

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "meu_banco_de_dados";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die(json_encode(['sucesso' => false, 'mensagem' => 'Erro na conexão com o banco de dados']));
}

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Proteção contra SQL Injection
    $email = mysqli_real_escape_string($conn, $email);
    $senha = mysqli_real_escape_string($conn, $senha);

    // Busca o e-mail no banco de dados
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // E-mail encontrado, agora verificar a senha
        $row = $result->fetch_assoc();
        $senha_banco = $row['senha']; // Senha armazenada no banco de dados

        // Verifica se a senha é igual
        if ($senha === $senha_banco) {
            // Senha correta, fazer login
            $_SESSION['email'] = $email; // Salva o e-mail na sessão
            $_SESSION['nome'] = $row['nome']; // Salva o nome do usuário na sessão
            $_SESSION['cpf'] = $row['cpf'];
            $_SESSION['perfil'] = $row['perfil'];
            $_SESSION['cep'] = $row['cep'];
            $_SESSION['fotoperfil'] = $row['fotoperfil'];
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['telefoneCelular'] = $row['telefoneCelular'];
            // Gerar um token único
            $token = date('Ymd') . bin2hex(random_bytes(16));

            // Data e hora atuais
            $dataLogin = date('Y-m-d H:i:s');

            // Define a expiração para 5 minutos a partir do login
            $expiracao = date('Y-m-d H:i:s', strtotime('+5 minutes'));

           
            $sqlToken = "INSERT INTO logins (user_name, token, data_login, expiracao) 
                         VALUES ('$email', '$token', '$dataLogin', '$expiracao')";

            if ($conn->query($sqlToken) === TRUE) {
                
                $_SESSION['token'] = $token;

                $sql = "UPDATE usuarios SET status_ativo = 1, ultima_vez_visto = NOW() WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                
                if ($_SESSION['perfil'] == 'master') {
                    echo json_encode(['sucesso' => true, 'redirecionar' => '../SITE COMPLETO/index.php']);
                } else {
                    echo json_encode(['sucesso' => true, 'redirecionar' => '../SITE COMPLETO/index.php']);
                }
            } else {
                
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao registrar login.']);
            }

        } else {
            // Senha incorreta
            echo json_encode(['sucesso' => false, 'mensagem' => 'Senha Inválida...']);
        }
    } else {
        // E-mail não encontrado
        echo json_encode(['sucesso' => false, 'mensagem' => 'E-mail não registrado!']);
    }
}

// Fecha a conexão
$conn->close();
?>
