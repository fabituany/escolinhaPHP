<?php

//Faz a requisição de dados para a conexão com o BD
require_once 'dbconfig.php';

/*
 * Conexão com o banco de dados 
 */
try {//Criação do objeto $conn - conexão
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    //echo "Conectado ao banco $dbname em $host com sucesso.";
} catch (PDOException $pe) {
    die("Não foi possível se conectar ao banco $dbname :" . $pe->getMessage());
}

function gerarCodigo() {
    return sha1(mt_rand());
}

/* * Função que converte uma data no formato MySQL para o formato PHP:
 * AAAA-MM-DD HH:II:SS -> DD/MM/AAAA HH:II:SS
 */

function converteDataMySQLPHP($dataMySQL) {
    $dataPHP = $dataMySQL;
    if ($dataMySQL) {
        $dataPHP = date('d/m/Y G:i:s', strtotime($dataMySQL));
    }
    return $dataPHP;
}

/* * Verifica se o botão cadastrar foi pressionado
 * 
 */
if (isset($_POST['btn'])) {

    /**
     * Recepção/inserção de dados
     */
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        //Filtragem de entrada de dados

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $cod = gerarCodigo();

        //String SQL
        $sql = "INSERT INTO lista(email, cod, dtCadastro) values(:email,:cod,now())";
        $parametros = array(':email' => $email, ':cod' => $cod);
        $p = $conn->prepare($sql);
        $q = $p->execute($parametros);

        /*         * Tarefa de casa
         * Criar um e-mail HTML, enviando um link com o código, 
         * para a pessoa clicar e confirmar seu e-mail
         */
    } else {
        header('Location: index.php');
    }
} elseif (isset($_GET['cod'])) {

    if ($_GET['cod'] == 'listar') {
        
        
        //Listagem de e-mails
        $sql = "SELECT email,cod,situacao,dtCadastro,dtAtualizacao FROM lista";

        $q = $conn->query($sql);
        $q->setFetchMode(PDO::FETCH_ASSOC);

        while ($r = $q->fetch()) {
            //desempilhando os pratos
            echo "<p style='color:";
            echo $r['situacao'] ? 'green' : 'red';
            echo ";'>";
            echo $r['email'] . "\t";

            //Link de exclusão
            echo "<a href='cadastro.php?cod=d&hash=$r[cod]' title='Clique para ecluir'>";
            echo $r['cod'];
            echo "</a>";

            echo $r['situacao'] . "\t";
            echo converteDataMySQLPHP($r['dtCadastro']) . "\t";
            echo converteDataMySQLPHP($r['dtAtualizacao']);
            echo "<p>\n";
        }
    }

    //Exclusão de um registro
    elseif ($_GET['cod'] == 'd' && isset($_GET['hash'])) {
        $sql = "delete from lista where cod = :hash";
        $hash = filter_input(INPUT_GET, 'hash', FILTER_SANITIZE_STRING);

        echo "$hash";

        $p = $conn->prepare($sql);
        $q = $p->execute(array(':hash' => $hash));

        header("Location: cadastro.php?cod=listar");
    }

    //Validação de um e-mail
} else {
    //Botão cadastrar não foi pressionado
    //e nem o código foi passado
    //Redireciona para a página inicial
    header('Location: index.php');
}