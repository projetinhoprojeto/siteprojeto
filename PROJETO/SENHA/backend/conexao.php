<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=meu_banco_de_dados", "root", "pastelpum123");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
?>
