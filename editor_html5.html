<!DOCTYPE HTML>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" lang="es-es">

<title>Editor HTML (v.1.03)</title>

<style>

.opciones {

width: 720px;

border: 2px #000000 solid;

background-color: lightgray;

}



#textBox {

width: 700px;

height: 400px;

border: 2px #000000 solid;

padding: 10px;

overflow: scroll;

background-color: yellow;

}

</style>



<script>

function formatoFuente(sCmd, sValue) {

document.execCommand(sCmd, false, sValue);

}



function processFiles(files) {

var file = files[0];



var reader = new FileReader();



reader.onload = function (e) {

// Cuando se dispara este evento, los datos están disponibles.

// Los copiamos al <div> textBox de la página.

var output = document.getElementById("textBox");

output.innerHTML = e.target.result;

};

reader.readAsText(file);

}



// ---------------------------------------



var dropBox;



window.onload = function() {

dropBox = document.getElementById("textBox");

dropBox.ondragenter = ignoreDrag;

dropBox.ondragover = ignoreDrag;

dropBox.ondrop = drop;

}



function ignoreDrag(e) {

e.stopPropagation();

e.preventDefault();

}



function drop(e) {

e.stopPropagation();

e.preventDefault();



var data = e.dataTransfer;

var files = data.files;



processFiles(files);

}



// ----------------------------------------



function saveData() {

var localData = document.getElementById("textBox").innerHTML;



localStorage["lData"] = localData;

alert(localData);

}



function loadData() {

var localData = localStorage["lData"]; 



if (localData != null) {

document.getElementById("textBox").innerHTML = localData;

}

}



</script>



</head>

<body>

<section class="opciones">

<button onclick="document.execCommand('bold',false,'');">Negrilla</button>

<button onclick="document.execCommand('italic',false,'');">Itálica</button>

<button onclick="document.execCommand('underline',false,'');">Subrayado</button>



<select onchange="formatoFuente('formatblock',this[this.selectedIndex].value);this.selectedIndex=0;">

<option class="heading" selected>Formato</option>

<option value="<h1>">Cabecera &lt;h1&gt;</option>

<option value="<h2>">Título &lt;h2&gt;</option>

<option value="<h3>">Título &lt;h3&gt;</option>

<option value="<h4>">Título &lt;h4&gt;</option>

<option value="<h5>">Título &lt;h5&gt;</option>

<option value="<h6>">Título &lt;h6&gt;</option>

<option value="<p>">Párrafo &lt;p&gt;</option>

<option value="<pre>">Preformateado &lt;pre&gt;</option>

</select>



<button onclick="if (document.getElementById('szURL').checkValidity()) { 

document.execCommand('CreateLink',false,document.getElementById('szURL').value);}">Hiperenlace</button>

<input type="url" id="szURL" required>

<select onchange="formatoFuente('forecolor',this[this.selectedIndex].value);this.selectedIndex=0;">

<option class="heading" selected>Color</option>

<option value="red">Rojo</option>

<option value="blue">Azul</option>

<option value="green">Verde</option>

<option value="black">Negro</option>

</select>

</section>

<section class="opciones">

<button onclick="document.execCommand('insertunorderedlist',false,'');">Bolillos</button>

<button onclick="document.execCommand('insertorderedlist',false,'');">Lista</button>

<button onclick="document.execCommand('justifyleft',false,'');">Izqda.</button>

<button onclick="document.execCommand('justifycenter',false,'');">Centro</button>

<button onclick="document.execCommand('justifyright',false,'');">Drcha.</button>

<button onclick="document.execCommand('cut',false,'');">Cortar</button>

<button onclick="document.execCommand('copy',false,'');">Copiar</button>

<button onclick="document.execCommand('paste',false,'');">Pegar</button>

<select onchange="formatoFuente('fontsize',this[this.selectedIndex].value);this.selectedIndex=0;">

<option class="heading" selected>Fuente</option>

<option value="1">Muy pequeña</option>

<option value="2">Pequeña</option>

<option value="3">Normal</option>

<option value="4">Media</option>

<option value="5">Grande</option>

<option value="6">Muy grande</option>

<option value="7">Enorme</option>

</select>

</section>



<div id="textBox" contenteditable="true">

<h1 style="color:red">Título</h1>

<p>Escribir aquí...</p> 

</div>



<section class="opciones">

<input id="fileInput" type="file" onchange="processFiles(this.files)">...Insertar archivo de texto

</section>

<div class="opciones">

<button onclick="saveData()">Guardar</button>

<button onclick="loadData()">Recuperar</button>

</div>

</body>

</html>
