<?php

require_once "..\BD\conexaoBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
	$cnl  = $_POST['cadastro-nome-livro'] ?? '';
	$cil   = $_POST['cadastro-isbn-livro'] ?? '';
	$cal  = $_POST['cadastro-autor-livro'] ?? '';
	$ccl = $_POST['cadastro-categoria-livro'] ?? '';
	$cyl = $_POST['cadastro-ano-livro'] ?? '';
	try{
		$sql = "INSERT INTO livros (isbn, titulo, autor, categoria, ano) VALUES (:cil, :cnl, :cal, :ccl, :cyl)";
		$stmt = $conexao->prepare($sql);
		$stmt->execute([
			':cil' => $cil,
            ':cnl' => $cnl,
            ':cal' => $cal,
            ':ccl' => $ccl,
            ':cyl' => $cyl
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

