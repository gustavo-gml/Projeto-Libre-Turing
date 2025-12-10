<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Consulta de Exemplares</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php 
    require_once "../BD/conexaoBD.php";

    // 1. Pega o termo digitado no formulário
    // O nome do input no seu HTML é 'consulta-livro'
    $termo_busca = $_POST['consulta-livro'] ?? '';

    // 2. Prepara a busca
    // Usamos INNER JOIN para buscar pelo Nome do Livro (tabela livros)
    // OU pelo Código de Barras (tabela exemplares)
    $sql = "SELECT e.*, l.titulo AS nome_livro, l.isbn 
            FROM exemplares e
            INNER JOIN livros l ON e.id_livro = l.id
            WHERE l.titulo LIKE :termo OR e.codigo_de_barras LIKE :termo";
            
    $stmt = $conexao->prepare($sql);
    
    // Adicionamos os % para buscar em qualquer parte do texto
    $stmt->execute([':termo' => "%$termo_busca%"]); 
    
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <h1>Resultados para: "<?= htmlspecialchars($termo_busca) ?>"</h1>
    
    <?php if (count($registros) > 0): ?>
        <div class="container-tabela">
        <table>
            <thead>
                <tr>
                    <th>Cód. Barras</th>
                    <th>Livro</th>
                    <th>ISBN</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $r){ ?>
                    <tr>
                        <td><?= htmlspecialchars($r['codigo_de_barras']) ?></td>
                        <td><?= htmlspecialchars($r['nome_livro']) ?></td>
                        <td><?= htmlspecialchars($r['isbn']) ?></td>
                        <td><?= htmlspecialchars($r['status']) ?></td>
                        <td>
                            <a class="editar" href="editar_exemplar.php?id=<?= $r['id'] ?>">Editar</a>
                            <a class="excluir" href="excluir_exemplar.php?id=<?= $r['id'] ?>" onclick="return confirm('Tem certeza?');">Excluir</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
    <?php else: ?>
        <p style="text-align: center; margin-top: 20px;">Nenhum exemplar encontrado com esse termo.</p>
    <?php endif; ?>
    
    <div class="container-consulta">
        <a class="link-php" href="../pages/consulta-exemplares.html">+ Nova Consulta</a>
        
        <a class="link-php" href="../pages/menu.html">Voltar para o menu</a>
    </div>

</main>
</body>
</html>