<?php session_start();

// Garanta que o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header (" Location:../ERRO 404/erro.html");
}

// Capture os dados da sessão
$nome = $_SESSION['nome'] ?? '';
$telefone = $_SESSION['telefoneCelular'] ?? '';
$email = $_SESSION['email'] ?? '';
$imagem = $_SESSION['fotoperfil'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Agendamento</title>
    <link rel="stylesheet" href="agendamento.css">
    <link rel="stylesheet" href="cadastro.css">
    <style>
    </style>
</head>
<body>
    <header class="cabecalho">
        <div class="logo">
            <img src="IMAGENS/logoborda.png" alt="Logo PetZone">
        </div>
        <nav class="menu">
            <ul>
                <li><a class="home" href="../SITE COMPLETO/index.php"></a></li>
            </ul>
        </nav>
        <div class="login-usuario">
            <a href="#"><img src="../CADASTRO/<?= htmlspecialchars($imagem) ?>" alt="Perfil"></a>
        </div>
        <div class="acessibilidade">
            <button id="botao-tema">Alterar Tema</button>
            <button id="aumentar-fonte">A+</button>
            <button id="diminuir-fonte">A-</button>
        </div>
    </header>
    <div class="form-container">
        <form id="agendamentoForm" action="form-agendamento.php" method="POST">
            <h2>Agendamento</h2>

            <label for="nomeResponsavel">Nome do Responsável:</label>
            <input type="text" id="nomeResponsavel" name="nomeResponsavel" placeholder="Seu nome completo" value="<?= htmlspecialchars($nome) ?>"  required>

            <label for="telefone">Telefone Celular:</label>
            <input type="tel" id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX" value="<?= htmlspecialchars($telefone) ?>" minlength="14" required>
            <div id="telefoneErro" style="color: red; display: none;">Número de telefone inválido</div>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" value="<?= htmlspecialchars($email) ?>" required>

            <label for="nomePet">Nome do Pet:</label>
            <input type="text" id="nomePet" name="nomePet" placeholder="Nome do seu pet" required>

            <label for="tipoPet">Tipo de Animal:</label>
            <select id="tipoPet" name="tipoPet" onchange="mostrarCampoOutroAnimal()" required>
                <option value="">Selecione o tipo de animal</option>
                <option value="cachorro">Cachorro</option>
                <option value="gato">Gato</option>
                <option value="outro">Outro</option>
            </select>

            <div id="outroAnimalContainer" style="display: none;">
                <label for="outroAnimal">Especifique o animal:</label>
                <input type="text" id="outroAnimal" name="outroAnimal" placeholder="Digite o tipo de animal">
            </div>

            <label for="exame">Tipo de serviço:</label>
            <select id="exame" name="exame" onchange="mostrarOpcoes()" required>
                <option value="">Selecione o tipo de exame</option>
                <option value="consulta">Consulta</option>
                <option value="vacinação">Vacinação</option>
                <option value="cirurgia">Cirurgia</option>
                <option value="exame">Exame</option>
            </select>

            <div id="subtiposContainer" style="display: none;">
                <label for="subtipoExame">Opções de serviço:</label>
                <select id="subtipoExame" name="subtipoExame" required>
                </select>
            </div>

            <div id="horariosContainer" style="display: none;">
                <label for="horario">Escolha o horário:</label>
                <select id="horario" name="horario" required>
                </select>
            </div>

            <label for="dataAgendamento">Data do Agendamento:</label>
            <input type="date" id="dataAgendamento" name="dataAgendamento" min="" required>

            <button type="submit">Agendar</button>
        </form>
    </div>
    <script src="agendamento.js" defer></script>
</body>
</html>
