<?php
require_once "../BD/conexaoBD.php"; 

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. Captura os dados vindos do formulário (usando os 'name' dos inputs)
    // O <select> envia o ID do livro, que será nossa chave estrangeira
    $id_livro = $_POST['cadastro-isbn-livro'] ?? null; 
    $codigo   = $_POST['cadastro-codigo-livro'] ?? '';
    $data     = $_POST['cadastro-data-livro'] ?? '';
    
    // Define um status padrão, já que a tabela pede essa coluna
    $status   = "Disponível"; 

    // Validação básica
    if (empty($id_livro) || empty($codigo) || empty($data)) {
        echo "<p>Por favor, preencha todos os campos.</p>";
        exit;
    }

    try {
        // 2. Prepara o SQL correto para a tabela 'exemplares'
        // As colunas são baseadas na sua imagem: codigo_de_barras, id_livro, status, data_aquisicao
        $sql = "INSERT INTO exemplares (codigo_de_barras, id_livro, status, data_aquisicao) 
                VALUES (:codigo, :id_livro, :status, :data)";
        
        $stmt = $conexao->prepare($sql);

        // 3. Executa a query substituindo os 'placeholders' pelas variáveis
        $stmt->execute([
            ':codigo'   => $codigo,
            ':id_livro' => $id_livro, // Aqui entra a Chave Estrangeira
            ':status'   => $status,
            ':data'     => $data
        ]);

        echo "<p>Exemplar cadastrado com sucesso!</p>";
        echo "<a href='../pages/cadastro-acervo.php'>Voltar</a>"; // Link para facilitar

    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
} else {
    echo "<p>Requisição inválida.</p>";
}
?>