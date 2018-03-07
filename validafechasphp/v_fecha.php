<?php 
/*********************************************************************************************************** 
Autor: Erik Francisco Torres Zavala 
Fecha de Creación: 01-03-07 
Fecha de última Modificación: 27-03-09 
Descripción del Archivo: Este archivo contiene funciones para evaluar cada una de las partes de una fecha 
                         (día, mes y año) y devuelve un array en el cual el primer valor '[0]' nos indicará 
                            con un valor booleano si se encontro un error '1' o no '0' y el segundo valor '[1]' 
                            contendrá la fecha con el siguiente formato: aaaa-mm-dd para poder guardarla en 
                            una base de datos si es que no se encontró ningún error, de lo contrario, el 
                            resultado de la evaluación tendrá como valor la misma fecha enviada pero marcando 
                            con un color y en negritas los errores que se encontraron. 
                                  
Descripción de Variables: $fecha     OBLIGATORIO  Es la fecha que deseamos validar y dar formato 
                          $garabato  OPCIONAL     Es el símbolo que deseamos colocar para marcar los dígitos 
                                                       que hacen falta... por default es '?' 
                             $tipo      OPCIONAL     Es un número que indica la forma en como le envíamos la 
                                                        fecha a la función... por default es '1' y a continuación 
                                                        se muestra el formato válido para cada uno de los 3 tipos: 
                                  
                                     Formato válido para el tipo '1': (dd/mm/aaaa) ejemplo: 4-ene-5 
                                     Formato válido para el tipo '2': (aaaa/mm/dd) ejemplo: 5-1-5 
                                         Formato válido para el tipo '3': Marca de tiempo UNIX ejem.: 1104904620 

                                                        como se puede observar el separador puede ser '/' ó '-', 
                                                        los números pueden ser de una sóla cifra y el mes se puede 
                                                        enviar en español ó en ingles de nombre completo o sólo 
                                                        los 3 prímeros caracteres 
                             $color     OPCIONAL     Es el color que deseamos pintar cada una de las partes de 
                                                        la fecha en caso de que se hallan encontrado errores, deve 
                                                        ser en formato hexadecial... por default es rojo '#FF0000' 
***********************************************************************************************************/ 

include_once 'funciones_de_cadena.php'; // Incluimos las funciones complementarias 

function valida_dia( $dia, $garabato, $color  ) 
{
   /*-----------Quitamos los espacios que existan al principio, dentro y/o al final de cada uno-----------*/ 
    /*-------de los parámetros, lo cual ya hicimos en la función valida_fecha y lo repetimos por si--------*/ 
    /*-----------------------------sólo estamos ocupando la función valida_dia-----------------------------*/ 
   $dia      = suprime_caracteres( $dia, ' ' ); 
   $garabato = suprime_caracteres( $garabato, ' ' ); 
   $color    = suprime_caracteres( $color, ' ' ); 

   if( is_int( $dia ) ) // Si el día es de tipo entero... lo convertimos a string 
       $dia = (string)$dia; 

    $d_num = extraer_letras_y_o_numeros( $dia, 'numeros' ); // Nos aseguramos que el día sólo tenga números 

   $d[0] = 1; // Marcamos que se encontró un error hasta demostrar lo contrario 

    if( $d_num != '0' && $d_num != '' ) 
    { 
       if( $d_num < '32' ) // El día es válido 
        { 
           if( strlen( $d_num )  == 1 ) // Si el día es de un sólo caracter 
               $d[1] = '0'.$d_num;       // concatenamos un cero a la izquierda 
            else 
               $d[1] = $d_num; 

         $d[0] = 0; // Indicamos que no se encontró ningún error 
        } 
        else // ERROR: Sólo existe un máximo de 31 días por mes 
        { 
           if( strlen( $d_num ) == 1 ) 
               $d[1] = colorea_cadena( $garabato.$d_num, $color ); 
            else 
               $d[1] = colorea_cadena( $d_num, $color ); 
        } 
    } 
   elseif( $d_num == '0' ) // ERROR: No existe ningún día cero '0' 
    { 
       if( strlen( $dia ) == 1 ) 
          $d[1] = colorea_cadena( $garabato.$dia, $color ); 
        else 
          $d[1] = colorea_cadena( $dia, $color ); 
    } 
    elseif( $d_num == '' ) // ERROR: Día vacío 
    { 
       if( $dia == '' ) 
         $d[1] = colorea_cadena( $garabato.$garabato, $color ); 
        elseif( strlen( $dia ) == 1 ) 
         $d[1] = colorea_cadena( $garabato.$dia, $color ); 
        elseif( strlen( $dia ) >= 2 ) 
         $d[1] = colorea_cadena( $dia, $color ); 
    } 

    return $d; 
} 

function valida_mes( $mes, $garabato, $color ) 
{
   /*-----------Quitamos los espacios que existan al principio, dentro y/o al final de cada uno-----------*/ 
    /*-------de los parámetros, lo cual ya hicimos en la función valida_fecha y lo repetimos por si--------*/ 
    /*-----------------------------sólo estamos ocupando la función valida_mes-----------------------------*/ 
   $mes      = suprime_caracteres( $mes, ' ' ); 
   $garabato = suprime_caracteres( $garabato, ' ' ); 
   $color    = suprime_caracteres( $color, ' ' ); 

   if( is_int( $mes ) ) // Si el mes es de tipo entero... lo convertimos a string 
       $mes = (string)$mes; 

   $m[0] = 1; // Marcamos que se encontró un error hasta demostrar lo contrario 

   if( !empty( $mes ) && $mes != '0' ) // Si se ingresaron datos 
   { 
       $m_int = extraer_letras_y_o_numeros( $mes, 'numeros' ); // Extraemos sólo números 

        if( $m_int != 0 && $m_int != '' ) // Si el día es un número 
        { 
           $mes = $m_int; 

           if( $mes <= 12 ) 
            { 
               if( strlen( $mes ) == 1 ) // Si el mes es de 1 caracter le concatenamos un 0 a la izquierda 
               $mes = "0".$mes; 

                $m[0] = 0; // Indicamos que no se encontró ningún error 
                $m[1] = $mes; 
            } 
         else // ERROR: El mes enviado esta fuera del rango permitido 
            $m[1] = colorea_cadena( $mes, $color ); 
        } 
      else // Si el día no es un número evaluaremos al mes como texto 
      { 
            $mes = strtoupper( $mes ); // Comvertimos el valor del mes enviado a Mayúsculas 
          $mes = extraer_letras_y_o_numeros( $mes, 'letras' ); // Extraemos sólo letras 

         // Creamos arreglos para los meses válidos incluidos los nombres en ingles 
         $m_esp = array( 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 
                           'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE' ); 
         $m_ing = array( 'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 
                           'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER' ); 

         // Comparamos los valores del array con el valor del mes enviado para saber el número de mes 
         for( $e = 0; $e < count( $m_esp ); $e++ ) 
         { 
               $m3s = substr( $m_esp[$e], 0, 3 ); // Extraemos las 3 primeras letras del mes en español 
                $m3e = substr( $m_ing[$e], 0, 3 ); // Extraemos las 3 primeras letras del mes en ingles 

            if( $m_esp[$e] == $mes || $m3s == $mes || $m_ing[$e] == $mes || $m3e == $mes ) // Si es válido 
            { 
               $mes = $e + 1; // Sumamos una unidad al mes porque los array comienzan desde la posición 0 

               if( $mes < 10 ) // Si el tamaño del mes es de 1 dígito concatenamos un 0 a la izquierda 
                  $mes = "0".$mes; 

               $m[0] = 0; // Indicamos que no se encontró ningún error 
                    $m[1] = $mes; 
               break; // Dejamos de comparar porque si llegamos hasta aqui significa que el mes si es válido 
            } 
         } 

         if( $m[0] == 1 ) // Si el mes enviado no es igual a alguno de los meses válidos lo marcamos 
            { 
               if( strlen( $mes ) == 0 ) 
               $m[1] = colorea_cadena( $garabato.$garabato, $color ); 
               elseif( strlen( $mes ) == 1 ) 
               $m[1] = colorea_cadena( $garabato.$mes, $color ); 
                elseif( strlen( $mes ) >= 2 ) 
               $m[1] = colorea_cadena( $mes, $color ); 
            } 
      } 
   } 
    elseif( $mes == '0' ) // ERROR: No existe ningún mes 0 
   { 
       if( strlen( $mes ) == 1 ) 
         $m[1] = colorea_cadena( $garabato.$mes, $color ); 
        elseif( strlen( $mes ) >= 2 ) 
         $m[1] = colorea_cadena( $mes, $color ); 
   } 
   elseif( empty( $mes ) && $mes <> '0' ) // ERROR: Campo vacio 
      $m[1] =  colorea_cadena( $garabato.$garabato, $color ); 

   return $m; 
}
function valida_anio( $anio, $garabato, $color ) 
{ 
   /*-----------Quitamos los espacios que existan al principio, dentro y/o al final de cada uno-----------*/ 
    /*-------de los parámetros, lo cual ya hicimos en la función valida_fecha y lo repetimos por si--------*/ 
    /*----------------------------sólo estamos ocupando la función valida_anio-----------------------------*/ 
   $anio     = suprime_caracteres( $anio, ' ' ); 
    $color    = suprime_caracteres( $color, ' ' ); 
   $garabato = suprime_caracteres( $garabato, ' ' ); 

   if( is_int( $anio ) ) // Si el año es de tipo entero... lo convertimos a string 
       $anio = (string)$anio; 

    $a_num = extraer_letras_y_o_numeros( $anio, 'numeros' ); // Nos aseguramos que año contenga sólo números 

   $a[0] = 1; // Marcamos que se encontró un error hasta demostrar lo contrario 

    if( $a_num < '10000' && $a_num != '' ) // Si el año es válido 
    { 
        $a[0] = 0; // Indicamos que no se encontro ningún eror 

       switch( strlen( $a_num ) ) 
      { 
         case '1': // Si se envío sólo un dígito se considerará como años dos mil 
            $a[1] = "200".$a_num; 
            break; 
         case '2': 
               if( $a_num > 69 ) // Cuando es mayor a 69 se considerará como milnovecientos y algo 
                  $a[1] = "19".$a_num; 
               else // Cuando es menor ó igual a 69 se considerará como años dos mil 
                  $a[1] = "20".$a_num; 
            break; 
         case '3': 
            if( substr ( $a_num, 0, 1 ) == 0 ) // Si el 1er digito = 0 se considera como años dos mil 
               $a[1] = "2".$a_num; 
            else // si el 1er. dígito es diferente de 0 se considerará como años mil y algo 
               $a[1] = "1".$a_num; 
            break; 
         default: 
               if( $a_num != '0000' ) 
                  $a[1] = $a_num; 
                else // Error: No existe el año 0 
                { 
                   $a[0] = 1; 
                   $a[1] = colorea_cadena( $a_num, $color ); 
                } 
      } 
    } 
    elseif( $a_num >= '10000' && $a_num != '' ) // Error: El año está fuera del rango permitido 
       $a[1] = colorea_cadena( $anio, $color ); 
    elseif( $a_num == '' ) // ERROR: No se encontraron números 
    { 
       if( $anio == '' ) 
         $a[1] = colorea_cadena( $garabato.$garabato.$garabato.$garabato, $color ); 
        elseif( strlen( $anio ) == 1 ) 
         $a[1] = colorea_cadena( $garabato.$garabato.$garabato.$anio, $color ); 
        elseif( strlen( $anio ) == 2 ) 
         $a[1] = colorea_cadena( $garabato.$garabato.$anio, $color ); 
        elseif( strlen( $anio ) == 3 ) 
         $a[1] = colorea_cadena( $garabato.$anio, $color ); 
        elseif( strlen( $anio ) >= 4) 
         $a[1] = colorea_cadena( $anio, $color ); 
    } 

    return $a; 
} 

function valida_fecha( $fecha, $garabato, $tipo = 1, $color = '#FF0000' ) 
{ 
   // Quitamos los espacios que existan al principio, dentro y/o al final de cada uno de los parámetros 
   $fecha    = suprime_caracteres( $fecha, ' ' ); 
   $garabato = suprime_caracteres( $garabato, ' ' ); 
   $tipo     = suprime_caracteres( $tipo, ' ' ); 
   $color    = suprime_caracteres( $color, ' ' ); 

   if( empty( $garabato ) && $garabato <> '0' ) // Si no se envío ningún garabato, asignamos uno por default 
      $garabato = '?'; 
    else 
    { 
        if( strlen( $garabato ) > 1 ) // Nos aseguramos de que $garabato conste de ún sólo caracter 
           $garabato = substr( $garabato, 0, 1 ); 
    } 

   if( !ereg( '^[1-3]{1}$', $tipo ) ) // ERROR: La variable $tipo no esta dentro del rango permitido. 
   { 
      // Esta variable nos servir para abrir una ventana de alerta 
      $mensaje = " 
         <script languaje=\"javascript\"> 
         function alerta() 
         { 
            msj = 'Amigo(a) programador(a), tuviste un error.\\n\\nEl valor que pusiste al parámetro '; 
            msj += '\$tipo en la función\\r de validación es: $tipo, este valor no es válido, '; 
            msj += 'por favor\\r corrigelo para poder realizar la validación.'; 

            alert( msj ); 
         } 
         alerta(); 
         </script> 
      "; 

      $validada[] = 1; 
      $validada[] = $fecha.$mensaje; 

      return $validada; // Mostramos el ERROR al programador 
   } 

   /*------------Reemplazamos el separador '/' por uno más estandar (digo "estandar" porque es------------*/ 
    /*-------------------el separador que se pone en MySQL para los campos tipo DATE '-'-------------------*/ 
   $fecha = str_replace( '/', '-', $fecha ); 

   /*-----------La siguientes 2 variables nos servirán para indicar los dígitos que deverán de------------*/ 
   /*--------------contener cada una de las partes (día, mes y año) marcadas con otro color---------------*/ 
   $d_m = colorea_cadena( $garabato.$garabato, $color ); 
   $a   = colorea_cadena( $garabato.$garabato.$garabato.$garabato, $color ); 

   /*-------Si la fecha NO contiene guiones medios evaluamos si es de tipo 3 (Marca de tiempo UNIX)-------*/ 
    /*---------------------------------de lo contrario mostramos el error----------------------------------*/ 
   if( !strstr ( $fecha, "-" ) ) 
   {
      if( empty( $fecha ) && $fecha <> '0' ) // ERROR: Fecha vacía 
      { 
         if( $tipo == 1 ) // Si la fecha debe comenzar por día 
            $fecha = $d_m."-".$d_m."-".$a; 
         elseif( $tipo == 2 ) // Si la fecha debe comenzar por año 
            $fecha = $a."-".$d_m."-".$d_m; 
            elseif( $tipo == 3 ) // Si la fecha debe ser una marca de tiempo UNIX mínimo son 5 dígitos 
            $fecha = colorea_cadena( $garabato.$garabato.$garabato.$garabato.$garabato, $color ); 

         $validada[] = 1; 
         $validada[] = $fecha; 

         return $validada; 
      } 
      else 
      { 
           if( $tipo == 3 ) // Si la fecha que se mando es una marca de tiempo UNIX 
            { 
               $fecha = extraer_letras_y_o_numeros( $fecha, 'numeros' ); // Extraemos sólo los números 

            // Las marcas de tiempo Unix comienzan desde el 01/01/1970 (5 dígitos) 
                // hasta el 18/01/2038 (10 digitos) segun la funcion mktime() 
                if( strlen( $fecha ) >= 5 && strlen( $fecha ) <= 10 ) 
                { 
                   $fecha = date( 'Y-m-d', $fecha ); 
                   if( $fecha ) // Si la fecha es correcta 
                    { 
                     $validada[] = 0; 
                  $validada[] = $fecha; 

                  return $validada; 
                    } 
                    else 
                    { 
                      $validada[] = 1; 
                  $validada[] = colorea_cadena( $fecha, $color ); 

                  return $validada; 
                    } 
                } 
                else // ERROR: La marca de tiempo UNIX no está dentro del rango permitido 
                { 
                   if( strlen( $fecha ) == 0 ) 
                       $fecha = colorea_cadena( $garabato.$garabato.$garabato.$garabato.$garabato, $color ); 
                   if( strlen( $fecha ) == 1 ) 
                       $fecha = colorea_cadena( $garabato.$garabato.$garabato.$garabato.$fecha, $color ); 
                    elseif( strlen( $fecha ) == 2 ) 
                       $fecha = colorea_cadena( $garabato.$garabato.$garabato.$fecha, $color ); 
                    elseif( strlen( $fecha ) == 3 ) 
                       $fecha = colorea_cadena( $garabato.$garabato.$fecha, $color ); 
                    elseif( strlen( $fecha ) == 4 ) 
                       $fecha = colorea_cadena( $garabato.$fecha, $color ); 
                    elseif( strlen( $fecha ) > 10 ) 
                       $fecha = colorea_cadena( $fecha, $color ); 

                   $validada[] = 1; 
               $validada[] = $fecha; 

               return $validada; 
                } 
            } 
           elseif( $tipo == 1 ) // Si la fecha debe comenzar por día 
         { 
            $d = valida_dia( $fecha, $garabato, $color ); 
            $fecha = $d[1]."-".$d_m."-".$a; 
         } 
         elseif( $tipo == 2 ) // Si la fecha debe comenzar por año ($tipo = 2) 
         { 
               $a = valida_anio( $fecha, $garabato, $color ); 
            $fecha = $a[1]."-".$d_m."-".$d_m; 
         } 

         $validada[] = 1; 
         $validada[] = $fecha; 

         return $validada; 
      } 
   }

   /*/////////////////////////////////////////////|\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\*/  
   
    /*-----------Separamos en partes la fecha para poder evaluar cada una de ellas por separado------------*/ 
   $partes = explode( '-', $fecha ); 

   /*--------Contamos el número de partes con que cuenta la fecha para saber que hacer dependiendo--------*/ 
    /*------------del número de estas, el formato correcto debera de ser: parte1-parte2-parte3-------------*/ 
    /*---------------------------------es decir, debe haber sólo 3 partes----------------------------------*/ 
   $cant = count( $partes ); 

   if ( $cant == 2 ) 
   {         
      if( $tipo == 1 ) // Si la fecha debe comenzar por día 
      { 
           $uno = valida_dia( $partes[0], $garabato, $color ); 
         $falta = $a; // Como solo se enviaron 2 partes falta el año 
      } 
      else 
      { 
         $uno = valida_anio( $partes[0], $garabato, $color ); 
         $falta = $d_m; // Como solo se enviaron 2 partes falta el dia 
      } 

        $dos = valida_mes( $partes[1], $garabato, $color ); // Ahora evaluamos el mes 

        // Si no se encontraron errores en dia y mes nos aseguramos que el día sea válido para el mes 
        if( $tipo == 1 && ( !$uno[0] && !$dos[0] ) ) 
      { 
           if( $uno[1] > 29 && $dos[1] == '02' ) // ERROR: El mes de febrero nunca tiene más de 29 días 
               $uno[1] = colorea_cadena( $uno[1], $color ); 

         // ERROR: Los meses de Abril, Junio, Septiembre y Noviembre no tienen 31 días 
            if( $uno[1] == 31 && ( $dos[1] == '04' || $dos[1] == '06' || $dos[1] == '09' || $dos[1] == '11' ) ) 
               $uno[1] = colorea_cadena( $uno[1], $color ); 
      } 

      $fecha = $uno[1]."-".$dos[1]."-".$falta; 

      $validada[] = 1; 
      $validada[] = $fecha; 

      return $validada; 
   } 
   /*/////////////////////////////////////////////|\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\*/ 
   elseif ( $cant == 3 ) // Si se enviaron las tres partes 
   { 
      // Damos formato a $dia, $mes y $anio para que se correspondan con el tipo a evaluar 
      if( $tipo == 1 ) 
      { 
         $dia  = $partes[0]; 
         $mes  = $partes[1]; 
         $anio = $partes[2]; 
      } 
      else 
      { 
         $dia  = $partes[2]; 
         $mes  = $partes[1]; 
         $anio = $partes[0]; 
      } 

      $dia  = valida_dia( $dia, $garabato, $color ); 
      $mes  = valida_mes( $mes, $garabato, $color ); 
      $anio = valida_anio( $anio, $garabato, $color ); 

      if( $dia[0] || $mes[0] || $anio[0] ) // ERROR: Se encontraron errores en las partes de la fecha 
      { 
         if( $tipo == 1 ) 
            $fecha = $dia[1]."-".$mes[1]."-".$anio[1]; 
         else 
            $fecha = $anio[1]."-".$mes[1]."-".$dia[1]; 

         $validada[] = 1; 
         $validada[] = $fecha; 

         return $validada; 
      } 
      else 
        { 
         $valida = checkdate( $mes[1], $dia[1], $anio[1] ); // Válidamos la fecha 

         if( $tipo == 1 ) 
            $fecha = $dia[1]."-".$mes[1]."-".$anio[1]; 
         else 
            $fecha = $anio[1]."-".$mes[1]."-".$dia[1]; 

         if( !$valida ) // ERROR: Fecha inválida 
         { 
            $validada[] = 1; 
            $validada[] = $fecha; 

            return $validada; 
         } 
         else // Si la fecha es valida 
         { 
               if( $tipo == 1 ) 
               $fecha = $anio[1]."-".$mes[1]."-".$dia[1]; 

            $validada[] = 0; 
            $validada[] = $fecha; 

            return $validada; 
         } 
        } 
   } 
    /*/////////////////////////////////////////////|\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\*/ 
   elseif( $cant > 3 ) 
   { 
      $fecha = colorea_cadena( $fecha, $color ); 

      $validada[] = 1; 
      $validada[] = $fecha; 

      return $validada; // ERROR: La fecha no tiene un formato correcto 
   } 
} 
?>  
