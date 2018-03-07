<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>PHP Security</title>
<link rel="stylesheet" href="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
</head>
<body>
 
<div class="top-bar">
<div class="top-bar-left">
<ul class="menu">
<li class="menu-text">Curso Seguridad PHP</li>
</ul>
</div>
</div>
 
<div class="row column text-center">
<h2>Brute Force</h2>
<hr>
</div>
<div class="row column">
<div class="callout primary">
<h3>Ingreso</h3>
</div>
<form method="post" id="frmLogin">
  <div class="row">
    <div class="medium-6 columns">
      <label>Ingrese la contraseña
        <input type="password" name="password" id="passwdPassword">
        <input class="button secondary" type="submit" value="MODIFICAR" id="btnUpdate" />
        
      </label>
      <p class="help-text">La contraseña debe tener ...</p>
    </div>
    <div class="medium-6 columns">
      <label>&nbsp;
      </label>
    </div>
  </div>
</form>
</div>
<hr>


</div>
<div class="large-3 large-offset-2 columns">
</div>
</div>
<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="http://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
<script>
      $(document).foundation();
      function init()
      {
      	$('#btnUpdate').on('click', function(evt){
      		evt.preventDefault();
      		
			$.ajax({
			   method: 'POST',
			   url: 'login.php',
			   data: $('#frmLogin').serialize(),
			   success: function(data, text_code)
			   {
			   		
			   		alert('Contraseña correcta');
			   },
			   error: function(data, text_code)
			   {
			   		
			   		alert('Contraseña errónea');
			   }
			});
      	});
      }

      $(init);
    </script>
</body>
</html>
