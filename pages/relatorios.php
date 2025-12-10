<?php
require_once "../BD/conexaoBD.php";

// Usa COUNT (Agregação) e GROUP BY
$sql = "SELECT l.titulo, COUNT(e.id) as total_exemplares 
        FROM livros l
        LEFT JOIN exemplares e ON l.id = e.id_livro
        GROUP BY l.id, l.titulo
        ORDER BY total_exemplares DESC";

$dados = $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// OUTRA AGREGAÇÃO: Total geral de livros (COUNT simples)
$totalGeral = $conexao->query("SELECT COUNT(*) as total FROM exemplares")->fetch()['total'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatórios - Libre Turing</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <a href="menu.html" class="back-link">← Voltar ao Menu</a>
        <h2>Relatório de Acervo</h2>
        
        <p><strong>Total de Exemplares na Biblioteca:</strong> <?= $totalGeral ?></p>

        <div class="container-tabela">
            <table>
                <thead>
                    <tr>
                        <th>Título do Livro</th>
                        <th>Qtd. Exemplares</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados as $linha): ?>
                    <tr>
                        <td><?= htmlspecialchars($linha['titulo']) ?></td>
                        <td><?= $linha['total_exemplares'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>