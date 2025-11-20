<?php
	require_once "../BD/conexaoBD.php";

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$id = $_POST['id'];
		$fabricante = $_POST['campo4'];
		$tipo = $_POST['campo5'];
		$stmt = $conexao->prepare("UPDATE plataformas SET fabricante = :fabricante, tipo = :tipo WHERE id_plataforma = :id");
		$stmt->execute([
			':fabricante' => $fabricante,
			':tipo' => $tipo,
			':id' => $id
		]);
		header("Location: consulta_plataformas.php");
		exit;
	}

	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$stmt = $conexao->prepare("SELECT * FROM plataformas WHERE id_plataforma = :id");
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
  <title>Edição de Plataforma</title>
  
</head>
<body>

  <main>
    <h1>Editar Plataforma</h1>

    <form method="POST">
	  <input type="hidden" name="id" value="<?= $registro['id_plataforma'] ?>">

      <label for="campo4">Fabricante:</label>
      <input type="text" id="campo4" name="campo4" maxlength="20" value="<?= htmlspecialchars($registro['fabricante']) ?>"><br><br>
      <fieldset>
        <legend>Tipo</legend>
        <label for="campo5">Tipo:</label>
        <select id="campo5" name="campo5">
          <option value="Console" <?= $registro['tipo'] === 'Console' ? 'selected' : '' ?>>Console</option>
          <option value="PC" <?= $registro['tipo'] === 'PC' ? 'selected' : '' ?>>PC</option>
          <option value="Mobile" <?= $registro['tipo'] === 'Mobile' ? 'selected' : '' ?>>Mobile</option>
          <option value="Outro" <?= $registro['tipo'] === 'Outro' ? 'selected' : '' ?>>Outro</option>
        </select>
      </fieldset><br><br>

      <button type="submit">Salvar alterações</button>
    </form>
  </main>

</body>
</html>
