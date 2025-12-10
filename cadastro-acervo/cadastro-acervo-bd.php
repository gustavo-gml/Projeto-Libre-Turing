<?php
session_start(); // 1. Inicia a sessão para poder transportar a mensagem
require_once "../BD/conexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id_livro = $_POST['cadastro-isbn-livro'] ?? null; 
    $codigo   = $_POST['cadastro-codigo-livro'] ?? '';
    $data     = $_POST['cadastro-data-livro'] ?? '';
    $status   = "Disponível"; 

    if (empty($id_livro) || empty($codigo) || empty($data)) {
        $_SESSION['message'] = "Erro: Por favor, preencha todos os campos.";
        $_SESSION['type'] = "error"; // Opcional, para controle futuro
        header("Location: ../pages/cadastro-acervo.php"); // Voltar para o formulário
        exit;
    }

    try {
        $sql = "INSERT INTO exemplares (codigo_de_barras, id_livro, status, data_aquisicao) 
                VALUES (:codigo, :id_livro, :status, :data)";
        
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':codigo'   => $codigo,
            ':id_livro' => $id_livro,
            ':status'   => $status,
            ':data'     => $data
        ]);

        // 2. Sucesso: Salva mensagem e redireciona
        $_SESSION['message'] = "Exemplar cadastrado com sucesso!";
        header("Location: ../pages/cadastro-acervo.php"); 
        exit;

    } catch (PDOException $e) {
        // 3. Erro SQL: Salva mensagem e redireciona
        $_SESSION['message'] = "Erro ao cadastrar no banco: " . $e->getMessage();
        header("Location: ../pages/cadastro-acervo.php");
        exit;
    }
} else {
    // Acesso direto inválido
    $_SESSION['message'] = "Requisição inválida.";
    header("Location: ../pages/cadastro-acervo.php");
    exit;
}
?>