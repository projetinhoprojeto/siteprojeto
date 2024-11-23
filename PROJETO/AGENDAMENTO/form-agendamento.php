<?php
session_start();

// Verifique se o usuário está logado e capture o ID
if (!isset($_SESSION['user_id'])) {
    die('Acesso negado. Faça login.');
}

$id_usuario = $_SESSION['user_id'];

// Capture os dados do formulário
$nomeResponsavel = $_POST['nomeResponsavel'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$nomePet = $_POST['nomePet'];
$tipoPet = $_POST['tipoPet'];
$outroAnimal = ($tipoPet === 'outro') ? $_POST['outroAnimal'] : null; // Verifica o tipo de pet
$tipoServico = $_POST['exame'];
$subtipoServico = $_POST['subtipoExame'];
$dataAgendamento = $_POST['dataAgendamento'];
$horario = $_POST['horario'];

try {
    // Conexão com o banco
    $pdo = new PDO("mysql:host=localhost;dbname=meu_banco_de_dados", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL com `outroAnimal` opcional
    $stmt = $pdo->prepare("
        INSERT INTO agendamento 
        (id_usuario, nomeResponsável, telefone, email, nomePet, tipoPet, outroAnimal, tipoServico, subtipo_servico, dataAgendamento, horario)
        VALUES 
        (:id_usuario, :nomeResponsavel, :telefone, :email, :nomePet, :tipoPet, :outroAnimal, :tipoServico, :subtipo_servico, :dataAgendamento, :horario)
    ");

    // Vincula os parâmetros
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':nomeResponsavel', $nomeResponsavel);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':nomePet', $nomePet);
    $stmt->bindParam(':tipoPet', $tipoPet);
    $stmt->bindParam(':outroAnimal', $outroAnimal); // Opcional
    $stmt->bindParam(':tipoServico', $tipoServico);
    $stmt->bindParam(':subtipo_servico', $subtipoServico);
    $stmt->bindParam(':dataAgendamento', $dataAgendamento);
    $stmt->bindParam(':horario', $horario);

    // Executa a query
    if ($stmt->execute()) {
        echo "Agendamento realizado com sucesso!";
        sleep(5);
        header("Location: ../PERFIL/perfil.php");
        exit();
    } else {
        echo "Erro ao realizar o agendamento.";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
