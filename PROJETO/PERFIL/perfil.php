<?php
session_start(); // Iniciar a sessão

if (!isset($_SESSION['email'])){
    echo 'Acesso Negado, Logar-se!';
    header('Location: ../LOGIN/login.html');
}
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meu_banco_de_dados";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Pegar o ID do usuário logado da sessão
$user_id = $_SESSION['user_id'];
$imagens = '../CADASTRO/' . $_SESSION['fotoperfil'];

// Consulta os dados do usuário logado no banco de dados
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Consultar agendamentos futuros
$sql_agendamentos = "
    SELECT id_agendamento, nomePet, tipoServico, dataAgendamento, horario 
    FROM agendamento
    WHERE id_usuario = ? AND dataAgendamento >= CURDATE()
    ORDER BY dataAgendamento ASC";
$stmt = $conn->prepare($sql_agendamentos);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_agendamentos = $stmt->get_result();
$agendamentos = $result_agendamentos->fetch_all(MYSQLI_ASSOC);

// Consultar histórico 
$sql_historico = "
    SELECT nomePet, tipoServico, dataAgendamento, horario 
    FROM agendamento
    WHERE id_usuario = ? AND dataAgendamento < CURDATE() 
    AND dataAgendamento >= DATE_SUB(CURDATE(), INTERVAL 120 DAY)
    ORDER BY dataAgendamento DESC";
$stmt = $conn->prepare($sql_historico);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_historico = $stmt->get_result();
$historico = $result_historico->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="perfil.css">
    <title>Perfil do Usuário</title>
</head>
<body>
    <main>
    <header class="cabecalho">
        <div class="logo">
            <img src="../SITE COMPLETO/IMAGENS/logoborda.png" alt="Logo PetZone">
        </div>
        
            <ul>
                <li><a href="../SITE COMPLETO/index.php"></a></li>
            </ul>
        
        <div class="login-usuario">
            <a href="#"><img src="../CADASTRO/<?=$imagens?>" alt="Perfil"></a>
        </div>
        <div class="acessibilidade">
            <button id="botao-tema"></button>
            <button id="aumentar-fonte">A+</button>
            <button id="diminuir-fonte">A-</button>
        </div>
    </header>
    <div class="container">
        <!-- Menu lateral -->
        <div class="menu">
            <ul>
                <li><a href="#perfil">Perfil</a></li>
                <li><a href="#agendamento">Agendamento</a></li>
                <li><a href="#historico">Histórico</a></li>
            </ul>
        </div>

        <!-- Conteúdo principal -->
        <div class="content">
            <!-- Seção de perfil -->
            <section id="perfil">
                <div class="profile-card">
                    <img src="<?= $imagens?>" alt="Foto de Perfil" class="profile-pic">
                    <h2><?= htmlspecialchars($user['nome']) ?></h2>
                    <p>Email: <?= htmlspecialchars($user['email']) ?></p>
                    <p>Telefone: <?= htmlspecialchars($user['telefoneCelular']) ?></p>
                    <p>CEP: <?= htmlspecialchars($user['cep']) ?></p>
                    <p>Endereço: <?= htmlspecialchars($user['endereco']) ?></p>
                    <p>Data de Nascimento: <?= htmlspecialchars($user['data_nascimento']) ?></p>
                    <button onclick="document.getElementById('edit-form').style.display='block'">Editar Perfil</button>
                </div>

                <!-- Formulário de edição do perfil -->
                <div id="edit-form" style="display:none;">
    <form id="edit-profile-form">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($user['nome']) ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="telefone">Telefone Celular:</label>
        <input type="text" id="telefoneCelular" name="telefoneCelular" value="<?= htmlspecialchars($user['telefoneCelular']) ?>">

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" value="<?= htmlspecialchars($user['endereco']) ?>">

        <label for="cep">CEP:</label>
        <input type="text" id="cep" name="cep" value="<?= htmlspecialchars($user['cep']) ?>" required>

        <button type="submit" onclick="document.getElementById('edit-form').style.display='none'">Salvar Alterações</button>
        <button type="button" onclick="document.getElementById('edit-form').style.display='none'">Cancelar</button>
    </form>
</div>
<div id="response-message"></div> <!-- Mensagem de resposta -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Captura o envio do formulário
    $('#edit-profile-form').on('submit', function(e) {
        e.preventDefault(); // Evita o envio padrão do formulário

        // Coleta os dados do formulário
        var formData = $(this).serialize(); 

        // Envia via AJAX
        $.ajax({
            url: 'editar_perfil.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Exibe a resposta de sucesso ou erro
                $('#response-message').html(response);
            },
            error: function() {
                $('#response-message').html("Erro ao atualizar os dados.");
            }
        });
    });
</script>

            </section>

            
              
                <!-- Seção de agendamentos futuros -->
                <section id="agendamento">
    <h2>Agendados</h2>
    <?php if (!empty($agendamentos)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome do Paciente</th>
                    <th>Tipo de Serviço</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Cancelar</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($agendamentos as $agendamento): ?>
                    <tr>
                        <td><?= htmlspecialchars($agendamento['nomePet']) ?></td>
                        <td><?= htmlspecialchars($agendamento['tipoServico']) ?></td>
                        <td><?= date('d/m/Y', strtotime($agendamento['dataAgendamento'])) ?></td>
                        <td><?= htmlspecialchars($agendamento['horario']) ?></td>
                        <td>
                            <!-- Botão de exclusão -->
                            <button class="delete-btn" data-id="<?= $agendamento['id_agendamento'] ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Você não fez nenhum agendamento ainda.</p>
    <?php endif; ?>
</section>


                <!-- Seção de histórico -->
                <section id="historico">
                    <h2>Histórico de Consultas</h2>
                    <?php if (!empty($historico)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome do Paciente</th>
                                    <th>Tipo de Serviço</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($historico as $consulta): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($consulta['nomePet']) ?></td>
                                        <td><?= htmlspecialchars($consulta['tipoServico']) ?></td>
                                        <td><?= date('d/m/Y', strtotime($consulta['dataAgendamento'])) ?></td>
                                        <td><?= htmlspecialchars($consulta['horario']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Não há histórico de consultas nos últimos 120 dias.</p>
                    <?php endif; ?>
                </section>

        </div>
    </div> 

    <script>
          // Captura o clique no botão de exclusão
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const idAgendamento = this.getAttribute('data-id');

            if (confirm('Deseja realmente cancelar este agendamento?')) {
                // Envia a solicitação via AJAX
                fetch('cancelar-agendamento.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: idAgendamento })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Agendamento cancelado com sucesso!');
                        location.reload(); // Atualiza a página
                    } else {
                        alert('Erro ao cancelar o agendamento: ' + data.error);
                    }
                })
                .catch(error => {
                    alert('Erro ao processar a solicitação.');
                    console.error(error);
                });
            }
        });
    });

    </script>
    <script src="perfil.js"></script>
</body>
</html>
