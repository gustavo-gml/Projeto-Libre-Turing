<?php
require_once "..\BD\conexaoBD.php";

// 1. Processamento do Formulário (Salvar)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    // NÃO pegamos o id_livro aqui, pois não vamos alterá-lo
    $codigo   = $_POST['cadastro-codigo-livro'];
    $status   = $_POST['cadastro-status-livro'];
    $data     = $_POST['cadastro-data-livro'];

    if (!$id || !$codigo) {
        die("ERRO: ID ou Código estão vazios.");
    }
    // SQL sem a coluna id_livro
    $sql = "UPDATE exemplares SET 
            codigo_de_barras = :codigo, 
            status = :status, 
            data_aquisicao = :data 
            WHERE id = :id";
            
   try {
        $stmt = $conexao->prepare($sql);
        $resultado = $stmt->execute([
            ':codigo'   => $codigo,
            ':status'   => $status,
            ':data'     => $data,
            ':id'       => $id
        ]);

        if ($resultado) {
            header("Location: lista_completa.php");
            exit;
        } else {
            echo "Erro ao atualizar o registro.";
        }

    } catch (PDOException $e) {
        die("ERRO SQL: " . $e->getMessage());
    }
}

// 2. Carregar dados
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Precisamos do JOIN aqui também para exibir o Nome/ISBN na tela de edição
    $sql = "SELECT e.*, l.titulo AS nome_livro, l.isbn 
            FROM exemplares e
            INNER JOIN livros l ON e.id_livro = l.id
            WHERE e.id = :id";
            
    $stmt = $conexao->prepare($sql);
    $stmt->execute([':id' => $id]);
    $exemplar = $stmt->fetch();

    if (!$exemplar) { die("Exemplar não encontrado."); }

} else {
    die("ID não fornecido.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Exemplar</title>
  <link rel="stylesheet" href="../style.css">
  <style>
      /* CSS para fazer a DIV parecer um INPUT desativado */
      .campo-fixo {
          width: 100%;             /* Ocupa a mesma largura dos inputs */
          box-sizing: border-box;  /* Garante que o padding não estoure a largura */
          background-color: #e9ecef; /* Cinza claro para indicar que não é editável */
          padding: 10px;           /* Mesmo espaçamento interno dos inputs */
          border: 1px solid #ccc;  /* Mesma borda dos inputs */
          border-radius: 4px;      /* Arredondamento igual */
          margin-top: 5px;         
          margin-bottom: 15px;     /* Espaçamento inferior igual ao dos inputs */
          color: #495057;          /* Cor do texto escura */
          font-family: inherit;    /* Mesma fonte do resto da página */
          font-size: 14px;         /* Tamanho de fonte padrão */
      }

      /* Pequeno ajuste para garantir que os labels fiquem alinhados */
      label {
          display: block;
          margin-bottom: 5px;
          font-weight: bold;
      }
      
      /* Ajuste nos inputs para garantir consistência */
      input[type="text"], 
      input[type="date"], 
      select {
          width: 100%;
          box-sizing: border-box;
          padding: 10px;
          margin-bottom: 15px;
          border: 1px solid #ccc;
          border-radius: 4px;
      }
  </style>
</head>
<body>
<main>
    <h1>Editar Exemplar</h1>
    <div class="container">
        <a href="lista_completa.php" class="back-link" style="color: #000000ff;">← Cancelar Edição</a>
        
        <form class="form-login" method="POST">
            <input type="hidden" name="id" value="<?= $exemplar['id'] ?>">

            <label>Livro:</label>
            <div class="campo-fixo">
                <?= htmlspecialchars($exemplar['nome_livro']) ?>
            </div>

            <label>ISBN:</label>
            <div class="campo-fixo">
                <?= htmlspecialchars($exemplar['isbn']) ?>
            </div>

            <label for="cadastro-codigo-livro">Código de Barras:</label>
            <input type="text" id="cadastro-codigo-livro" name="cadastro-codigo-livro" 
                   value="<?= htmlspecialchars($exemplar['codigo_de_barras']) ?>" required>

            <label for="cadastro-status-livro">Status:</label>
            <select id="cadastro-status-livro" name="cadastro-status-livro">
                <option value="Disponível" <?= ($exemplar['status'] == 'Disponível') ? 'selected' : '' ?>>Disponível</option>
                <option value="Emprestado" <?= ($exemplar['status'] == 'Emprestado') ? 'selected' : '' ?>>Emprestado</option>
                <option value="Manutenção" <?= ($exemplar['status'] == 'Manutenção') ? 'selected' : '' ?>>Manutenção</option>
                <option value="Perdido"    <?= ($exemplar['status'] == 'Perdido') ? 'selected' : '' ?>>Perdido</option>
            </select>

            <label for="cadastro-data-livro">Data de Aquisição:</label>
            <input type="date" id="cadastro-data-livro" name="cadastro-data-livro" 
                   value="<?= $exemplar['data_aquisicao'] ?>" required>

            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</main>
</body>
</html>