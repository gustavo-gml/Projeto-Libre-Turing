<?php

require_once "..\BD\conexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	$nome  = $_POST['nome'] ?? '';
	$fabricante  = $_POST['fabricante'] ?? '';
	$tipo  = $_POST['tipo'] ?? '';
	
	try{
	$sql = "INSERT INTO plataformas (nome, fabricante, tipo) VALUES (:nome, :fabricante, :tipo)";
		$stmt = $conexao->prepare($sql);
		$stmt->execute([
			':nome'  => $nome,
			':fabricante'  => $fabricante,
			':tipo'  => $tipo
			
		]);

		echo "<p>Registro cadastrado com sucesso!</p>";
	} catch (PDOException $e) {
    echo "Erro ao cadastrar: " . $e->getMessage();
	}
}

else {
	echo "<p>Requisição inválida.</p>";
} 	

?>

