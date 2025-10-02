<?php 
	require_once "..\BD\conexaoBD.php";
	if (isset($_GET['id'])) {
		$id = $_GET['id'];

		$stmt = $conexao->prepare("DELETE FROM tabela1 WHERE id = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			header("Location: consulta_tabela1.php"); 
			exit;
		} else {
			echo "Erro ao excluir o registro.";
		}
	} else {
		echo "ID não fornecido.";
	}
?>

