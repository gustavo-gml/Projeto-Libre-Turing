<?php 
require_once "..\BD\conexaoBD.php";
$stmt = $conexao->query("SELECT * FROM plataformas");
$registros = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Consulta de Plataformas</title>
  <link rel="stylesheet" href="style_plataformas.css">
  <style>
    table,th,td{
      border: 1px solid black;
      border-collapse: collapse;
    }
  </style>
</head>
<body>
  <main>
    <h1>Lista de Plataformas</h1>
    <table>
        <thead>
      <tr>
        <th>Nome</th>
        <th>Fabricante</th>
        <th>Tipo</th>
        <th>ID</th>
        <th>Editar</th>
        <th>Excluir</th>
      </tr>
        </thead>
        <tbody>
            <?php foreach ($registros as $r){ ?>
        <tr>
          <td><?= isset($r['nome']) ? htmlspecialchars($r['nome']) : '<span style="color:red">(vazio)</span>' ?></td>
          <td><?= isset($r['fabricante']) ? htmlspecialchars($r['fabricante']) : '<span style="color:red">(vazio)</span>' ?></td>
          <td><?= isset($r['tipo']) ? htmlspecialchars($r['tipo']) : '<span style="color:red">(vazio)</span>' ?></td>
          <td><?= htmlspecialchars($r['id_plataforma']) ?></td>
          <td>
            <a href="editar_plataformas.php?id_plataforma=<?= $r['id_plataforma'] ?>">Editar</a>
          </td>
          <td>
            <a href="excluir_plataformas.php?id_plataforma=<?= $r['id_plataforma'] ?>" onclick="return confirm('Tem certeza que deseja excluir este registro?');">Excluir</a>
          </td>
        </tr>
            <?php } ?>
        </tbody>
    </table>
  </main>
</body>
</html>

