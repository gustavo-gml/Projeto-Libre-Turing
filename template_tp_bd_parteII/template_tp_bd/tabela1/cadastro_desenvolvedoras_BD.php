<?php

require_once "..\BD\conexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
	
	$campo3   = $_POST['campo3'] ?? '';
	$campo4  = $_POST['campo4'] ?? '';
	
	try{
		$sql = "INSERT INTO desenvolvedoras
		( nome, pais) VALUES (:nome, :pais)";
		$stmt = $conexao->prepare($sql);
		$stmt->execute([
			':nome'   => $campo3,
			':pais'  => $campo4
			
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

