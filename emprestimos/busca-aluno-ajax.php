<?php
// Arquivo: emprestimos/busca-aluno-ajax.php
require_once "../bd/conexaoBD.php"; 

header('Content-Type: application/json');

$ra = $_GET['ra'] ?? '';

if (empty($ra)) {
    echo json_encode(['sucesso' => false]);
    exit;
}

try {
    // Busca o aluno pelo RA
    $sql = "SELECT ra, nome_aluno FROM alunos WHERE ra = :ra LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([':ra' => $ra]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        echo json_encode([
            'sucesso' => true,
            'ra' => $resultado['ra'],
            'nome' => $resultado['nome_aluno']
        ]);
    } else {
        echo json_encode(['sucesso' => false]);
    }

} catch (Exception $e) {
    echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
}
?>