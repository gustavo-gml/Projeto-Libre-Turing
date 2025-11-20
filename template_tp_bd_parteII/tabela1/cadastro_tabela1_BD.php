<?php

require_once "..\BD\conexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
	$campo2  = $_POST['campo2'] ?? '';
	$campo3   = $_POST['campo3'] ?? '';
	$campo4  = $_POST['campo4'] ?? '';
	$campo5 = $_POST['campo5'] ?? '';
	try{
		$sql = "INSERT INTO tabela1 (campo2, campo3, campo4, campo5) VALUES (:campo2, :campo3, :campo4, :campo5)";
		$stmt = $conexao->prepare($sql);
		$stmt->execute([
			':campo2'  => $campo2,
			':campo3'   => $campo3,
			':campo4'  => $campo4,
			':campo5' => $campo5
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

