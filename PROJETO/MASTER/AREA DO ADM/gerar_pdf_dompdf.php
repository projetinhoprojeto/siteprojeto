<?php

date_default_timezone_set('America/Sao_Paulo');

// Carregar DOMPDF do CDN
require 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;


// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "meu_banco_de_dados";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}


$sql = "SELECT nome, email FROM usuarios";
$result = $conn->query($sql);


$html = '
    <h1>Lista de Usuários</h1>
    <p>Gerado em: ' . date('d/m/Y H:i:s') . '</p>
    <p>Protocolo: ' . date('Ym') . '-' . rand(1000, 9999) . '</p>
    <table border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>Nome</th>
            <th>Email</th>
        </tr>';

// Adiciona os dados de cada usuário ao HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . htmlspecialchars($row['nome']) . '</td>
                    <td>' . htmlspecialchars($row['email']) . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="2">Nenhum usuário encontrado.</td></tr>';
}

$html .= '</table> <br> <p>&copy; 2024 PetZone. Todos os direitos reservados.</p>';

// Fechar conexão com o banco de dados
$conn->close();

// Instanciar o DOMPDF
$dompdf = new Dompdf();

// Carregar o HTML
$dompdf->loadHtml($html);

// (Opcional) Definir o tamanho e a orientação do papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar o HTML como PDF
$dompdf->render();

// Enviar o PDF como download
$dompdf->stream('lista_usuarios_' . date('Y-m-d') . '.pdf', array("Attachment" => 1));
?>
