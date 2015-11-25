<?php

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
    echo "<h1> $_POST[email] </h1>";



//Fecha conexão com o banco
    $conn = null;
} else {
    //Botão cadastrar não foi pressionado
    //Redireciona para a página inicial
    header('Location: index.php');
}