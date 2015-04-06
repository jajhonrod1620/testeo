<?php

  $parametros['extras'] = "docdeu.categoria|{c}A{c},{c}{c},";
  $extras      = explode("|", $parametros['extras']);
  echo "<pre>";
  print_r($extras);
  $extras['1'] = substr($extras['1'], 0, -1);
  echo $extras['1']."<br>";
  $extras['1'] = str_ireplace("{c}", "'", $extras['1']);
  echo $extras['1']."<br>";
  $datos_ok = str_ireplace("'',", '', $extras['1']);
  echo $datos_ok."<br>";
  
  echo substr_count($extras['1'], "''");
  
  
