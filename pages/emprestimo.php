<?php
session_start();
if (isset($_SESSION['message'])) {
    $msg = addslashes($_SESSION['message']);
    echo "<script>alert('$msg');</script>";
    unset($_SESSION['message']);
}

require_once "../BD/conexaoBD.php";

// 1. CARREGA LIVROS DISPONÍVEIS (Para o datalist de livros)
try {
    $sqlLivros = "SELECT e.codigo_de_barras, l.titulo 
            FROM exemplares e
            INNER JOIN livros l ON e.id_livro = l.id
            WHERE e.status = 'Disponível'
            ORDER BY l.titulo ASC";
    $lista_livros = $conexao->query($sqlLivros)->fetchAll(PDO::FETCH_ASSOC);

    // 2. CARREGA ALUNOS (Para o datalist de alunos - ajuda na busca manual)
    $sqlAlunos = "SELECT ra, nome_aluno FROM alunos ORDER BY nome_aluno ASC";
    $lista_alunos = $conexao->query($sqlAlunos)->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $lista_livros = [];
    $lista_alunos = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empréstimo - Libre Turing</title>
    <link rel="stylesheet" href="../style.css">
    
    <style>
        .form-login input[type="text"], 
        .form-login input[type="date"],
        .form-login input[type="number"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .campo-bloqueado {
            background-color: #e9ecef;
            color: #495057;
            border-color: #ced4da;
            font-weight: bold;
        }
        .status-msg {
            font-size: 0.85em;
            margin-top: -15px;
            margin-bottom: 15px;
            font-weight: bold;
            min-height: 20px; /* Garante que o layout não pule */
        }
        .msg-erro { color: red; }
        .msg-sucesso { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <a href="menu.html" class="back-link">← Voltar ao Menu</a>
        
        <section id="emprestimo">
            <h2>Empréstimo de Livro</h2>
            <p>Preencha os dados do livro e do aluno.</p>
            
            <form class="form-login" action="../emprestimos/emprestimo-bd.php" method="POST" id="form-emprestimo">
                
                <label for="codigo_barras">Código de Barras ou Título:</label>
                <input type="text" id="codigo_barras" name="codigo_barras" list="lista-livros" 
                       placeholder="Bipe ou digite para buscar..." autocomplete="off" autofocus required>
                
                <datalist id="lista-livros">
                    <?php foreach ($lista_livros as $livro): ?>
                        <option value="<?= htmlspecialchars($livro['codigo_de_barras']) ?>">
                            <?= htmlspecialchars($livro['titulo']) ?>
                        </option>
                    <?php endforeach; ?>
                </datalist>
                
                <div id="msg-livro" class="status-msg"></div>

                <label>Título Confirmado:</label>
                <input type="text" id="titulo_livro" class="campo-bloqueado" placeholder="Aguardando livro..." readonly tabindex="-1">
                <input type="hidden" id="id_exemplar" name="id_exemplar">
                
                <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">

                <label for="ra_aluno">RA do Aluno:</label>
                <input type="text" id="ra_aluno" name="ra_aluno" list="lista-alunos" 
                       placeholder="Digite o RA ou Nome..." autocomplete="off" required>

                <datalist id="lista-alunos">
                    <?php foreach ($lista_alunos as $aluno): ?>
                        <option value="<?= htmlspecialchars($aluno['ra']) ?>">
                            <?= htmlspecialchars($aluno['nome_aluno']) ?>
                        </option>
                    <?php endforeach; ?>
                </datalist>

                <div id="msg-aluno" class="status-msg"></div>

                <label>Nome do Aluno:</label>
                <input type="text" id="nome_aluno_visual" class="campo-bloqueado" placeholder="Aguardando RA..." readonly tabindex="-1">


                <label for="id_funcionario">ID do Funcionário:</label>
                <input type="number" id="id_funcionario" name="id_funcionario" required>

                <label for="data_devolucao">Data Prevista de Devolução:</label>
                <input type="date" id="data_devolucao" name="data_devolucao" required>

                <button type="submit" id="btn-submit" disabled>Realizar Empréstimo</button>
            </form>
        </section>
    </div>

    <script>
        // --- ELEMENTOS DO LIVRO ---
        const inputCodigo = document.getElementById('codigo_barras');
        const inputTitulo = document.getElementById('titulo_livro');
        const inputIdHidden = document.getElementById('id_exemplar');
        const msgLivro = document.getElementById('msg-livro');

        // --- ELEMENTOS DO ALUNO ---
        const inputRa = document.getElementById('ra_aluno');
        const inputNomeAluno = document.getElementById('nome_aluno_visual');
        const msgAluno = document.getElementById('msg-aluno');

        const btnSubmit = document.getElementById('btn-submit');
        
        // Flags para controlar se tudo está validado
        let livroValido = false;
        let alunoValido = false;
        let timeout = null;

        // --- FUNÇÃO PARA VERIFICAR ESTADO DO BOTÃO ---
        function verificarBotao() {
            if (livroValido && alunoValido) {
                btnSubmit.disabled = false;
                btnSubmit.style.backgroundColor = "#28a745";
            } else {
                btnSubmit.disabled = true;
                btnSubmit.style.backgroundColor = "#ccc";
            }
        }

        // --- LÓGICA DO LIVRO (Igual anterior) ---
        inputCodigo.addEventListener('input', function() {
            const codigo = this.value;
            clearTimeout(timeout);
            livroValido = false;
            verificarBotao();
            
            if (codigo.length === 0) { 
                inputTitulo.value = ""; 
                inputIdHidden.value = ""; 
                msgLivro.textContent = ""; 
                return; 
            }

            timeout = setTimeout(() => { buscarLivro(codigo); }, 300);
        });

        function buscarLivro(codigo) {
            msgLivro.textContent = "Verificando...";
            msgLivro.className = "status-msg";
            msgLivro.style.color = "orange";

            fetch(`../emprestimos/busca-livro-ajax.php?codigo=${codigo}`)
                .then(r => r.json())
                .then(data => {
                    if (data.sucesso) {
                        inputTitulo.value = data.titulo;
                        inputIdHidden.value = data.id;
                        msgLivro.textContent = "✔ Livro Localizado";
                        msgLivro.className = "status-msg msg-sucesso";
                        msgLivro.style.color = "green";
                        livroValido = true;
                    } else {
                        inputTitulo.value = "";
                        msgLivro.textContent = "Livro não encontrado/indisponível";
                        msgLivro.className = "status-msg msg-erro";
                        msgLivro.style.color = "red";
                        livroValido = false;
                    }
                    verificarBotao();
                })
                .catch(err => console.error(err));
        }

        // --- LÓGICA DO ALUNO (Nova) ---
        inputRa.addEventListener('input', function() {
            const ra = this.value;
            clearTimeout(timeout);
            alunoValido = false;
            verificarBotao();

            if (ra.length === 0) {
                inputNomeAluno.value = "";
                msgAluno.textContent = "";
                return;
            }

            timeout = setTimeout(() => { buscarAluno(ra); }, 300);
        });

        function buscarAluno(ra) {
            msgAluno.textContent = "Buscando aluno...";
            msgAluno.className = "status-msg";
            msgAluno.style.color = "orange";

            fetch(`../emprestimos/busca-aluno-ajax.php?ra=${ra}`)
                .then(r => r.json())
                .then(data => {
                    if (data.sucesso) {
                        inputNomeAluno.value = data.nome;
                        msgAluno.textContent = "✔ Aluno Confirmado";
                        msgAluno.className = "status-msg msg-sucesso";
                        msgAluno.style.color = "green";
                        alunoValido = true;
                    } else {
                        inputNomeAluno.value = "";
                        msgAluno.textContent = "Aluno não encontrado";
                        msgAluno.className = "status-msg msg-erro";
                        msgAluno.style.color = "red";
                        alunoValido = false;
                    }
                    verificarBotao();
                })
                .catch(err => console.error(err));
        }
    </script>
</body>
</html>