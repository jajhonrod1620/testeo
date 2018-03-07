<?php 
/************************************************************************************************ 

Autor: Erik Francisco Torres Zavala 
Fecha de Creación: 01-03-07 
Fecha de Última Modificación: 25-03-09 
Descripción del Archivo: Estas funciones poseen un nombre un tanto descriptivo conforme a lo que 
                         realiza cada una de ellas 

************************************************************************************************/ 

/*----Esta función se encarga de eliminar todos los caracteres que sean igual a la variable----*/ 
/*-$caracter_a_eliminar y se encuentren dentro de la cadena que se paso en la variable $cadena-*/ 
function suprime_caracteres( $cadena, $caracter_a_eliminar )  
{ 
   $corregida = str_replace( $caracter_a_eliminar, '', $cadena ); 
   return $corregida; 
} 
/*//////////////////////////////////////////////|\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\*/ 

/*---Esta función pinta del color especificado en la variable $color y en negritas la cadena---*/ 
/*--------------------------------pasada en la variable $cadena--------------------------------*/ 
function colorea_cadena( $cadena, $color ) 
{ 
   $con_color = '<font color="'.$color.'"><b>'.$cadena.'</b></font>'; 
   return $con_color; 
} 
/*//////////////////////////////////////////////|\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\*/ 

/*---La siguiente función lo que hace es examinar la cadena pasada en la variable $cadena y----*/ 
/*-devolver la misma pero sólo con números y o letras dependiendo de lo que se halla indicado--*/ 
/*--en la variable $validar la cual debe tener como valor 'letras', 'números' o 'let_y_num'----*/ 
function extraer_letras_y_o_numeros( $cadena, $validar ) 
{ 
   // Creamos 2 array con los caracteres validos correspondientes 
   $abecedario = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 
                         'Ñ', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' ); 
   $numeros    = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ); 

   if( $validar == 'letras' ) 
      $validos = $abecedario; 
   else 
    { 
       if( $validar == 'numeros' ) 
         $validos = $numeros; 
       else 
         $validos = array_merge( $abecedario, $numeros ); 
    } 

   $corregida = ''; // Creamos la variable que contendá la cadena corregida 

   for( $e = 0; $e < strlen( $cadena ); $e++ ) // Recorremos cada caracter de nuestra cadena 
   { 
      foreach( $validos as $c_valido ) 
      { 
           // Si el caracter es valido lo agregramos a nuestra cadena 
         if( substr( $cadena, $e, 1 ) == $c_valido ) 
         { 
            $corregida .= substr( $cadena, $e, 1 ); 
            continue1; // Continuamos con el siguiente caracter a validar 
         } 
      } 
   } 

   return $corregida; 
} 
/*//////////////////////////////////////////////|\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\*/ 
?>
