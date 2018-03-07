<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>jQuery UI Tooltip - Custom content</title>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	<link rel="stylesheet" href="/resources/demos/style.css" />
	<style>
	#pop {
   z-index:2;
   position:absolute;
   border: 1px solid #333333;
   text-align:center;
   background:#000000;
}
#cerrar {
   float:right;
   margin-right:5px;
   cursor:pointer;
   font:Verdana, Arial, Helvetica, sans-serif;
   font-size:12px;
   font-weight:bold;
   color:#FFFFFF;
   background-color:#666666;
   width:12px;
   position:relative;
   margin-top:-1px;
   text-align:center;
}
</style>

<script>
function mostrar() {
   $("#pop").fadeIn('slow');
} //checkHover
</script>

<div id="pop">
   <div id="cerrar">X</div>
   <img src="imgages/publicidad.jpg" height="507" width="600" border="0"> 
</div>
