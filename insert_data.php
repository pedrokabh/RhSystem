<?php
function insertData($name, $lastName, $age, $entryDate, $area, $salario) {
    $host = 'localhost';
    $database = 'erhemunerar';
    $user = 'root';
    $password = '';

    try {
       
        $connection = new PDO("mysql:host=$host;dbname=$database", $user, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO funcionarios (Name, SecondName, Idade, DataAdmissao, Area, Salario) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $connection->prepare($sql);
        $statement->execute([$name, $lastName, $age, $entryDate, $area, $salario]);
        header("Location: Template.html");
        exit();
    } catch(PDOException $e) {
        return "Erro ao inserir dados no MySQL: " . $e->getMessage();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $lastName = $_POST["lastName"];
    $age = $_POST["age"];
    $entryDate = $_POST["entryDate"];
    $area = $_POST["area"];
    $salario = $_POST["salario"];
    echo insertData($name, $lastName, $age, $entryDate, $area, $salario);
}
?>
