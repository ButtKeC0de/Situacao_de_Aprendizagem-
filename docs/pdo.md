-------------------------------------------------------PHP Data Objects-------------------------------------------------------------------

O que é o PDO:
R) O PDO é uma extensão do PHP para ter acesso ao banco de dados, sendo totalmente orienteado a objetos, possui uma interface leve para acessar o banco de dados no php

Para que ele é utilizado no PHP:
R) A principal função dele e você conseguir fazer uma busca de usuário com prepared statements assim aumentando a segurança dessa ação e evitando risco de SQL Injection

Como funciona uma conexão utilizando PDO:
R)Você utiliza ele dentro da conexao.php dai você faz o código por exemplo
<?php
$dsn = 'mysql:host=localhost;dbname=nome_do_banco;charset=utf8mb4';
$usuario = 'root';
$senha = '';

try {
    $pdo = new PDO($dsn, $usuario, $senha);
    
    // Configura o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conexão realizada com sucesso!";
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>
O PDO estabelece a conexão segura com o banco de dados MySQL, executa o comando de leitura na tabela "usuarios" e converte as linhas encontradas em objetos PHP para que possam ser exibidos na lista HTML.



Quais são suas principais características:
R) Ele utiliza as mesma funções para criar diferentes bancos de dados, organizado por meio de classes estruturadas, previni ataques SQLInjection, permiete capturar erros de conexão do banco de dados, suporta controle total de transações.

Diferenças entre PDO e MySQLi:
R) O  mySQLi apenas funciona para mySQL diferente do PDO que permite a conexão com mais de 12 bancos de dados, utiliza estilo de orientação a objetos e também a alteralçao do banco que é muito mais facilitado no PDO por necessitar de menos quantidade de mudanças na estrutura 

Vantagens e desvantagens de utilizar PDO:

R)Vantagens: Você pode trocar de banco de dados mudando apenas a string de conexão, sem reescrever o código das consultas.Suporta prepared statements  que protegem a aplicação contra ataques de Injeção de SQL.Permite nomear os parâmetros nas consultas, deixando o código mais limpo e fácil de manter do que o uso de pontos de interrogação.Oferece suporte nativo a transações via comandos como commit ou rollback. 
Desvantagens: Exige conhecimento prévio de Programação Orientada a Objetos (POO), o que pode dificultar o início para desenvolvedores novatos.O PDO não traduz ou interpreta instruções SQL complexas; ele apenas repassa os comandos para o driver específico do banco.Requer que o driver específico do banco de dados esteja instalado e habilitado no servidor PHP. 


O que são Prepared Statements e por que são importantes:
R)

Em quais situações o PDO pode ser uma boa escolha:
R)
