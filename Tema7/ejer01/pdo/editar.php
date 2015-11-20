<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  </head>
  <body>
    <p>1.Crea listado sobre la tabla Clientes que permita ALTA, BAJA y MODIFICACION, mediante el DNI.</p>
    <h2>
    Base de datos PDO <u>banco</u><br>
    Tabla <u>cliente</u><br>
    </h2>
    <?php
    include('../../funciones.php');

      // Conexion
      pdoConexion("banco", "root", "root", $conexion);
     
      // RECIBIR ALTA,BAJA,MODIF
      
      // ALTA
      if (isset($_POST['alta'])){
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
       
        
        $consulta = $conexion->query("INSERT INTO `cliente` (`dni`, `nombre`, `direccion`, `telefono`) VALUES ('".$dni."','".$nombre."','".$direccion."','".$telefono."');");
        
        echo " - Cliente <b>".$nombre."</b> añadido con éxito."; 
      }
      // BAJA
      if (isset($_POST['baja'])){
        $dni = $_POST['dni'];
        
        $bajaCliente = "DELETE FROM `cliente`  WHERE `dni` = '".$dni."';";
        $consulta = mysql_query($bajaCliente, $conexion);
        echo "Cliente con dni: <b>".$dni."</b> eliminado con éxito.";   
      }
      // MODIFICACION
      if (isset($_POST['aModificar'])){
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
      }
      
      
      // FIN RECIBIR ALTA
      
      
      
      
      //Hallar numero total de paginas
      $art_por_pagina = 3;
      pdoNumPaginas($conexion, "cliente", $art_por_pagina, $ultPagina);
      
      // Comprobar en que pagina estamos, sino hemos mandado nada, es que estamos en la primera. Sino, recibir del post.
      if (!isset($_POST['pag'])){
      $pag_Actual = "Primera";
      }else{
        $pag_Actual = $_POST['pag'];
        $posPag = $_POST['posPag'];
      }

    if ($pag_Actual == "Primera") {
      $posPag = 1;
    }

    if (($pag_Actual == "Anterior") && ($posPag > 1)) {
      $posPag--;
    }

    if (($pag_Actual == "Siguiente") && ($posPag < $ultPagina)) {
      $posPag++;
    }

    if ($pag_Actual == "Ultima") {
      $posPag = $ultPagina;
    }
    
    // Mostrar listado limitado por numero de articulos que deseo mostrar
    pdoTablaPag($conexion, "cliente",$posPag, $art_por_pagina);
      

      // Alta ?>
    <form action="#" method="post">
      DNI A COMPROBAR 
      <input type="text" name="dni">
      <input type="submit" name="ok" value="Comprobar">
    </form>
    <div>Pagina <?=$posPag ?> de <?= $ultPagina?></div>
    <form action="#" method="post">
      <button name="pag" value="Primera">Primera</button>   
      <button name="pag" value="Anterior">Anterior</button>   
      <button name="pag" value="Siguiente">Siguiente</button>   
      <button name="pag" value="Ultima">Ultima</button>   
      <input type="hidden" name="posPag" value="<?=$posPag?>"> 
    </form>
    
    
    </body>
</html>