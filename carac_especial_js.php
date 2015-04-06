<?php
$arraybusqueda2=array("Á","É","Í","Ó","Ú","á","é","í","ó","ú","Ñ","ñ");
$arrayreemplazo2=array("\u00C1","\u00c9","\u00cd","\u00d3","\u00da","\u00e1","\u00e9","\u00ed","\u00f3","\u00fa","\u00d1","\u00f1");

?>

<script language="javascript">
document.write ("Ñ  : <?php echo str_replace($arraybusqueda2,$arrayreemplazo2, "Ñ"); ?>");
</script>
