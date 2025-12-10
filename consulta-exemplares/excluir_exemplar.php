<?php 
	require_once "../BD/conexaoBD.php";

	// Verifica se o ID foi passado na URL 
	if (isset($_GET['id'])) {
		$id = $_GET['id'];

		// Prepara o comando para deletar da tabela EXEMPLARES
		$stmt = $conexao->prepare("DELETE FROM exemplares WHERE id = :id");
		
		// Vincula o parâmetro :id com segurança (evita SQL Injection)
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);

		try {
			if ($stmt->execute()) {
				// Se deu certo, volta para a lista de exemplares
				header("Location: lista_completa.php"); 
				exit;
			} else {
				echo "Erro ao excluir o exemplar do banco de dados.";
			}
		} catch (PDOException $e) {
			// Captura erros, como tentar excluir algo que não existe ou erro de conexão
			echo "Erro no sistema: " . $e->getMessage();
		}
	} else {
		echo "ID do exemplar não fornecido.";
		echo "<br><a href='lista_completa.php'>Voltar</a>";
	}
?>