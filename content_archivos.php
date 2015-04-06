<?php
if( $fp=@fopen('archivos/criterios.png', "rb") )
{
    $data = fread($fp,filesize('archivos/criterios.png'));
    @fclose($fp);
    $codedImage = base64_encode($data);
}
echo $codedImage;
