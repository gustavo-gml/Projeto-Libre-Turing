<?php 
require_once "..\BD\conexaoBD.php";
$stmt = $conexao->query("SELECT * FROM jogos");
$jogos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Consulta de Jogos</title>
  <link rel="stylesheet" href="style_jogos.css">
  <style>
    table,th,td{
      border: 1px solid black;
      border-collapse: collapse;
    }
  </style>
</head>
<body>
  <main>
    <h1>Lista de Jogos</h1>
    <table>
        <thead>
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Gênero</th>
        <th>Ano de Lançamento</th>
        <th>Editar</th>
        <th>Excluir</th>
      </tr>
        </thead>
        <tbody>
            <?php foreach ($jogos as $jogo){ ?>
        <tr>
          <td><?= htmlspecialchars($jogo['id_jogo']) ?></td>
          <td><?= htmlspecialchars($jogo['titulo']) ?></td>
          <td><?= htmlspecialchars($jogo['genero']) ?></td>
          <td><?= htmlspecialchars($jogo['ano_lancamento']) ?></td>
          <td>
            <a href="editar_jogos.php?id_jogo=<?= $jogo['id_jogo'] ?>">Editar</a>
          </td>
          <td>
            <a href="excluir_jogos.php?id_jogo=<?= $jogo['id_jogo'] ?>" onclick="return confirm('Tem certeza que deseja excluir este registro?');">Excluir</a>
          </td>
        </tr>
            <?php } ?>
        </tbody>
    </table>
  </main>
</body>
</html>
