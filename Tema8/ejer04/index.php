<?php session_start() ?>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <h2>4. Queremos gestionar la venta de entradas (no numeradas) de Expocoches Campanillas que tiene
3 zonas, la sala principal con 1000 entradas disponibles, la zona de compra-venta con 200 entradas
disponibles y la zona vip con 25 entradas disponibles. Hay que controlar que existen entradas
antes de venderlas. Define las clase Zona con sus atributos y métodos correspondientes y crea
un programa que permita vender las entradas. En la pantalla principal debe aparecer información
sobre las entradas disponibles y un formulario para vender entradas. Debemos indicar para qué
zona queremos las entradas y la cantidad de ellas. Lógicamente, el programa debe controlar que no
se puedan vender más entradas de la cuenta.
  <?php
    
    include_once 'Zona.php';
   
    if (!isset($_SESSION['vip'])){
        
        $principal = new Zona("Sala Principal", 1000);
        $compra_venta = new Zona("Compra-venta", 200);
        $vip = new Zona("Vip", 25);
        
         // Guardar objetos en sesion
        $_SESSION['principal'] = serialize($principal);
        $_SESSION['compraVenta'] = serialize($compra_venta);
        $_SESSION['vip'] = serialize($vip);

    }else{
        
        // Recuperar objetos desde sesion
        $principal = unserialize($_SESSION['principal'] );
        $compra_venta = unserialize($_SESSION['compraVenta']);
        $vip = unserialize($_SESSION['vip'] );
        
        $zona = $_POST['zona'];
        $cantidad = $_POST['cantidad'];
        
        if ($zona == "salaPrincipal"){
            //$principal->actionVende($cantidad);
            if (!$principal->actionVende($cantidad)){
                echo "<script type='text/javascript'>alert('No hay tantas entradas disponibles');</script>";
            }
        }
        if ($zona == "compraVenta"){
            //$compra_venta->actionVende($cantidad);
            if (!$compra_venta->actionVende($cantidad)){
                echo "<script type='text/javascript'>alert('No hay tantas entradas disponibles');</script>";
            }   
        }
        if ($zona == "vip"){
            //$vip->actionVende($cantidad);
            if (!$vip->actionVende($cantidad)){
                echo "<script type='text/javascript'>alert('No hay tantas entradas disponibles');</script>";
            }    
        }
        // Guardar objetos en sesion
        $_SESSION['principal'] = serialize($principal);
        $_SESSION['compraVenta'] = serialize($compra_venta);
        $_SESSION['vip'] = serialize($vip); 
    }
 
  ?>

<h1>EXPOCOCHES CAMPANILLAS</h1>
<h2>Compra entradas</h2>
<h3>Zonas</h3>
<table border="1">
    <tr>
        <td><p><?= $principal  ?></p></td>
    </tr>
    <tr>
        <td><p><?= $compra_venta  ?></p></td>
    </tr>
    <tr>
        <td><p><?= $vip ?></p></td>
    </tr>
</table>
<br>Comprar entradas
<form method="post">
    <select name="zona">
        <option value="salaPrincipal">Sala Principal</option>
        <option value="compraVenta">Compra-Venta</option>
        <option value="vip">Zona Vip</option>
    </select>
    Cantidad <input type="number" name="cantidad">
    <input type="submit" value="Comprar">
</form>
<?php 
   
?>
  </body> 
</html>






