<?php 
	require_once "..\BD\conexaoBD.php";
	if (isset($_GET['id_plataforma'])) {
		$id = $_GET['id_plataforma'];

		$stmt = $conexao->prepare("DELETE FROM plataformas WHERE id_plataforma = :id_plataforma");
		$stmt->bindParam(':id_plataforma', $id, PDO::PARAM_INT);

		if ($stmt->execute()) {
			header("Location: consulta_plataformas.php"); 
			exit;
		} else {
			echo "Erro ao excluir o registro.";
		}
	} else {
		echo "ID não fornecido.";
	}
?>

