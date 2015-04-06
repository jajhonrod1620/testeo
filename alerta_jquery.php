<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Dialog - Modal message</title>
  <link href="ui/jquery-ui.css" rel="stylesheet">
  <script src="jquery.js"></script>
  <script src="ui/jquery-ui.js"></script>
  <?php 
    $y = $_GET['y'];
    
    if ($y == 0 ) {
      $texto = "texto 1";
    }
    else if ($y == 1 ) {
      $texto = "texto 2";
    }
    else
    $texto = "texto 3";
  ?>
  <script>
  $(function () {
    function alerta () {
      $( "#dialog-message" ).dialog({
        modal: true
      });
    }  
    alerta ();
  });
  </script>
</head>
<body>
 
<div id="dialog-message" class="ui-state-error" title="Alerta">
			<p>
			<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
			<?php echo $texto; ?>
		  </p>
</div>
<p>Sed vel diam id libero <a href="http://example.com">rutrum convallis</a>. Donec aliquet leo vel magna. Phasellus rhoncus faucibus ante. Etiam bibendum, enim faucibus aliquet rhoncus, arcu felis ultricies neque, sit amet auctor elit eros a lectus.</p>

</body>
</html>
