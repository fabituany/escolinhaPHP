<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Recebe dados através de GET</title>
    </head>
    <body>
        <h1>Exemplo de recebimento - Método GET</h1>
        <?php if (isset($_GET["name"])): ?>
            Bem-vindo <?php echo $_GET["name"]; ?><br>
            Seu enderço de e-mail é: <?php echo $_GET["email"]; ?>
        <?php endif; ?>
            
            <pre><!-- Debugger -->
                <?php
                print_r($_GET);
                ?>
            </pre>
        

    </body>
</html>
