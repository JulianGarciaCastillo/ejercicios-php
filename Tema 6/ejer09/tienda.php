<?php session_start() ?>
<!DOCTYPE html>

<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <style>
    body{
      background-color: #C9DBFF;
    }
    div#contenedor{
      width: 70%;
      background-color: #6699FF;
      position: relative;
      margin-left: 15%;
      overflow: auto;
    }
    div#contenedorAdmin{
      width: 70%;
      top: 40%;
      background-color: #949494;
      position: relative;
      margin-left: 15%;
      overflow: auto;
    }
    
  </style>
  <body>
      <p><b>5. Crea un carrito de la compra sencillo que permita añadir y quitar productos (tres o cuatro productos
diferentes). De cada producto se debe conocer al menos la descripción, el precio y debe tener una
imagen que lo identifique<br>
  <?php
  include('../funciones.php');
  
if ( !isset($_COOKIE['catalogo_articulos']) ){
  // CREO EL ARRAY DE ARTICULOS DE CATALOGO
  $articulos = array (
    "lasdvi" => array ("titulo" => "La sombra del viento", "precio" => 17.95, "imagen" => "lasdvi.jpg"),
    "elulta" => array ("titulo" => "El último adiós", "precio" => 22.90, "imagen" => "elulta.jpg"),
    "diamaz" => array ("titulo" => "Diamante azul", "precio" => 20, "imagen" => "diamaz.jpg"),
    "claluc" => array ("titulo" => "Claus y Lucas", "precio" => 9.95, "imagen" => "claluc.jpg")
  );
  
  //// GUARDAR  ARRAY EN COOKIE \\\\  
    cookieArrayToCookie($articulos,'catalogo_articulos');
}else{
 
  // Leer la cookie y convertir en array de nuevo
    
  $articulos = $_COOKIE['catalogo_articulos'];
  $articulos = stripslashes($articulos);    	
  $articulos = unserialize($articulos);
  
}
  // Mensaje que muestra tipo usuario que ha accedido desde index.
  $nombre = $_SESSION['tipoAcceso'];
  echo "Conectado como > ". $nombre;
  
  //ZONA ADMIN
  // Si el usuario es admin:
  if ($nombre == "admin"){
    function alta(&$array, $codigo, $nombre, $precio, $imagen){
      $array[$codigo] = array ("titulo" => $nombre, "precio" => $precio, "imagen" => $imagen);  
    }
    function baja(&$array, $codigo){
      unset($array[$codigo]);
    }
    function modificacion(&$array, $codigo, $nombre, $precio, $imagen){
      $array[$codigo] = array ("titulo" => $nombre, "precio" => $precio, "imagen" => $imagen);  
    }

    
    
  // Panel admin ?>
  <div id="contenedorAdmin">
  <h1 align="center">PANEL ADMINISTRADOR</h1>
      <table border="1" style=" border-collapse: collapse; text-align: center; float: left; display: block;" >
        <tr> <th>COD</th> <th>TITULO</th> <th>PRECIO</th> <th>NOMBRE JPG</th> <th>ACCION</th></tr>
        <tr>
          <td>cod</td>
          <td>tit</td>
          <td>precio</td>
          <td>jpg</td>
          <td>ALTA</td>
        </tr>
          <?php
          foreach ($articulos as $codigo => $elemento) { ?>
            <tr>
              <td> <?= $codigo; ?> </td>
              <td> <?= $elemento[titulo]; ?> </td>
              <td> <?= $elemento[precio]; ?>€ </td>
              <td> <?= $elemento[imagen]; ?> </td>
              <td>
                <form action="#" method="post">
                  <input type="hidden" name="codigo" value="<?= $codigo; ?>">  
                  <button name="accion" name="accion" value="baja">BAJA</button> 
                  <button name="accion" name="accion" value="modificar">MODIFICACION</button> 
                </form>
              </td>
            </tr>
          <?php
          }?>
            
      </table>



  </div>
    
    
    
<?php }
    if ($nombre == ""){
      header('Location: index.php');
    }else{
  
  
  
  //  MUESTRO TABLA ARTICULOS
  ?>
    <div id="contenedor">
      <h1 align="center">MINI LIBRERIA</h1>
      <table border="1" style=" border-collapse: collapse; text-align: center; float: left; display: block;" >
        <tr> <th>PORTADA</th><th>TITULO</th><th>PRECIO</th></tr>

          <?php
          foreach ($articulos as $codigo => $elemento) { ?>
            <tr>
              <td> <img src="<?= $elemento[imagen]; ?>" width="80"></td>
              <td> <?= $elemento[titulo]; ?> </td>
              <td> <?= $elemento[precio]; ?>€ </td>
              <td>
                <form action="#" method="post">
                  <input type="hidden" name="codigo" value="<?= $codigo; ?>">  
                  <button name="accion" name="accion" value="comprar">Añadir al carrito</button>
                </form>
              </td>
            </tr>
          <?php
          } ?>
      </table>




      <?php
      // CARRITO
      $accion = $_POST['accion'];
      $codigo = $_POST['codigo'];

      // Si el carrito no se ha inicializdo, se inicializa. EN ESTO SE PUEDE HACER FUNCION A PARTIR DEL CATALOGO. TITULOS - CANTIDADES
      if (!isset($_SESSION[carrito])){
        $_SESSION[carrito] = array ("lasdvi" => 0, "elulta" => 0, "diamaz" => 0, "claluc" => 0);
      }

      // DATOS  RECIBIDOS DEL POST

        // COMPRAR: SUBE 1 CANTIDAD
      if ($accion == "comprar"){
        $_SESSION[carrito][$codigo]++;
      }
        // ELIMINAR: BAJA 1 CANTIDAD
      if ($accion == "eliminar"){
        $_SESSION[carrito][$codigo]--; 
      }
        // ELIMINARTODO: BAJA A 0 CANTIDAD
      if ($accion == "eliminarTodos"){
        $_SESSION[carrito][$codigo] = 0; 
      }
      // ACCIONES DEL ADMIN
        // BAJA: DARA DE BAJA UN LIBRO
      if ($accion == "baja"){
        unset($articulos[$codigo]);
        setcookie('catalogo_articulos', serialize($articulos));
      }
      
      

      // TABLA CARRITO
      ?>
      <br>
      <table border="1" style="border-collapse: collapse; position: relative; float: left; display: block; left:20%; text-align: center; top: 5%; " >

        <tr><th>CANTIDAD</th> <th>PORTADA</th> <th>TITULO</th> <th>PRECIO</th></tr>

          <?php
          $total = 0;
            foreach ($articulos as $cod => $elemento) {
              if ($_SESSION[carrito][$cod] > 0){
               // SUMAR PRECIO TOTAL
                 $total = $total + ($_SESSION[carrito][$cod] * $elemento[precio]);
                 ?>

                <tr>
                  <td> <?= $_SESSION[carrito][$cod]?></td>
                  <td> <img src="<?= $elemento[imagen]; ?>" width="40"></td>
                  <td> <?= $elemento[titulo]; ?> </td>
                  <td> <?= $elemento[precio]; ?>€ </td>

                  <td>
                    <form action="#" method="post">
                      <input type="hidden" name="codigo" value="<?= $cod; ?>">  
                      <button name="accion" name="accion" value="eliminar">ELIMINAR</button><br>
                      <button name="accion" name="accion" value="eliminarTodos">VACIAR(<?= $_SESSION[carrito][$cod];?>)</button>
                    </form>
                  </td>
                </tr><?php
              }
            }
              ?>
            <tr style="text-align: right;">
            <td colspan="4"> <b>TOTAL A PAGAR:</b> <?= $total?>€ </td>
            <td> <input type="submit" name="ok" value="PAGAR"> </td>
          </tr>
      </table>

    </div>
<?php } ?>
  </body>
</html>
