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

    $idades = ["-18", "18-25", "25-35", "35-45", "45-55", "55+"];
    $qtdeFuncionarios = [0, 0, 0, 0, 0, 0];

    foreach ($result as $row) {
        $idade = $row['Idade'];

        if ($idade < 18) {
            $qtdeFuncionarios[0]++;
        } elseif ($idade >= 18 && $idade < 26) {
            $qtdeFuncionarios[1]++;
        } elseif ($idade >= 26 && $idade < 36) {
            $qtdeFuncionarios[2]++;
        } elseif ($idade >= 36 && $idade < 46) {
            $qtdeFuncionarios[3]++;
        } elseif ($idade >= 46 && $idade < 56) {
            $qtdeFuncionarios[4]++;
        } else {
            $qtdeFuncionarios[5]++;
        }
    }

    // Determinar a altura e a largura da imagem
    $largura = 400;
    $altura = 320;
    
    // Criar uma nova imagem
    $img = imagecreatetruecolor($largura, $altura);
    
    // Definir cores
    $branco = imagecolorallocate($img, 255, 255, 255);
    $preto = imagecolorallocate($img, 0, 0, 0);
    $azul = imagecolorallocate($img, 0, 0, 255);
    
    // Preencher o fundo com branco
    imagefilledrectangle($img, 0, 0, $largura, $altura, $branco);
    
    // Definir margens
    $margem_esquerda = 50;
    $margem_inferior = 60;
    $margem_superior = 30;
    
    // Calcular a largura de cada barra
    $largura_barra = ($largura - 2 * $margem_esquerda) / count($idades);
    
    // Calcular a altura máxima para ajustar as barras à altura da imagem
    $altura_maxima = max($qtdeFuncionarios);
    $altura_barra = ($altura - $margem_inferior - $margem_superior) / $altura_maxima;
    
    // Desenhar as barras
    for ($i = 0; $i < count($idades); $i++) {
        $x1 = $margem_esquerda + $i * ($largura_barra+10);
        $y1 = $altura - $margem_inferior;
        $x2 = $x1 + $largura_barra;
        $y2 = $altura - $margem_inferior - $qtdeFuncionarios[$i] * $altura_barra;
        imagefilledrectangle($img, $x1, $y1, $x2, $y2, $azul);
        
        // Adicionar texto com a categoria
        $categoria = $idades[$i];
        $x_texto = $x1 + ($largura_barra - imagefontwidth(5) * strlen($categoria)) / 2;
        $y_texto = $altura - $margem_inferior + 20;
        imagestring($img, 5, $x_texto, $y_texto, $categoria, $preto);
        
        // Adicionar texto com a contagem
        $x_texto = $x1 + ($largura_barra - imagefontwidth(5) * strlen($qtdeFuncionarios[$i])) / 2;
        $y_texto = $y2 - 20;
        imagestring($img, 5, $x_texto, $y_texto, $qtdeFuncionarios[$i], $preto);
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
    // echo $base64Content;

    // Gerando json
    $response = array("base64" => $base64Content);
    header('Content-Type: application/json');
    echo json_encode($response);

} catch (PDOException $e) {
    echo "Erro ao conectar ao MySQL: " . $e->getMessage();
}
?>
