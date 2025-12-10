<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Lista de Exemplares</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php 
    require_once "../BD/conexaoBD.php";
    
    // O INNER JOIN junta a tabela exemplares (e) com livros (l)
    // Assim podemos pegar o 'titulo' do livro associado
    $sql = "SELECT * FROM view_acervo_completo ORDER BY nome_livro ASC";
    
    
    /*
    antes da view: 
    "SELECT e.*, l.titulo AS nome_livro, l.isbn 
    FROM exemplares e 
    INNER JOIN livros l ON e.id_livro = l.id 
    ORDER BY l.titulo ASC";*/
            
    $stmt = $conexao->query($sql);
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <h1>Acervo Completo (Exemplares)</h1>
    
    <div class="container-tabela">
    <table>
        <thead>
            <tr>
                <th>Cód. Barras</th>
                <th>Livro</th>
                <th>Status</th>
                <th>Data Aquisição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registros as $r){ ?>
                <tr>
                    <td><?= htmlspecialchars($r['codigo_de_barras']) ?></td>
                    <td><?= htmlspecialchars($r['nome_livro']) ?></td> 
                    <td><?= htmlspecialchars($r['status']) ?></td>
                    
                    <td><?= date('d/m/Y', strtotime($r['data_aquisicao'])) ?></td>
                    
                    <td>
                        <a class="editar" href="editar_exemplar.php?id=<?= $r['id_exemplar'] ?>">Editar</a>
                        <a class="excluir" href="excluir_exemplar.php?id=<?= $r['id_exemplar'] ?>" onclick="return confirm('Tem certeza que deseja remover este exemplar?');">Excluir</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>

    <div class="container-consulta">
        <a class="link-php" href="../pages/consulta-exemplares.html">+ Nova Consulta</a>
        <a class="link-php" href="../pages/menu.html">Voltar Para o Menu</a>
    </div>
</main>
</body>
</html>