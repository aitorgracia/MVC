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

    <?php require "header.html"?>

        <h1>Bienvenido</h1>
        <h4><a href="?method=close">Cerrar sesión</a></h4>

        <h4><a href="?method=close">Insertar XML</a></h4>


        <?php require "footer.html"?>

</body>
</html>