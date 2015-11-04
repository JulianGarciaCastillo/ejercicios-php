
<?php session_start() ?>
<!DOCTYPE html>

<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
      <p><b>2. Realiza un programa que vaya pidiendo números hasta que se introduzca un numero negativo y
nos diga cuantos números se han introducido, la media de los impares y el mayor de los pares. El
número negativo sólo se utiliza para indicar el final de la introducción de datos pero no se incluye
en el cómputo. Utiliza sesiones.

<?php
include('../funciones.php');

// Recojo el numero introducido por el usuario
$numUser = $_GET['numUser'];
$maximo = 0;


// ALIAS
$sContador =& $_SESSION['contador'];
$sArrayNumeros =& $_SESSION['numeros'];
$sArrayPar =& $_SESSION['arrayPar'];
$sArrayImpar =& $_SESSION['arrayImpar'];

// Si no se ha mandado ningun numero o el numero es positivo
if ( !isset($numUser) || ($numUser > 0) ){
  $sContador++;                                    // Guardo en sesion_contador la cantidad de numeros que lleguen.
  $sArrayNumeros[] = $numUser;                          // Guardo todos los numeros para mostrarlos al final.
  if ($numUser % 2 == 0){
    $sArrayPar[] = $numUser;                       // Guardo en array los que sean par
  }else{
    $sArrayImpar[] = $numUser;                     // Guardo en array los que sean impar
}
 
?>

<form action="index.php" method="get">
  INTRODUCE UN NUMERO POSITIVO, CUANDO QUIERAS PARAR, UNO NEGATIVO:
  <input type="number" name="numUser" autofocus>
  <input type="submit" value="enviar">
</form>

<?php
// Si introduce un numero negativo, hacer operacion y mostrar.
}else{
  
  // Media de los impares
  for ($x = 0; $x < count($sArrayImpar); $x++){
    $sumaImpares +=  $sArrayImpar[$x];
  }
  $mediaImpares = $sumaImpares / count($sArrayImpar);
  
  // Mayor de los pares
  arrayMax($sArrayPar,$maximo);
  
?>
  <p>NUMEROS INTRODUCIDOS:<br> <?php arrayImprLinea($sArrayNumeros)?> </p>
  <p>NUMEROS PARES: <br> <?php arrayImprLinea($sArrayPar) ?></p> 
  <p>NUMEROS IMPARES:<br> <?php arrayImprLinea($sArrayImpar)?> </p>
  <p>SUMA DE IMPARES: <?= $sumaImpares?></p>
  <p>CANTIDAD DE NUMEROS: <?= $sContador-1; ?></p> 
  <p>MAXIMO DE LOS PARES: <?= $maximo; ?></p> 
  
<?php session_destroy();
}
?>
  </body>
</html>
