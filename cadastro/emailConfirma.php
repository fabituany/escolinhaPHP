<?php

function emailConfirma($email, $link) {

    // múltiplos destinatários
    $to = $email . ', '; // notar a vírgula
    $to .= 'fabi.tuany@gmail.com';

// subject
    $subject = 'Confirmação de cadastro [nome do site]';

// message
    $message = "
<html>
<head>
 <title>Confirmação de cadastro [nome do site]</title>
</head>
<body>
    <center><img src='http://www.noticenter.com.br/geral/img/empresas/senai' alt='Logo do SENAI'/></center>
    <h1>Confirmação de e-mail</h1>
    <p>Recentemente o e-mail $email foi cadastrado em nossa lista para se manter
       informado com as últimas notícias do [nome do site].</p>
    <p>Para completar o cadastro, favor confirmar clicando no link abaixo:</p>
    <br/>
    <p>$link</p>
</body>
</html>
";

// To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; utf-8' . "\r\n";

// Additional headers
    $headers .= "To: $email" . "\r\n";
    $headers .= 'From: Nome do site <fabi.tuany@gmail.com>' . "\r\n";

// Mail it
    mail($to, $subject, $message, $headers);
}
