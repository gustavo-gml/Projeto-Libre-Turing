<?php
require_once "..\BD\conexaoBD.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $ano_lancamento = $_POST['ano_lancamento'] ?? '';
    try {
        $sql = "INSERT INTO jogos (titulo, genero, ano_lancamento) VALUES (:titulo, :genero, :ano_lancamento)";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':genero' => $genero,
            ':ano_lancamento' => $ano_lancamento
        ]);
        echo "<p>Jogo cadastrado com sucesso!</p>";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
} else {
    echo "<p>Requisição inválida.</p>";
}
?>
