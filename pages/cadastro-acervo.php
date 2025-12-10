<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Exemplar - Libre Turing</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/png" href="../images/favicon.ico">
</head>
<body>
    <?php
	require_once "../BD/conexaoBD.php";

	$registros = $conexao->query("SELECT id, isbn, titulo FROM livros ")->fetchAll(PDO::FETCH_ASSOC);
?>
    <div class="container">
        <a href="cadastro-livro.html" class="back-link">← Voltar</a>
        <section id="cadastro-livro">
            <h2>Cadastro de Livro</h2>
            <p>Adicione um novo livro ao acervo da biblioteca.</p>
            <form class="form-login" action="cadastro-acervo-bd.php" method="POST">
           
            <label for="cadastro-isbn-livro">Nome do Livro:</label>
            <select name="cadastro-isbn-livro" required>
			<?php foreach ($registros as $registro){ ?>
				<option value="<?= $registro['id'] ?>"><?= htmlspecialchars($registro['titulo']) . ' - ' . htmlspecialchars($registro['isbn']) ?></option>
			<?php } ?>
		</select><br>

                <label for="cadastro-codigo-livro">Código de Barras do Livro</label>
                <input type="text" id="cadastro-codigo-livro" name="cadastro-codigo-livro" placeholder="Informe o código de barras do livro" required>

                <label for="cadastro-data-livro">Data de aquisição do Livro</label>
                <input type="date" id="cadastro-data-livro" name="cadastro-data-livro" placeholder="Informe a data de aquisição do livro" required>


                <button type="submit">Cadastrar Livro</button>

                
            </form>
        </section>
    </div>
</body>
</html>