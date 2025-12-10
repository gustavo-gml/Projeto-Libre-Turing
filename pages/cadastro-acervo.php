<?php
// 1. Inicia a sessão para verificar se o banco mandou alguma mensagem
session_start();

// 2. Se existir uma mensagem guardada, exibe o alerta e depois limpa a memória
if (isset($_SESSION['message'])) {
    $msg = $_SESSION['message'];
    // Escapa as aspas simples para não quebrar o JavaScript
    $msg_escapada = addslashes($msg); 
    echo "<script>alert('$msg_escapada');</script>";
    
    // Limpa a mensagem para ela não aparecer de novo se atualizar a página
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Exemplar - Libre Turing</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/png" href="../images/favicon.ico">
    
    <style>
        .form-login select, 
        .form-login input[type="date"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
            background-color: #fff;
            font-family: Arial, sans-serif; /* Garante a mesma fonte */
        }
    </style>
</head>
<body>
    <?php
    require_once "../BD/conexaoBD.php";
    
    // Busca os livros para preencher o select
    $registros = $conexao->query("SELECT id, isbn, titulo FROM livros ORDER BY titulo ASC")->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container">
        <a href="cadastro-livro.html" class="back-link">← Voltar</a>
        
        <section id="cadastro-exemplar">
            <h2>Cadastro de Exemplar</h2>
            <p>Adicione uma nova unidade física ao acervo.</p>

            <form class="form-login" action="../cadastro-acervo/cadastro-acervo-bd.php" method="POST">
           
                <label for="cadastro-isbn-livro">Livro (Título - ISBN)</label>
                <select id="cadastro-isbn-livro" name="cadastro-isbn-livro" required>
                    <option value="" disabled selected>Selecione um livro...</option>
                    <?php foreach ($registros as $registro){ ?>
                        <option value="<?= $registro['id'] ?>">
                            <?= htmlspecialchars($registro['titulo']) . ' - ' . htmlspecialchars($registro['isbn']) ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="cadastro-codigo-livro">Código de Barras</label>
                <input type="text" id="cadastro-codigo-livro" name="cadastro-codigo-livro" placeholder="Ex: 2025001" required>

                <label for="cadastro-data-livro">Data de Aquisição</label>
                <input type="date" id="cadastro-data-livro" name="cadastro-data-livro" required>

                <button type="submit">Finalizar Cadastro</button>
                
            </form>
        </section>
    </div>
</body>
</html>