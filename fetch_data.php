<?php
$host = 'localhost';
$database = 'erhemunerar';
$user = 'root';
$password = ''; 

try {
    $connection = new PDO("mysql:host=$host;dbname=$database", $user, $password);

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $connection->query("SELECT * FROM funcionarios");
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch(PDOException $e) {
    echo "Erro ao conectar ao MySQL: " . $e->getMessage();
}
?>
