<?php
require_once "..\BD\conexaoBD.php";
if (isset($_GET['id_jogo'])) {
    $id = $_GET['id_jogo'];
    $stmt = $conexao->prepare("DELETE FROM jogos WHERE id_jogo = :id_jogo");
    $stmt->bindParam(':id_jogo', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        header("Location: consulta_jogos.php");
        exit;
    } else {
        echo "Erro ao excluir o registro.";
    }
} else {
    echo "ID não fornecido.";
}
?>
