<?php
session_start();
// Alerta de sucesso/erro vindo do backend
if (isset($_SESSION['message'])) {
    $msg = addslashes($_SESSION['message']);
    echo "<script>alert('$msg');</script>";
    unset($_SESSION['message']);
}

require_once "../BD/conexaoBD.php";

// SQL: Carrega TODOS os empréstimos
// Ordenação: Pendentes no topo, depois organizados pela data prevista
$sql = "SELECT emp.*, l.titulo, a.nome_aluno, a.ra 
        FROM emprestimos emp
        INNER JOIN exemplares e ON emp.id_exemplar = e.id
        INNER JOIN livros l ON e.id_livro = l.id
        INNER JOIN alunos a ON emp.ra_aluno = a.ra 
        ORDER BY (emp.data_devolucao IS NULL) DESC, emp.data_prevista_devolucao ASC";

$stmt = $conexao->prepare($sql);
$stmt->execute();
$emprestimos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Empréstimos - Libre Turing</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/png" href="../images/favicon.ico">
    <style>html {
    /* Reserva o espaço da barra, evitando o pulo */
    scrollbar-gutter: stable;
}</style>
</head>
<body>
    <div class="container" style="max-width: 900px;">
        <a href="menu.html" class="back-link">← Voltar ao Menu</a>
        
        <section id="consulta-emprestimos">
            <h2>Gerenciamento de Empréstimos</h2>
            <p>Filtre por RA, Nome ou Livro em tempo real.</p>
            
            <form class="form-login" onsubmit="return false;">
               <div class="search-wrapper">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="inputBusca" placeholder="Comece a digitar para filtrar..." autocomplete="off">
                </div>
            </form>

            <div class="container-tabela">
                <table id="tabela-emprestimos">
                    <thead>
                        <tr>
                            <th>Livro</th>
                            <th>Aluno (RA)</th>
                            <th>Data Prevista</th>
                            <th>Status / Devolução</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($emprestimos) > 0): ?>
                            <?php foreach ($emprestimos as $emp): ?>
                                <tr class="linha-tabela">
                                    
                                    <td><?= htmlspecialchars($emp['titulo']) ?></td>
                                    
                                    <td>
                                        <?= htmlspecialchars($emp['nome_aluno']) ?> <br>
                                        <small><?= htmlspecialchars($emp['ra']) ?></small>
                                    </td>
                                    
                                    <td><?= date('d/m/Y', strtotime($emp['data_prevista_devolucao'])) ?></td>

                                    <td>
                                        <?php if ($emp['data_devolucao'] == null): ?>
                                            <?php if (date('Y-m-d') > $emp['data_prevista_devolucao']): ?>
                                                <span class="status-pendente">ATRASADO</span>
                                            <?php else: ?>
                                                <span class="status-aberto">Em Aberto</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="status-concluido">Devolvido:<br>
                                            <?= date('d/m/Y', strtotime($emp['data_devolucao'])) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($emp['data_devolucao'] == null): ?>
                                            <a href="../gerenciar-emprestimos/acoes_emprestimo.php?acao=devolver&id=<?= $emp['id'] ?>" 
                                               class="btn-acao btn-devolver"
                                               onclick="return confirm('Confirmar a devolução deste livro?');">
                                               Devolver
                                            </a>
                                        <?php endif; ?>

                                        <a href="../gerenciar-emprestimos/acoes_emprestimo.php?acao=excluir&id=<?= $emp['id'] ?>" 
                                           class="btn-acao btn-excluir"
                                           onclick="return confirm('ATENÇÃO: Isso apagará o registro do histórico permanentemente. Continuar?');">
                                           Excluir
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align:center">Nenhum registro encontrado no sistema.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <p id="msg-sem-resultado" style="display:none; text-align:center; margin-top:20px; color:#666;">
                    Nenhum empréstimo corresponde à sua busca.
                </p>
            </div>
                
        </section>
    </div>

    <script>
        const inputBusca = document.getElementById('inputBusca');
        const linhas = document.querySelectorAll('.linha-tabela');
        const msgSemResultado = document.getElementById('msg-sem-resultado');

        inputBusca.addEventListener('input', function() {
            const termo = this.value.toLowerCase();
            let visiveis = 0;

            linhas.forEach(linha => {
                // Pega todo o texto da linha e converte para minúsculo
                const textoLinha = linha.textContent.toLowerCase();

                // Verifica se o termo digitado existe nessa linha
                if (textoLinha.includes(termo)) {
                    linha.style.display = ""; // Mostra (reseta o display)
                    visiveis++;
                } else {
                    linha.style.display = "none"; // Esconde
                }
            });

            // Se não sobrou nenhuma linha visível, mostra mensagem
            if (visiveis === 0) {
                msgSemResultado.style.display = "block";
            } else {
                msgSemResultado.style.display = "none";
            }
        });
    </script>
</body>
</html>