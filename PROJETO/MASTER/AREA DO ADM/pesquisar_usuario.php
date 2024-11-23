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

// Obter o termo de pesquisa da URL
$termo = isset($_GET['termo']) ? $_GET['termo'] : '';

// Monta a query para buscar usuários que contenham a substring no nome
$sql = "SELECT id, email, nome, cpf, cep, data_nascimento, genero, nome_materno, telefoneCelular, telefoneFixo, status_ativo, perfil FROM usuarios WHERE nome LIKE ?";
$stmt = $conn->prepare($sql);
$termoBusca = "%" . $termo . "%";
$stmt->bind_param("s", $termoBusca);
$stmt->execute();
$result = $stmt->get_result();

// Gera a lista de usuários
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statusColor = $row['status_ativo'] == 1 ? 'green' : 'red';
        $perfilAtual = $row['perfil'];
        echo "<li>" .
            "<span style='color: {$statusColor}; font-size: 20px;'>&#8226;</span> <div class='responsive'> " .
            "<span>ID: " . htmlspecialchars($row['id']) . " - </span> <h5> " . htmlspecialchars($row['nome']) . "</h5> </div>" .
            "<p>Email: " . htmlspecialchars($row['email']) . "</p>" . 

            
            "<select onchange='alterarPerfil(" . $row['id'] . ", this.value)'>" .
                "<option value='comum'" . ($perfilAtual == 'comum' ? ' selected' : '') . ">Comum</option>" .
                "<option value='master'" . ($perfilAtual == 'master' ? ' selected' : '') . ">Master</option>" .
            "</select>" .


            "<button onclick='perfil(" . $row['id'] . ")' style='display: none;''>Perfil</button>" .
            "<button onclick='excluirUsuario(" . $row['id'] . ")'>Excluir</button>" .
            "<button onclick='abrirModal(" . $row['id'] . ", \"" . htmlspecialchars($row['nome']) . "\", \"" . htmlspecialchars($row['email']) . "\", \"" .
             htmlspecialchars($row['cpf']) . "\", \"" . htmlspecialchars($row['cep']) .
              "\", \"" . htmlspecialchars($row['data_nascimento']) . "\", \"" .
               htmlspecialchars($row['genero']) . "\", \"" . htmlspecialchars($row['nome_materno']) .
                "\", \"" . htmlspecialchars($row['telefoneCelular']) .
                 "\", \"" . htmlspecialchars($row['telefoneFixo']) . "\", \"" . 
                 $row['status_ativo'] . "\")'>Editar</button>" .
            "</li>";
    }
} else {
    echo "<li>Nenhum usuário encontrado.</li>";
}

$stmt->close();
$conn->close();
?>


