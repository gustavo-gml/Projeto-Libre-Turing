<?php
require_once "..\BD\conexaoBD.php";
if (isset($_GET['id_jogo'])) {
    $id = $_GET['id_jogo'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $titulo = $_POST['titulo'] ?? '';
        $genero = $_POST['genero'] ?? '';
        $ano_lancamento = $_POST['ano_lancamento'] ?? '';
        $sql = "UPDATE jogos SET titulo = :titulo, genero = :genero, ano_lancamento = :ano_lancamento WHERE id_jogo = :id_jogo";
        $stmt = $conexao->prepare($sql);
        if ($stmt->execute([
            ':titulo' => $titulo,
            ':genero' => $genero,
            ':ano_lancamento' => $ano_lancamento,
            ':id_jogo' => $id
        ])) {
            header("Location: consulta_jogos.php");
            exit;
        } else {
            echo "Erro ao editar o registro.";
        }
    } else {
        $stmt = $conexao->prepare("SELECT * FROM jogos WHERE id_jogo = :id_jogo");
        $stmt->execute([':id_jogo' => $id]);
        $jogo = $stmt->fetch();
        if ($jogo) {
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Jogo</title>
  <link rel="stylesheet" href="style_jogos.css">
</head>
<body>
  <main>
    <h1>Editar Jogo</h1>
    <form method="POST">
      <label for="titulo">Título:</label>
      <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($jogo['titulo']) ?>" maxlength="100" required><br><br>
      <label for="genero">Gênero:</label>
      <input type="text" id="genero" name="genero" value="<?= htmlspecialchars($jogo['genero']) ?>" maxlength="50" required><br><br>
      <label for="ano_lancamento">Ano de Lançamento:</label>
      <input type="number" id="ano_lancamento" name="ano_lancamento" value="<?= htmlspecialchars($jogo['ano_lancamento']) ?>" min="1970" max="2100" required><br><br>
      <button type="submit">Salvar Alterações</button>
    </form>
  </main>
</body>
</html>
<?php
        } else {
            echo "Jogo não encontrado.";
        }
    }
} else {
    echo "ID não fornecido.";
}
?>
