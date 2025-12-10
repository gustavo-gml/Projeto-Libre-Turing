<?php
// ATENÇÃO: O caminho aqui deve apontar para a pasta BD
require_once "../BD/conexaoBD.php"; 

header('Content-Type: application/json');

$codigo = $_GET['codigo'] ?? '';

if (empty($codigo)) {
    echo json_encode(['sucesso' => false, 'erro' => 'Codigo vazio']);
    exit;
}

try {
    // Busca exemplar DISPONÍVEL
    $sql = "SELECT e.id, l.titulo 
            FROM exemplares e
            INNER JOIN livros l ON e.id_livro = l.id
            WHERE e.codigo_de_barras = :codigo 
            AND e.status = 'Disponível'
            LIMIT 1";

    $stmt = $conexao->prepare($sql);
    $stmt->execute([':codigo' => $codigo]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo json_encode([
            'sucesso' => true,
            'id' => $resultado['id'],
            'titulo' => $resultado['titulo']
        ]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Nao encontrado']);
    }

} catch (Exception $e) {
    // Retorna o erro real para podermos ver no Javascript
    echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
}
?>