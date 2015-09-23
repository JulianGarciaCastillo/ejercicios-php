<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <?php
    $radio = $_GET['radio'];
    $altura = $_GET['altura'];
    $volumenCono = (pi()* $radio*$radio*$altura)/3;
    ?>
    Volumen del cono: <?php echo $volumenCono ?><br>
  </body>
</html>
