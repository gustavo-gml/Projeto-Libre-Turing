<?php 
	require_once "..\BD\conexaoBD.php";
	if (isset($_GET['id_desenvolvedora'])) {
		$id = $_GET['id_desenvolvedora'];

		$stmt = $conexao->prepare("DELETE FROM desenvolvedoras WHERE id_desenvolvedora = :id_desenvolvedora");
		$stmt->bindParam(':id_desenvolvedora', $id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			header("Location: consulta_desenvolvedoras.php"); 
			exit;
		} else {
			echo "Erro ao excluir o registro.";
		}
	} else {
		echo "ID não fornecido.";
	}
?>

