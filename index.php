<?php
session_start();
require_once "bd/conexaoBD.php"; // Caminho da raiz para a pasta bd

// Variável para mensagem de erro
$erro_login = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro_login = "Preencha todos os campos!";
    } else {
        try {
            // Busca o funcionário pelo Email
            $sql = "SELECT * FROM funcionarios WHERE email = :email LIMIT 1";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([':email' => $email]);
            $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se achou o funcionário E se a senha bate
            if ($funcionario && $funcionario['senha'] === $senha) {
                
                // Login Sucesso: Salva dados na sessão
                $_SESSION['usuario_id'] = $funcionario['id'];
                $_SESSION['usuario_nome'] = $funcionario['nome_funcionario'];
                
                // Redireciona para o menu
                header("Location: pages/menu.html");
                exit;
            } else {
                $erro_login = "E-mail ou senha incorretos!";
            }
        } catch (PDOException $e) {
            $erro_login = "Erro de conexão: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Libre Turing</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="images/favicon.ico">
</head>
<body>
    
    <?php if (!empty($erro_login)): ?>
        <script>
            alert("<?= addslashes($erro_login) ?>");
        </script>
    <?php endif; ?>

     <div class="container">
            <h2>Libre Turing - Login</h2>
        
            <form class="form-login" method="POST" action="">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Digite o seu email" required>

                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                
                <button type="submit">Entrar</button>
            </form>
    </div>
</body>
</html>