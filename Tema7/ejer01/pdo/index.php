<?php session_start() ?>
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
    
    // CONEXION E INFORMACION --------------------------------------------------
      // Conexion
      pdoConexion("banco", "root", "root", $conexion);
      $nombreTabla = "cliente";
      $campoClave = "dni";
      $datosTabla ="";                  // Solo se usa cuando se clicka modificar, pero se inicializa.
      $datosTablaOrigSes =& $_SESSION['datosOriginal'];
      // Extraer nombres de columnas y cantidad.
      pdoArrayCol($conexion, $nombreTabla, $nomColumnas, $numColumnas);
    // FIN CONEXION ------------------------------------------------------------
    
    // PAGINADO Y ORDEN ARTICUTLOS ---------------------------------------------
      // Articulos por pagina y paginas totales
      $art_por_pagina = 3;
      pdoNumPaginas($conexion, $nombreTabla, $art_por_pagina, $ultPagina);
      
      // Declarar pagina y alias
      if(!isset($_SESSION['pagina'])) {
        $_SESSION['pagina'] = 1;
      }
       $pagSes =& $_SESSION['pagina'];
      
      // Declarar ORDEN y alias
      if(!isset($_SESSION['orden'])) {
        $_SESSION['orden'] = 'dni';
      }
       $elementOrdenSes =& $_SESSION['orden'];
    // FIN PAGINADO ------------------------------------------------------------

    // RECIBIR ALTA,BAJA,MODIF -------------------------------------------------
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
         $datosTablaOrigSes = $datosTabla;
         
        }
        
      }
      
      // MODIFICACION
      if (isset($_POST['modificacion'])){
        for ($i = 0; $i < $numColumnas; $i++){
          $datosTabla []= $_POST[$nomColumnas[$i]]; 
        }
                
        pdoConsulta_Modificar($conexion, $nombreTabla,$nomColumnas,$numColumnas, $datosTabla, $datosTablaOrigSes);
        echo " - Cliente <b>".$datosTabla[1]."</b> modificado con éxito."; 
        
      }
      // ORDENAR
      if (isset($_POST['orden'])){
        $elementOrdenSes = $_POST['orden']; 
      }
      
    
    // FIN RECIBIR DATOS -------------------------------------------------------
    
    // PAGINADO ----------------------------------------------------------------
      // Recibo orden de a qué pagina quiero ir.
      $paginaEnv = $_POST['pagEnv'];
      
      // Control movimiento paginas
      pdoPaginado($paginaEnv, $pagSes, $ultPagina);
    // FIN PAGINADO ------------------------------------------------------------

    // MOSTRAR TABLA Y PAGINAS -------------------------------------------------
      // Mostrar listado limitado por numero de articulos que deseo mostrar
      pdoTablaPag($conexion, $nombreTabla,$pagSes, $art_por_pagina, $datosTabla, $elementOrdenSes);
     
      // Mostrar botones paginado.
      pdoBotonesPaginas($pagSes, $ultPagina); ?>
    <br> <?php
      // Mostrar desplegable order by
      pdoOrdenar($nomColumnas, $numColumnas, $elementOrdenSes); ?>
    </body>
</html>