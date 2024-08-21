<?php
$host = 'localhost';
$database = 'erhemunerar';
$user = 'root';
$password = '';

try {
    $connection = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "TRUNCATE TABLE funcionarios";
    $connection->exec($sql);

    echo "Tabela apagada com sucesso!";
} catch(PDOException $e) {
    echo "Erro ao apagar tabela: " . $e->getMessage();
}
?>
