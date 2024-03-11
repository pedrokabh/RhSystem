<?php
$host = 'localhost';
$database = 'erhemunerar';
$user = 'root';
$password = '';

try {
    $connection = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obter a soma dos salários por área e a contagem de funcionários por área
    $query = $connection->query("SELECT Area, SUM(Salario) AS TotalSalarios, COUNT(*) AS TotalFuncionarios FROM funcionarios GROUP BY Area");
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Calcula quantas áreas diferentes existem nos resultados
    $numAreas = count(array_unique(array_column($result, 'Area')));

    // Cria arrays para armazenar os totais de salários e funcionários de cada área
    $totaisSalarios = array();
    $totaisFuncionarios = array();

    // Inicializa os arrays com zeros para cada área
    for ($i = 0; $i < $numAreas; $i++) {
        $totaisSalarios[$i] = 0;
        $totaisFuncionarios[$i] = 0;
    }

    // Preenche os arrays com os totais de salários e funcionários para cada área
    foreach ($result as $row) {
        $areaIndex = array_search($row['Area'], array_unique(array_column($result, 'Area')));
        $totaisSalarios[$areaIndex] += $row['TotalSalarios'];
        $totaisFuncionarios[$areaIndex] += $row['TotalFuncionarios'];
    }

    // Cria um dicionário para armazenar a média salarial de cada área
    $mediaSalarialPorArea = array();

    // Calcula a média de cada área e armazena no dicionário
    for ($i = 0; $i < $numAreas; $i++) {
        $media = $totaisSalarios[$i] / $totaisFuncionarios[$i];
        $mediaSalarialPorArea[$result[$i]['Area']] = number_format($media, 2);
    }

    // Iterar sobre o array e converter os valores para double
    foreach ($mediaSalarialPorArea as $area => &$mediaSalarial) {
        
        $mediaSalarial = str_replace(",", "", $mediaSalarial);
        $mediaSalarial = str_replace(".00", "", $mediaSalarial);

        // Converter para double
        $mediaSalarial = intval($mediaSalarial);
    }

    // Imprimir o array com os valores convertidos para inteiros !!!!!!!!!!!!!!
    // echo "\n" . json_encode($mediaSalarialPorArea);

    // Determinar a altura e a largura da imagem
    $largura = 1000;
    $altura = 400;

    // Criar uma nova imagem
    $img = imagecreatetruecolor($largura, $altura);

    // Definir cores
    $branco = imagecolorallocate($img, 255, 255, 255);
    $preto = imagecolorallocate($img, 0, 0, 0);
    $cores_barras = array(
        imagecolorallocate($img, 0, 0, 255),   // Azul
        imagecolorallocate($img, 255, 0, 0),   // Vermelho
        imagecolorallocate($img, 0, 255, 0),   // Verde
        imagecolorallocate($img, 255, 255, 0), // Amarelo
        imagecolorallocate($img, 255, 165, 0)  // Laranja
    );

    // Preencher o fundo com branco
    imagefilledrectangle($img, 0, 0, $largura, $altura, $branco);

    // Definir margens
    $margem_esquerda = 50;
    $margem_inferior = 60;
    $margem_superior = 30;

    // Calcular a largura de cada barra
    $largura_barra = ($largura - 2 * $margem_esquerda) / count($mediaSalarialPorArea);

    // Espaço entre as barras
    $espaco_entre_barras = 10;

    // Calcular a altura máxima para ajustar as barras à altura da imagem
    $altura_maxima = max($mediaSalarialPorArea);

    // Definir variável para controlar o posicionamento alternado dos textos
    $posicao_texto = 0;

    // Desenhar as barras e adicionar textos
    foreach ($mediaSalarialPorArea as $area => $mediaSalarial) {
        // Selecionar a cor da barra
        $cor_barra = isset($cores_barras[$posicao_texto]) ? $cores_barras[$posicao_texto] : $preto;
    
        $x1 = $margem_esquerda;
        $y1 = $altura - $margem_inferior;
        $x2 = $x1 + $largura_barra;
        $y2 = $altura - $margem_inferior - ($mediaSalarial / $altura_maxima) * ($altura - $margem_inferior - $margem_superior);
    
        // Adicionar a barra com a cor selecionada
        imagefilledrectangle($img, $x1, $y2, $x2, $y1, $cor_barra);
    
        // Adicionar texto com o nome da área
        $x_texto = $x1 + ($largura_barra - imagefontwidth(5) * strlen($area)) / 2;
        $y_texto = $altura - $margem_inferior + ($posicao_texto == 0 ? 20 : 40);
        imagestring($img, 5, $x_texto, $y_texto, $area, $preto);
    
        // Adicionar texto com a média salarial
        $x_texto = $x1 + ($largura_barra - imagefontwidth(5) * strlen($mediaSalarial)) / 6;
        $y_texto = $y2 - 20;
        imagestring($img, 5, $x_texto, $y_texto, "R$" . $mediaSalarial, $preto);
    
        // Alternar posição do próximo texto
        $posicao_texto = ($posicao_texto + 1) % count($cores_barras);
    
        // Mover para a próxima posição (incluindo o espaço entre barras)
        $margem_esquerda += $largura_barra + $espaco_entre_barras;
    }

    // Converte a imagem em base64
    ob_start();
    imagepng($img);
    $image_data = ob_get_clean();
    $base64Content = "data:image/png;base64," . base64_encode($image_data);

    // Destruir a imagem da memória
    imagedestroy($img);

    // Retorna o conteúdo em base64
    // echo '<img src="'. $base64Content .'" alt="Gráfico de Barras">';

    $response = array("base64" => $base64Content);
    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    echo "Erro ao conectar ao MySQL: " . $e->getMessage();
}
?>
