<?php
    $host = 'localhost';
    $database = 'erhemunerar';
    $user = 'root';
    $pwd = '';

    $conexao = new mysqli($host,$user,$pwd,$database);

    if($conexao->connect_errno){
        echo "Erro";
    }
    else
    {
        echo "conecxão efetuada com sucesso.";
    }
?>