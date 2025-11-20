<?php
	require_once "../BD/conexaoBD.php";

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$id = $_POST['id'];
		$campo2  = $_POST['campo2'];
		$campo3   = $_POST['campo3'];
		$campo4  = $_POST['campo4'];
		$campo5 = $_POST['campo5'];
	

		$stmt = $conexao->prepare("UPDATE tabela2 SET campo2 = :campo2, 
		campo3 = :campo3, campo4 = :campo4, campo5 = :campo5 WHERE id = :id");
		$stmt->execute([
			':campo2' => $campo2,
			':campo3' => $campo3,
			':campo4' => $campo4,
			':campo5' => $campo5,
			':id' => $id
		]);

		header("Location: consulta_tabela2.php");
		exit;
	}

	if (isset($_GET['id'])) {
		$id = $_GET['id'];

		$stmt = $conexao->prepare("SELECT * FROM tabela2 WHERE id = :id");
		$stmt->execute([':id' => $id]);
		$registro = $stmt->fetch();

		if (!$registro) {
			echo "Registro não encontrado.";
			exit;
		}
	} else {
		echo "ID não fornecido.";
		exit;
	}
?>



<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Atualização de Registros</title>
  
</head>
<body>

  <main>
    <h1>Editar Registro</h1>

    <form method="POST">
	  <input type="hidden" name="id" value="<?= $registro['id'] ?>">
      <label for="campo2">Campo 2:</label>
      <input type="text" id="campo2" name="campo2" maxlength="20" required value="<?= htmlspecialchars($registro['campo2']) ?>"><br><br>

      <label for="campo3">Campo 3:</label>
      <input type="text" id="campo3" name="campo3" maxlength="20" value="<?= htmlspecialchars($registro['campo3']) ?>"><br><br>

      <label for="campo4">Campo 4:</label>
      <input type="text" id="campo4" name="campo4" maxlength="20" value="<?= htmlspecialchars($registro['campo4']) ?>"><br><br>

      <fieldset>
        <legend>Campo 5</legend>
        <label for="campo5">Campo 5:</label>
        <select id="campo5" name="campo5">
          <option value="Opção 1" <?= $registro['campo5'] === 'Opção 1' ? 'selected' : '' ?>>Opção 1</option>
          <option value="Opção 2" <?= $registro['campo5'] === 'Opção 2' ? 'selected' : '' ?>>Opção 2</option>
          <option value="Opção 3" <?= $registro['campo5'] === 'Opção 3' ? 'selected' : '' ?>>Opção 3</option>
          <option value="Opção 4" <?= $registro['campo5'] === 'Opção 4' ? 'selected' : '' ?>>Opção 4</option>
        </select>
      </fieldset><br><br>

      <button type="submit">Salvar alterações no registro</button>
    </form>
  </main>

</body>
</html>
