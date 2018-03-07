<?php
function conectar()
{
	pg_connect("host=192.168.2.122 port=5432 dbname=fna_credito_20140507 user=root password=");
}

function desconectar()
{
	pg_close();
}
?>