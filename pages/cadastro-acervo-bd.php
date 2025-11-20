<?php

require_once "..\BD\conexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
	$registro_id = $_POST['id'] ?? '';
    $isbn   = $_POST['isbn'] ?? '';
    $nome   = $_POST['titulo'] ?? '';
	$data  = $_POST['cadastro-data-livro'] ?? '';
    $codigo  = $_POST['cadastro-codigo-livro'] ?? '';

	id	codigo_de_barras	id_livro	status	data_aquisicao	

	try{
		$sql = "INSERT INTO exemplares (nome,isbn , ) VALUES (:id, :campo2, :campo3)";
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

