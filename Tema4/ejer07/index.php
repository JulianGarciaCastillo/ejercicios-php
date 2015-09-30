<!DOCTYPE html>

<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <b>7. Realiza el control de acceso a una caja fuerte. La combinación será un número de 4 cifras. El
programa nos pedirá la combinación para abrirla. Si no acertamos, se nos mostrará el mensaje
“Lo siento, esa no es la combinación” y si acertamos se nos dirá “La caja fuerte se ha abierto
satisfactoriamente”. Tendremos cuatro oportunidades para abrir la caja fuerte.</b>
    <br><br>
    <b>BLACKBOX V1.0</b><br><br>


<?php $passSecreta = 1234; ?>

<?php

//SI NO SE HA MANDADO NADA. (Si contador esta vacio)
if (!(isset($_POST['contador']))){
  $contador = 4;
  $passUser = 99999;                                                            //Ponemos 999999 para que sea diferente a passSecreta.

// SI SE HA ENVIADO ALGO
} else{
  $contador = $_POST['contador'];                                               //Cogemos informacion del contador y passUser.
  $passUser = $_POST['passUser'];
}

if ($passSecreta == $passUser) {
  echo "¡ Has acertado el codigo !";
}else if ($contador == 0){
  echo "No te quedan más intentos.";
}else{
  echo "Te quedan ", $contador, " intentos para abrir la caja. <br>";
  $contador--;
  echo "Introduce un número de cuatro cifras.";
    echo '<form action="index.php" method="post">';
    echo '<input type="number" min=0 max=9999 name="passUser">';
    echo '<input type="hidden" name="contador" value="', $contador, '">';
    echo '<input type="submit" value="Continuar">';
    echo '</form>';
}
?>

  </body>
</html>
