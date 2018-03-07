<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload de archivos</title>
</head>
<body>
  <?php
    $pesoMaximo = 3000000;
    $maxsize = ini_get('upload_max_filesize');
    $pesolimite = obtieneMaxUploadSize($maxsize);
    $maximoPermitido = ($pesolimite < $pesoMaximo)?  $pesolimite: $pesoMaximo;
    function obtieneMaxUploadSize ($size_str)
    {
      switch (substr ($size_str, -1))
      {
        case 'M': case 'm': return (int)$size_str * 1048576;
        case 'K': case 'k': return (int)$size_str * 1024;
        case 'G': case 'g': return (int)$size_str * 1073741824;
        default: return $size_str;
      }
    }
    echo $pesolimite;
    if(isset($subir)){
      $peso=$_FILES['archivo']['size'];
      echo $peso;
    }
  ?>
    <form enctype="multipart/form-data" id="formupload" name="formupload" method="post" action = 'index.php' onsubmit='return valida_archivo()'>
        <br />
        <input  type="file" id="archivo" name="archivo"/>
        <br />
        <input type="submit" id="subir" value="Subir archivos"/>
    </form>
    <script>
    function valida_archivo()
    {
      var file = document.getElementById('archivo').files[0];
      //obtenemos el nombre del archivo
      var fileName = file.name;
      //obtenemos la extensión del archivo
      fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
      //obtenemos el tamaño del archivo
      var fileSize = file.size;
      //obtenemos el tipo de archivo image/png ejemplo
      var fileType = file.type;
      //mensaje con la información del archivo
      
      alert(fileSize);

      if (document.formupload.archivo.value == "")
      { alert('Debe elegir un documento y escribir su descripci\xf3n');
        return false;
      }		        
      if(fileSize >= <?php echo $maximoPermitido ?>){
        alert("Archivo sobrepasa el peso limite");
        return false;
      }
      else return true;
    }
    </script>
    </body>
</html>

