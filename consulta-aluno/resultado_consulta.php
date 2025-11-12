<?php 
    require_once "..\BD\conexaoBD.php";

    $termo_busca = $_POST['consulta-nome-aluno'] ?? '';

    $parametro_sql = $termo_busca . "%"; 

    $sql = "SELECT * FROM alunos WHERE nome_aluno LIKE ? ORDER BY nome_aluno ASC";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([$parametro_sql]); 
    
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resultado da Consulta de Alunos</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/png" href="../images/favicon.ico">
</head>
<body>
<main> <h1>Resultados para o nome: "<?= htmlspecialchars($termo_busca) ?>"</h1>
    
    <?php if (count($registros) > 0): ?>
        <div class="container-tabela">
            <table>
                <thead>
                    <tr>
                        <th>RA</th>
                        <th>Nome do Aluno</th>
                        <th>CPF</th>
                        <th>Nasc.</th>
                        <th>Curso</th>
                        <th>Email</th>
                        <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $r){ ?>
                        <tr>
                            <td><?= htmlspecialchars($r['ra']) ?></td>
                            <td><?= htmlspecialchars($r['nome_aluno']) ?></td>
                            <td><?= htmlspecialchars($r['cpf']) ?></td>
                            <td><?= date_create($r['data_nasc'])->format('d/m/Y') ?></td>
                            <td><?= htmlspecialchars($r['curso']) ?></td>
                            <td><?= htmlspecialchars($r['email']) ?></td>
                            <td><?= htmlspecialchars($r['telefone']) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class = "container-consulta">
            <a class="link-php" href="../pages/consulta-usuario.html">+ Nova Consulta</a>
            <a class="link-php" href="../pages/menu.html">Voltar Para o Menu</a>
        </div>
    <?php else: ?>
        <p>Nenhum aluno encontrado com esse nome.</p>
        <div class = "container-consulta">
            <a class="link-php" href="../pages/consulta-usuario.html">+ Nova Consulta</a>
            <a class="link-php" href="../pages/menu.html">Voltar para o Menu</a>
        </div>
    <?php endif; ?>

</main>
</body>
</html>