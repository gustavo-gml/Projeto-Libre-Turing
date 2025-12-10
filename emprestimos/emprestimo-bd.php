<?php
session_start();
require_once "../BD/conexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Captura dados
    $id_exemplar   = $_POST['id_exemplar'] ?? '';
    $ra_aluno      = $_POST['ra_aluno'] ?? '';
    $id_func       = $_POST['id_funcionario'] ?? '';
    $data_prevista = $_POST['data_devolucao'] ?? '';
    
    // Data atual (data do empréstimo)
    $data_hoje = date('Y-m-d');

    // 1. Validação da Data (Requisito do Usuário)
    if ($data_prevista < $data_hoje) {
        $_SESSION['message'] = "Erro: A data de devolução não pode ser anterior a hoje!";
        header("Location: ../pages/emprestimo.php");
        exit;
    }

    if (empty($id_exemplar) || empty($ra_aluno)) {
        $_SESSION['message'] = "Erro: Preencha todos os campos obrigatórios.";
        header("Location: ../pages/emprestimo.php");
        exit;
    }

    try {
        // Iniciamos uma transação para garantir que tudo ocorra ou nada ocorra
        $conexao->beginTransaction();

        // PASSO A: Inserir na tabela 'emprestimos'
        // Colunas baseadas na sua imagem: id_exemplar, id_funcionario, ra_aluno, data_emprestimo, data_prevista_devolucao
        $sqlInsert = "INSERT INTO emprestimos (id_exemplar, id_funcionario, ra_uno, data_emprestimo, data_prevista_devolucao) 
        VALUES (:exemplar, :func, :ra, :hoje, :prevista)"; 
      
        
        $sqlInsert = "INSERT INTO emprestimos (id_exemplar, id_funcionario, ra_aluno, data_emprestimo, data_prevista_devolucao) 
        VALUES (:exemplar, :func, :ra, :hoje, :prevista)";

        $stmt = $conexao->prepare($sqlInsert);
        $stmt->execute([
            ':exemplar' => $id_exemplar,
            ':func'     => $id_func,
            ':ra'       => $ra_aluno,
            ':hoje'     => $data_hoje,
            ':prevista' => $data_prevista
        ]);

        // PASSO B: Atualizar o status na tabela 'exemplares' para 'Emprestado'
        $sqlUpdate = "UPDATE exemplares SET status = 'Emprestado' WHERE id = :id";
        $stmtUpdate = $conexao->prepare($sqlUpdate);
        $stmtUpdate->execute([':id' => $id_exemplar]);

        // Se chegou até aqui, confirma as duas ações
        $conexao->commit();

        $_SESSION['message'] = "Empréstimo realizado com sucesso!";
        header("Location: ../pages/emprestimo.php");
        exit;

    } catch (PDOException $e) {
        // Se der erro, desfaz tudo
        $conexao->rollBack();
        $_SESSION['message'] = "Erro ao registrar empréstimo: " . $e->getMessage();
        header("Location: ../pages/emprestimo.php");
        exit;
    }
} else {
    header("Location: ../pages/emprestimo.php");
    exit;
}
?>