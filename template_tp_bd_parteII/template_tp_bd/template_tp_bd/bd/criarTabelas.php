<?php
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_jogos_tpi';

try 
{
    $dsn = "mysql:host=$servidor;dbname=$banco;charset=utf8"; 
    $conexao = new PDO($dsn, $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "
        CREATE TABLE IF NOT EXISTS desenvolvedoras (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_desenvolvedora VARCHAR(20) NOT NULL,
            nome VARCHAR(20),
            pais VARCHAR(20)
        )
    ";
    $conexao->exec($sql);
    echo "Tabela 'desenvolvedoras' criada com sucesso (ou já existia).<br>";

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
    echo "Tabela 'tabela3' criada com sucesso (ou já existia).<br>";

    $sql = "
        CREATE TABLE IF NOT EXISTS jogos (
            id_jogo INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(100) NOT NULL,
            genero VARCHAR(50) NOT NULL,
            ano_lancamento INT
        );
    ";
    $conexao->exec($sql);
    echo "Tabela 'jogos' criada com sucesso (ou já existia).<br>";


} catch (PDOException $e) {
    echo "Erro ao criar a tabela: " . $e->getMessage();
}
?>

