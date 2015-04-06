<?php
  echo "inicia";
  echo time() ."<br>";
  echo date("Y-m-d h:i:s")."<br>";
  $t = strtotime(date('Y-m-d').' 16:00:00');
	if (time_sleep_until($t)){
    echo "<br>acaba";
    echo time()."<br>";
    echo date("Y-m-d h:i:s")."<br>";
  }
?>
