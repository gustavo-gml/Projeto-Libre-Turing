# Libre Turing - Sistema de Gerenciamento de Biblioteca

`Libre Turing` é um projeto acadêmico de sistema de gerenciamento para bibliotecas, desenvolvido para a disciplina de **Banco de Dados 1** do curso de **Sistemas de Informação**. O sistema é implementado em PHP e MySQL, focando na manipulação de dados relacionais, integridade referencial e experiência do usuário (UX) com atualizações assíncronas.

## 👨‍💻 Equipe

* Agabo Monteiro
* Gustavo Martins
* José Gabriel
* Tiago Lemes

## ✨ Funcionalidades Implementadas

O projeto evoluiu e agora conta com um fluxo completo de automação de biblioteca:

### 🔐 Controle de Acesso
* **Login de Funcionários:** Sistema de autenticação que verifica credenciais na tabela de funcionários antes de liberar o acesso ao menu principal.

### 📚 Gestão de Acervo (Livros e Exemplares)
* **Cadastro de Títulos:** Registro das informações bibliográficas (ISBN, Autor, Categoria).
* **Gestão de Exemplares (Físicos):**
    * Cadastro de múltiplas cópias (exemplares) vinculadas a um título.
    * Geração/Leitura de código de barras único para cada exemplar.
    * Controle de status (Disponível, Emprestado, Manutenção, Perdido).
    * Edição com bloqueio de campos sensíveis (não permite alterar o Título/ISBN do exemplar, apenas o estado físico).

### 🤝 Sistema de Empréstimos (Smart UX)
* **Busca Dinâmica (AJAX):**
    * Pesquisa instantânea de livros por **Código de Barras** ou **Título** sem recarregar a página.
    * Pesquisa de alunos por **RA** ou **Nome**.
* **Validação em Tempo Real:** O sistema impede o empréstimo se o livro não estiver disponível ou se o aluno não for encontrado.
* **Interface Híbrida:** Suporte tanto para leitor de código de barras quanto para seleção manual via lista de sugestões (`datalist`).

### 🔄 Devoluções e Gerenciamento
* **Painel de Controle:** Listagem unificada de todos os empréstimos.
* **Filtro Client-Side:** Pesquisa instantânea na tabela (por nome, RA ou livro) sem refresh.
* **Status Visual:** Indicadores coloridos para livros **Em Aberto**, **Atrasados** ou **Devolvidos**.
* **Baixa Automática:** Ao clicar em "Devolver", o sistema registra a data de entrega e libera automaticamente o status do exemplar para "Disponível".
* **Histórico:** Opção de excluir registros permanentemente ou mantê-los como histórico.

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 8+
* **Banco de Dados:** MySQL (Relacional)
* **Frontend:** HTML5, CSS3 (Estilização Customizada)
* **Interatividade:** JavaScript Puro (Vanilla JS) e Fetch API (AJAX)
* **Servidor Local:** XAMPP (Apache)

## 🚀 Instalação e Configuração do Ambiente

Para configurar o banco de dados e rodar o projeto localmente, siga os passos abaixo.

### Pré-requisitos

* Ter um ambiente de servidor local como o [XAMPP](https://www.apachefriends.org/pt_br/index.html) instalado.

### Passo a Passo

1.  **Clone o Repositório:**
    ```bash
    git clone [https://github.com/seu-usuario/libre-turing.git](https://github.com/seu-usuario/libre-turing.git)
    ```
    Ou baixe e descompacte os arquivos na pasta do servidor.

2.  **Mova os Arquivos:**
    Certifique-se de que a pasta do projeto esteja no diretório `htdocs` do seu XAMPP.
    (Ex: `C:\xampp\htdocs\Libre-Turing-V1`)

3.  **Inicie os Serviços:**
    Abra o Painel de Controle do XAMPP e inicie os serviços **Apache** e **MySQL**.

4.  **Crie o Banco de Dados:**
    Execute o script de criação do banco acessando:
    ```
    http://localhost/Libre-Turing-V1/BD/criarBD.php
    ```

5.  **Crie as Tabelas e Dados Iniciais:**
    Crie a estrutura das tabelas e insira o funcionário padrão para login:
    ```
    http://localhost/Libre-Turing-V1/BD/criarTabelas.php
    ```

6.  **Acesse o Sistema:**
    Acesse a tela de login:
    ```
    http://localhost/Libre-Turing-V1/
    ```

---
*Desenvolvido com ❤️ pela equipe Libre Turing.*