<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Dialog - Modal message</title>
  <link href="jquery-ui.css" rel="stylesheet">
  <script src="jquery.js"></script>
  <script src="jquery-ui.js"></script>
  <!--<link rel="stylesheet" href="/resources/demos/style.css"> -->
  <script>
  <?php
    $mensaje = 'prueba01';
    $valor = 10;
    if($valor <= 0) {
      ?>
      var mostrar = false;
      <?php
    }else{
      ?>
      var mostrar = true;
      <?php
    }
  ?>
  
    var prueba = 0;
  $(function() {
  function alerta(preuba){
    $( "#dialog-message" ).dialog({
      modal: true,
      
    });
  }
  if(mostrar === true) {
      alerta(prueba);
  }
  });
      
  </script>
</head>
<body>
  
<div id="dialog-message" title="Tiempos Procesales" style="display:none;" class="ui-state-highlight ui-corner-all">
  <span class="ui-icon ui-icon-alert" style="float: left; margin-right: .7em;"></span>
    <?php echo $mensaje; ?>
</div>

 
<p>Sed vel diam id libero rutrum convallis. Donec aliquet leo vel magna. Phasellus rhoncus faucibus ante. Etiam bibendum, enim faucibus aliquet rhoncus, arcu felis ultricies neque, sit amet auctor elit eros a lectus.</p>
 

</body>
</html>
