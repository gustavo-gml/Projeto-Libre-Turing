<?php

require_once "..\BD\conexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
	$registro_id = $_POST['registro'] ?? '';
	$campo2  = $_POST['campo2'] ?? '';
	$campo3   = $_POST['campo3'] ?? '';
	try{
		$sql = "INSERT INTO tabela3 (id_tabela1, campo2, campo3) VALUES (:id, :campo2, :campo3)";
		$stmt = $conexao->prepare($sql);
		$stmt->execute([
			':id' => $registro_id,
			':campo2'  => $campo2,
			':campo3'   => $campo3
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

