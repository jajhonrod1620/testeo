<?php
$dir = "/home/jrodriguez/svn_docs/reingenieria/analisisyDiseño/juridica/Plan de Despliegue/Correccion Demandas";
$last_line = system('ls '.escapeshellarg($dir), $retval);

echo '
</pre>
<hr />Last line of the output: ' . $last_line . '
<hr />Return value: ' . $retval;
