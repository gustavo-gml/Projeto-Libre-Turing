<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro - Tabela 3</title>
  
</head>
<body>

  <main>
    <h1>Cadastro da Tabela 3</h1>

<?php
	require_once "../BD/conexaoBD.php";

	$registros = $conexao->query("SELECT id, campo2 FROM tabela1")->fetchAll(PDO::FETCH_ASSOC);
?>

    <form action="cadastro_tabela3_BD.php" method="POST">
		<label for="registro">Escolha o registro:</label>
		<select name="registro" required>
			<?php foreach ($registros as $registro){ ?>
				<option value="<?= $registro['id'] ?>"><?= htmlspecialchars($registro['campo2']) ?></option>
			<?php } ?>
		</select><br>
		
		<label for="campo2">Campo 2</label>
        <input type="text" id="campo2" name="campo2" maxlength="50" required><br><br>

        <label for="campo3">Campo 3:</label>
        <input type="text" id="campo3" name="campo3" maxlength="100"><br><br>

      

      <button type="submit">Cadastrar Registro</button>
    </form>
  </main>

</body>
</html>