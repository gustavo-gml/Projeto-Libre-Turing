<?php
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'bd_trabalho';

try 
{
    $dsn = "mysql:host=$servidor;dbname=$banco;charset=utf8"; 
    $conexao = new PDO($dsn, $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "
        CREATE TABLE IF NOT EXISTS tabela1 (
            id INT AUTO_INCREMENT PRIMARY KEY,
            campo2 VARCHAR(20) NOT NULL,
            campo3 VARCHAR(20),
            campo4 VARCHAR(20),
            campo5 VARCHAR(15)
        )
    ";
    $conexao->exec($sql);
    echo "Tabela 'tabela1' criada com sucesso (ou já existia).<br>";

    $sql = "
        CREATE TABLE IF NOT EXISTS tabela2 (
            id INT AUTO_INCREMENT PRIMARY KEY,
            campo2 VARCHAR(100) NOT NULL,
            campo3 VARCHAR(150) NOT NULL,
            campo4 VARCHAR(20),
            campo5 TEXT
        );
    ";
    $conexao->exec($sql);
    echo "Tabela 'tabela2' criada com sucesso (ou já existia).<br>";

    // Parte nova: Criação da tabela3 com chave estrangeira referenciando tabela1
    $sql = "
        CREATE TABLE IF NOT EXISTS tabela3 (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_tabela1 INT NOT NULL,
            campo2 VARCHAR(50) NOT NULL,
            campo3 VARCHAR(100),
            FOREIGN KEY (id_tabela1) REFERENCES tabela1(id)
                ON DELETE CASCADE
                ON UPDATE CASCADE
        )
    ";
    $conexao->exec($sql);
    echo "Tabela 'tabela3' criada com sucesso (ou já existia).<br>";

} catch (PDOException $e) {
    echo "Erro ao criar a tabela: " . $e->getMessage();
}
?>

