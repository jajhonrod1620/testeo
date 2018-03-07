<?php 
header('Content-Type: text/html; charset=utf-8'); 
if( $_POST[ 'submit' ] ) 
{ 
   include( 'v_fecha.php' ); // Incluimos las funciones de validación de fecha 
   $f = valida_fecha( $_POST[ 'fecha' ], '', 1 ); // evaluamos la fecha 

   if( $f[0] ) // Si se encontraron errores 
      echo "Por favor ingrese una fecha correcta: ".$f[1]."<p/>"; 
   else // Si la fecha es correcta mostramos como se va a guardar en la bd 
    { 
      echo $f[1]."<p/>"; // aquí hacemos lo necesario para guardar en la bd 
    } 
} 
?> 
<html> 
<head> 
   <title>Ejemplo de validaci&oacute;n de fecha</title> 
</head> 
<body> 
   <form action="" method="post"> 
      Ingrese la fecha a evaluar: <input type="text" name="fecha"> 
      <input type="submit" name="submit" value="Evaluar"> 
   </form> 
</body> 
</html>
