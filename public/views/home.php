<?php

  session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <title>Document</title>
</head>
<body>

    <?php require_once "header2.html"?>

        <h1>Tus contactos: </h1>
        <?php   
        
                echo'<br>';
                echo'<h3>Personas:</h3>';
                foreach ($resultadop as $value) {
                    echo"Nombre: $value[1] $value[2] Direccion: $value[3] Telefono: $value[4] <br>";
                }
                
                echo'<br><br>';

                echo'<h3>Empresas:</h3>';
                foreach ($resultadoe as $value) {
                    echo"Nombre: $value[1] Direccion: $value[2] Telefono: $value[3] Correo: $value[4] <br>";
                }


        ?>

        <h1>Actualizar un contacto </h1>
        <form action="" method="post">
                

                
        </form>

        <?php require_once "footer.html"?>

    </body>
</html>