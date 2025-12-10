<?php
session_start();
require_once "../BD/conexaoBD.php";

$acao = $_GET['acao'] ?? '';
$id   = $_GET['id'] ?? '';

if (empty($id)) {
    header("Location: ../pages/gerenciar_emprestimos.php");
    exit;
}

try {
    // === LÓGICA DE DEVOLUÇÃO ===
    if ($acao === 'devolver') {
        
        // 1. Descobrir qual é o exemplar desse empréstimo
        $stmtGet = $conexao->prepare("SELECT id_exemplar FROM emprestimos WHERE id = :id");
        $stmtGet->execute([':id' => $id]);
        $emprestimo = $stmtGet->fetch(PDO::FETCH_ASSOC);

        if ($emprestimo) {
            $conexao->beginTransaction();

            // 2. Atualiza a data de devolução para HOJE
            $sqlEmp = "UPDATE emprestimos SET data_devolucao = CURDATE() WHERE id = :id";
            $stmtEmp = $conexao->prepare($sqlEmp);
            $stmtEmp->execute([':id' => $id]);

            // 3. Libera o livro (Status = Disponível)
            $sqlEx = "UPDATE exemplares SET status = 'Disponível' WHERE id = :id_exemplar";
            $stmtEx = $conexao->prepare($sqlEx);
            $stmtEx->execute([':id_exemplar' => $emprestimo['id_exemplar']]);

            $conexao->commit();
            $_SESSION['message'] = "Livro devolvido com sucesso!";
        }
    }

    // === LÓGICA DE EXCLUSÃO ===
    elseif ($acao === 'excluir') {
        
        // Antes de apagar, precisamos liberar o livro caso ele ainda conste como emprestado
        $stmtGet = $conexao->prepare("SELECT id_exemplar, data_devolucao FROM emprestimos WHERE id = :id");
        $stmtGet->execute([':id' => $id]);
        $emprestimo = $stmtGet->fetch(PDO::FETCH_ASSOC);

        if ($emprestimo) {
            $conexao->beginTransaction();

            // Se ainda não foi devolvido, libera o livro antes de apagar o registro
            if ($emprestimo['data_devolucao'] == null) {
                $sqlEx = "UPDATE exemplares SET status = 'Disponível' WHERE id = :id_exemplar";
                $stmtEx = $conexao->prepare($sqlEx);
                $stmtEx->execute([':id_exemplar' => $emprestimo['id_exemplar']]);
            }

            // Apaga o registro do empréstimo
            $sqlDel = "DELETE FROM emprestimos WHERE id = :id";
            $stmtDel = $conexao->prepare($sqlDel);
            $stmtDel->execute([':id' => $id]);

            $conexao->commit();
            $_SESSION['message'] = "Registro de empréstimo apagado!";
        }
    }

} catch (Exception $e) {
    $conexao->rollBack();
    $_SESSION['message'] = "Erro ao processar: " . $e->getMessage();
}

// Volta para a lista
header("Location: ../pages/gerenciar-emprestimos.php");
exit;
?>