<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Consulta da Tabela 1</title>
  <link rel="stylesheet" href="../tabela2/style_plataformas.css">
  <style>
	table,th,td{
		border: 1px solid black;
		border-collapse: collapse;
	}
  </style>
  
</head>
<body>
<?php 
	require_once "..\BD\conexaoBD.php";
	$stmt = $conexao->query("SELECT * FROM desenvolvedoras");
	$registros = $stmt->fetchAll();
?>

  <main>
    <h1>Lista de Registros</h1>
	<table>
        <thead>
            <tr>
                <th>nome</th>
                <th>pais</th>
                <th>id</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registros as $r){ ?>
                <tr>
                    <td><?= htmlspecialchars($r['nome']) ?></td>
                    <td><?= htmlspecialchars($r['pais']) ?></td>
                    <td><?= htmlspecialchars($r['id_desenvolvedora']) ?></td>
                    <td>
                        <a href="editar_desenvolvedoras.php?id=<?= $r['id_desenvolvedora'] ?>">Editar</a>
                    </td>
                    <td>
                        <a href="excluir_desenvolvedoras.php?id_desenvolvedora=<?= $r['id_desenvolvedora'] ?>" onclick="return confirm('Tem certeza que deseja excluir este registro?');">Excluir</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
  </main>

</body>
</html>

