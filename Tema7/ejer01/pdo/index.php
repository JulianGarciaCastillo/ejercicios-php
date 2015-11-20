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
    
    // CONEXION E INFORMACION ||||||||||||||||||||||||||||||||||||||||||||||||||
      // Conexion
      pdoConexion("banco", "root", "root", $conexion);
      $nombreTabla = "cliente";
      $campoClave = "dni";
      // Extraer nombres de columnas y cantidad.
      pdoArrayCol($conexion, $nombreTabla, $nomColumnas, $numColumnas);
    // FIN CONEXION ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    // RECIBIR ALTA,BAJA,MODIF |||||||||||||||||||||||||||||||||||||||||||||||||
      // ALTA 
      if (isset($_POST['alta'])){
        for ($i = 0; $i < $numColumnas; $i++){
         $datosTabla[] = $_POST[$nomColumnas[$i]]; 
        }

        // Transforma el array de datos recibidos en una frase: EJ: 2573063','Julian Garcia','c/ Avellanas','60578523
        pdoArrayAlta($datosTabla, $sentenciaAlta);
        
        // Incluir comprobacion dni existente
        if(pdoCompruebaDato($conexion, $nombreTabla, $campoClave, $datosTabla[0])){
          echo " - Error. Cliente con codigo <b>".$datosTabla[0]."</b> ya existe.";  
        }else{
          pdoConsulta_Alta($conexion, $nombreTabla, $sentenciaAlta);
          echo " - Cliente <b>".$datosTabla[1]."</b> añadido con éxito.";
        }
      }
      // BAJA
      if (isset($_POST['baja'])){
        $codigo = $_POST['codigo'];

        pdoConsulta_Borrar($conexion, $nombreTabla, $campoClave, $codigo);
        echo " - Cliente con dni: <b>".$codigo."</b> eliminado con éxito.";   
      }
      // A MODIFICAR
      if (isset($_POST['aModificar'])){
        for ($i = 0; $i < $numColumnas; $i++){
         $datosTabla[] = $_POST[$nomColumnas[$i]]; 
        }

      }
      // MODIFICACION
      if (isset($_POST['modificacion'])){
        for ($i = 0; $i < $numColumnas; $i++){
          $datosTabla[] = $_POST[$nomColumnas[$i]]; 
        }
        // Transformo array a string para pegar sentencia en update
        pdoArrayModificacion($numColumnas, $nomColumnas, $datosTabla, $sentenciaUpdate);
        pdoConsulta_Modificar($conexion, $nombreTabla, $sentenciaUpdate, $nomColumnas, $datosTabla);
        echo " - Cliente <b>".$datosTabla[1]."</b> modificado con éxito."; 
      }
    // FIN RECIBIR DATOS |||||||||||||||||||||||||||||||||||||||||||||||||||||||
    
    // PAGINADO ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
      //Hallar numero total de paginas
      $art_por_pagina = 5;
      pdoNumPaginas($conexion, $nombreTabla, $art_por_pagina, $ultPagina);

      // Comprobar en que pagina estamos, sino hemos mandado nada, estamos en la primera. Sino, recibir del post, pag se puede meter en sesion.
      if (!isset($_POST['pag'])){
      $posPagElegida = "Primera";
      }else{
        $posPagElegida = $_POST['pag'];
        $posPag = $_POST['posPag'];
      }

      // Control movimiento paginas
      pdoPaginado($posPagElegida, $posPag, $ultPagina);
    // FIN PAGINADO ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    // MOSTRAR TABLA Y PAGINAS |||||||||||||||||||||||||||||||||||||||||||||||||
    // Mostrar listado limitado por numero de articulos que deseo mostrar
      pdoTablaPag($conexion, $nombreTabla,$posPag, $art_por_pagina, $datosTabla);?>

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