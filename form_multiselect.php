<?php
if($_GET["boton"] == "Enviar"){
	echo "<br>".$_GET["user"];
	if($_GET["reprograma_oblig"] == null){
		echo "Unchecked <br>".$_GET["reprograma_oblig"];
		echo var_dump($_GET["reprograma_oblig"]);
    echo "<pre>";
    var_dump($_GET["test"]);
	}
	else
		echo "<br> Checked  ".$_GET["reprograma_oblig"];
}

?>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Select2 : multi-select : get selected values/text : data array - jsFiddle demo by platypusman</title>  
  <script type="text/javascript" src="jquery/ajax/jquery.estable.js"></script>
  <script type="text/javascript" src="jquery/ajax/select2.js"></script>
  <script type="text/javascript" src="jquery/ajax/jquery-ui-1.8.10.custom.min.js"></script>
  <link rel="stylesheet" type="text/css" href="jquery/ajax/select2.css">
  <style type="text/css">
    p { margin: 1em 0; }
  </style>
  <script type="text/javascript">//<![CDATA[ 
    $(function(){
      var test = $('#test');
      $(test).select2({
          data:[
              {id:0,text:"enhancement"},
              {id:1,text:"bug"},
              {id:2,text:"duplicate"},
              {id:3,text:"invalid"},
              {id:4,text:"wontfix"}
          ],
          multiple: true,
          width: "300px"
      });

      $(test).change(function() {
          var selections = ( JSON.stringify($(test).select2('data')) );
          console.log('Selected options: ' + selections);
          $('#selectedText').text(selections);
      });
    });
    
  function gebi(name){
    return document.getElementById(name)
  }
  function vervalores(){
    if(gebi('reprograma_oblig').checked == false){
      alert("No seleccionado reprogramado ");
    }
    else{
      var reprogramaoblig = gebi('reprograma_oblig').value;
      alert("Valor reprogramado "+reprogramaoblig);
    }
    return true
  }
  </script>
</head>
<body>
  <form name="input" action="" method="get">
    <input type="hidden" id="test" tabindex="-1" class="select2-offscreen" name="test">
    <p>Selected Options: <span id="selectedText"></span></p>
    <p>consulta: <input type="text" name="user" /></p>
    Nueva consulta: <input type='checkbox' name = 'reprograma_oblig'  id = 'reprograma_oblig' value = 'S' >
    <input name="boton" onclick="return vervalores();" type="submit" value="Enviar" />
  </form>
</body>
</html>
