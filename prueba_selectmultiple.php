<?php
if(isset($argv[2])){
	$_SESSION['usubd']=$argv[2];
}
else
	$_SESSION['usubd']="root";

if(isset($argv[3])){
	$_SESSION['dbdriver']=$argv[3];
}
else
	$_SESSION['dbdriver']="postgres";

if(isset($argv[4])){
	$_SESSION['database']=$argv[4];
}
else
	$_SESSION['database']="tuya_20121120";

if(isset($argv[5])){
	$_SESSION['servidor']=$argv[5];
}
else
	$_SESSION['servidor']="192.168.2.219";

$usuario = "integracion1";


if(trim(PHP_OS)=="Linux"){
	$DOCUMENT_ROOT  = "/var/www/html";
}else{
	$DOCUMENT_ROOT  = "C:\Archivos de programa\Apache Group\Apache\htdocs";
}

include_once($DOCUMENT_ROOT.'/padminfo/includes/funciones_genericas.php');


//convertir arreglo postgres en array php 
function arrpg_arrphp ($arreglo,  $asText = true) {
    $s = $arreglo;
    if ($asText) {
			$s = str_replace("{", "array('", $s);
			$s = str_replace("}", "')", $s);    
			$s = str_replace(",", "','", $s);    
    } else {
			$s = str_replace("{", "array(", $s);
			$s = str_replace("}", ")", $s);
    }
    $s = "\$retval = $s;";
    echo $s. "el valor<br>";
    eval($s);
    return $retval;
}
//convertir arreglo php en array postgres
function arrphp_arrpg ($arreglo) {
    $s = $arreglo;
    for($i=0; $i< count($s); $i++){
			if($i==0){
				$cadena .= "'{".$s[$i]."";
				if($i == count($s)-1)
					$cadena .= "}'"; 
			}
			else{
				if($i == count($s)-1)
					$cadena .= ",".$s[$i]."}'";
				else
					$cadena .= ",".$s[$i]."";
			}
		}
    return $cadena;
}

echo "<pre>";
print_r($_POST);


//$cervezas = array();

$carros=$_POST["cars"]; 

//recorremos el array de cervezas seleccionadas. No olvidarse q la primera posición de un array es la 0 

for ($i=0;$i<count($carros);$i++) 
{
	echo "<br> carros " . $i . ": " . $carros[$i]; 
} 



echo "<br>".arrphp_arrpg($_POST["concontrol"]);


echo "<br>".arrphp_arrpg($_POST["cars"]);

//tabla de postgres  cuyo campo cod_agente es un array
//$alianza_user = query($_SESSION['database'], "SELECT * FROM agentesusuario WHERE estado = 'A' limit 1", 1,0);


/*for($i=0; $i<$alianza_user->recordcount();$i++){
	echo $alianza_user->fields['cod_agente'] ." <br>";
	$arreglo_php = arrpg_arrphp($alianza_user->fields['cod_agente'], false);
	echo "<pre>";
	print_r($arreglo_php);
	echo "</pre>";
	$alianza_user->movenext();
}*/


$arr_alianza = query($_SESSION['database'],"SELECT concontrol, nombresucur FROM control WHERE estado = 'A'",1,0);

//$arr_alianza = $ado_arr_alianza->getarray($ado_arr_alianza);

/*echo "<tr><td><pre>";
 print_r($arr_alianza);
 echo "</td></tr>";*/

$arreglos_alianzas = array();


$alianza_user = query($_SESSION['database'],"SELECT * FROM alianzausuario  WHERE estado = 'A' and usuario = '".$usuario."' limit 1;",1,0);
if($alianza_user->recordcount()>0)
$arreglos_alianzas = arrpg_arrphp($alianza_user->fields['concontrol'], false);


?>
<!DOCTYPE html>
<html>
<head>
  <style>
  p { color:red; margin:4px; }
  b { color:blue; }
  </style>
  <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
	<form action="<?php echo $PHP_SELF ?>" method="post">

<?php
	echo "<pre>";
	print_r($arreglos_alianzas);
	?>
	<tr title = 'Mantenga presionada la tecla Ctrl para seleccionar varias opciones'>
	<td>ALIANZA</td>
	<td>
	<select name='concontrol[]' id='concontrol'  style="padding:2px;width:100%;" multiple="multiple" size='3' >
	<?php
		for($i=0;$i<$arr_alianza->recordcount();$i++)
		{
			?>
			<option value = '<?php echo $arr_alianza->fields['concontrol'];?>' <?php if(in_array($arr_alianza->fields['concontrol'], $arreglos_alianzas)) echo "selected"; ?> ><?php echo $arr_alianza->fields['nombresucur']; ?></option>
			<?php
			$arr_alianza->movenext();
		}
	?>
		</select>
	</td>
	</tr>
	<tr><td>
		
	<select multiple="multiple" name="cars[]">
		<option value="volvo">Volvo</option>
		<option value="saab">Saab</option>
		<option value="opel">Opel</option>
		<option value="audi">Audi</option>
	</select>
	</td>
	</tr>
	<input type="submit">
	<button>Alert</button>
</form>
<script>
function valoresarreglo(){
  alert( $("#concontrol").val() || []);
  multipleselects = $("#concontrol").val() || [];
  if(multipleselects == '')
		alert("ENTRO");

}
$("button").click(valoresarreglo);
</script>

</body>
</html>
