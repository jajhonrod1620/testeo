<?php
  //$fin_cadena = "";
  echo "boolean to string  true   = ";
  $booleano = true;
  echo strval($booleano). "<br>";
  $fin_cadena = ",''";
  $cadena = "docdeu.categoria|{c}N{c},{c}A{c},{c}{c},";
  $extras      = explode("|", $cadena);
  $extras['1'] = substr($extras['1'], 0, -1);
  $nombrecampo = explode(".", $extras['0']);
  $extras['1'] = str_ireplace("{c}", "'", $extras['1']);
  echo $extras['1']."<br>";
  if (trim($extras['1']) == "''") {
      $whereExtra = " AND " . $extras['0'] . ' IS NULL ';
  } else {
      $datos_ok = str_ireplace("'',", $fin_cadena, $extras['1']);
      echo $datos_ok."<br>";
      if (substr_count($extras['1'], "'',") >= 1) {
          $whereExtra = '  AND (' . $extras['0'] . '  IN (' . $datos_ok . ') OR ' . $extras['0'] . ' IS NULL)';
      }
      elseif(substr_count($extras['1'], "''") >= 1){
        $datos_ok = str_ireplace(",''", $fin_cadena, $extras['1']);
        echo $datos_ok."<br>";
        $whereExtra = '  AND (' . $extras['0'] . '  IN (' . $datos_ok . ') OR ' . $extras['0'] . ' IS NULL)';
      }
      else{
          $whereExtra = '  AND ' . $extras['0'] . '  IN (' . $datos_ok . ')';
      }
  }
  $where .= $whereExtra;
  
  echo $where;

