<?php
$variable = "Transaccion Abortada...\\nLa Gestion no se Guardo, Comuniquese con Solati Tel. (054)2687551\\nNo Continue Gestionando Hasta Tanto no Reciba Instrucciones de Solati.\\n";
$error = "ERROR: error de sintaxis en o cerca de «,» LINE 1: insert into compromi 
 (conscompromi,,codcob,consegui,grabador... ^";
 
$error1 = "ERROR: transacción abortada, las órdenes serán ignoradas hasta el fin de bloque de transacción";

$mensaje = $variable . urlencode(chop($error));

?>
<script languaje="JavaScript">
	alert ('<?php echo "$mensaje";?>');
</script>
