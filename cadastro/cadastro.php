<?php

function gerarCodigo(){
    return sha1(mt_rand());
}

/* * Verifica se o botão cadastrar foi pressionado
 * 
 */
if (isset($_POST['btn'])) {

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


    /**
     * Recepção de dados
     */
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        //Filtragem de entrada de dados
        
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $cod = gerarCodigo();
        
        //String SQL
        $sql = "INSERT INTO lista(email, cod, dtCadastro) values(:email,:cod,now())";
        $parametros = array(':email'=>$email,':cod'=>$cod);
        $p = $conn->prepare($sql);
        $q = $p->execute($parametros);
        
        /**Tarefa de casa
         * Criar um e-mail HTML, enviando um link com o código, 
         * para a pessoa clicar e confirmar seu e-mail
         */
        
        
    } else {
        header('Location: index.php');
    }


//Fecha conexão com o banco
    $conn = null;
} else {
    //Botão cadastrar não foi pressionado
    //Redireciona para a página inicial
    header('Location: index.php');
}