<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  </head>
  <body>
    <h2>
    Base de datos <u>banco</u><br>
    Tabla <u>cliente</u><br>
    </h2>
    <?php

      // Conexion
      $conexion = mysql_connect("localhost", "root", "root");
      mysql_select_db("banco", $conexion);
      mysql_set_charset('utf8');

      // Consulta
      $consulta = mysql_query("SELECT dni, nombre, direccion, telefono FROM cliente", $conexion);

      //Listado
      ?>
      <table border="1">
        <tr>
        <td><b>DNI</b></td>
        <td><b>Nombre</b></td>
        <td><b>Dirección</b></td>
        <td><b>Teléfono</b></td>
        </tr>
      <?php

      // fetch_array va sacando mientras hayan registros, los guarda en $registro, lo muestra, y cambia a otro registro.
        while ($registro = mysql_fetch_array($consulta)){
          echo "<tr>";
          echo "<td>".$registro[dni]."</td>";
          echo "<td>".$registro[nombre]."</td>";
          echo "<td>".$registro[direccion]."</td>";
          echo "<td>".$registro[telefono]."</td>";
          echo "</tr>";
        }
      ?>
    </body>
</html>