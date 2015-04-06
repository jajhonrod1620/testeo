<?php
ini_set('session.cache_limiter','');
header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: no-cache');
session_start();
include_once($DOCUMENT_ROOT.'/padminfo/sql/consultasADODB.php');
include_once($DOCUMENT_ROOT.'/padminfo/includes/labels.php');
include_once($DOCUMENT_ROOT.'/padminfo/includes/funcion_alerta.php');

$nom_programa='creausurios';
labels('alianzausuario, nue_usuario,software',$GLOBALS['idioma']);
//echo $LABELS['software']['dias_para_inactivar']."<br>";

/**
 * Filtro por el cual se decide si esta informacion de guarda como nueva en las bases de datos o
 * se actuliza.
 */
// Verificar que esta guardando informacion...

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
    //echo $s. "el valor<br>";
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



if( isset( $accion ) )
{
  // Preguntar que tipo de accion se quiere realizar...
  switch($accion)
  { 
    case $LABELS['generico']['guardar']:
      if($nuevo=='V')
      { 
        $codigo = GuardarNuevo( );
      }
      else
      { 
        $codigo = Guardar( );
      }
      Interface2($codigo);
      break;

		case $LABELS['generico']['eliminar']:
      $existe=selectlimit("'x'","nue_usuario","codigo='".$_POST['codigo_usuario']."' and usergrup.usuario='".$_POST['codigo_usuario']."'","","1",0,1);
      if($existe->RecordCount()==0)
      {
        delete("nue_usuario","codigo='".$_POST['codigo_usuario']."'",0,1);
        #-------BD-------
        //$conex=ADONewConnection("postgres");
        //$conex->Connect('localhost','root','','bd');
				$conex=ADONewConnection($_SESSION['BDGeneral']['motor']);
        $conex->Connect($_SESSION['BDGeneral']['ip'],$_SESSION['BDGeneral']['usuario'],$_SESSION['BDGeneral']['clave'],'BDGeneral');

        $rs=$conex->Execute("DELETE FROM software WHERE codigo_usuario='".$_POST['codigo_usuario']."' and nombrebd='".$GLOBALS['nombrebd']."'");
        $conex->close();
        #-----FIN BD-----
        #-------AGENDA---------
        /*
				$conexag=ADONewConnection("postgres");
				$conexag->Connect('localhost','root','','webcalendar');
				$consultaag=$conexag->Execute("DELETE FROM webcal_user WHERE cal_login='".trim($_POST['codigo_usuario'])."'");
				$conexag->close();
				*/
        #-----FIN-AGENDA-------
        alerta(15);
        Interface2($_POST['codigo_usuario']);
      }
      else
      {
        alerta(18);
        Interface2($_POST['codigo_usuario']);
      }
    break;
  }
}
else
{ 
  Interface2( $codigo );
}

/**
 * Guardar un nuevo registro en la tabla nue_usuario en la base de datos local y en software en
 * la base de datos bd... 
 * @return string nombre de usuario
 * @author Jonathan Espinal (John...)
 */ 
function GuardarNuevo( )
{
 if($_POST['regional']==""){
  $_POST['regional']=1;
 }
  // print_r( $_POST );
  // exit( );
  
  // Las globales pertinetes...
  Global $PHP_SELF, $GLOBALS, $_POST, $_GET, $db, $DOCUMENT_ROOT, $LABELS;
  $fecha_grab = date( 'Y-m-d' );
  
  // Buscar existencia en la base de datos local...
  $existe = select( "'x'", "nue_usuario", "codigo='" . $_POST['codigo_usuario'] . "'", "",0, 1 );
  
  // Verificar si no existe...
  if( $existe->RecordCount( ) == 0 )
  {
    // Conectar a la base de datos bd
    $conex=ADONewConnection($_SESSION['BDGeneral']['motor']);
    $conex->Connect($_SESSION['BDGeneral']['ip'],$_SESSION['BDGeneral']['usuario'],$_SESSION['BDGeneral']['clave'],'BDGeneral');
    
    //$conex = ADONewConnection( "postgres" );
    //$conex->Connect( 'localhost', 'root', '', 'bd' );
    
    // Busca existencia en la base de datos bd...
    $sqlBuscaExistecia = "
    SELECT
      'x'
    FROM
      software
    WHERE
      codigo_usuario = '" . trim($_POST['codigo_usuario']) . "' and
      nombrebd = '" . $GLOBALS['nombrebd'] . "'
    ;";
    $rs = $conex->Execute( $sqlBuscaExistecia );
    
    // Verificar existencia...
    if( $rs->RecordCount( ) == 0 )
    {
      // Buscar la contraseÃ±a anterior...
      if ( empty( $LABELS['software']['tipo']) === FALSE )
      $solclaveplano=",claveplanos ";
      $sqlBuscaClaveAnterior = "
      SELECT
        clave ".$solclaveplano."
      FROM
        software
      WHERE
        codigo_usuario = '" . trim( $_POST['codigo_usuario'] ) . "'
      ;"; 
      $clavevie = $conex->Execute( $sqlBuscaClaveAnterior );
      
      // Perguntar por la contraseÃ±a...
      if( $clavevie->RecordCount( ) == 0 )
      {
        $clave = sha1( $_POST['clave'] );
				$clave=sha1("4dm1nf0".md5(sha1($_POST['clave'])));
        if($_POST['tipo']=="S")
				{
					//echo $DOCUMENT_ROOT.$_POST['rutadescarga'];
					if(!file_exists($DOCUMENT_ROOT.$_POST['rutadescarga']))
					mkdir( $DOCUMENT_ROOT.$_POST['rutadescarga'], 0777 );
					//echo $DOCUMENT_ROOT.$_POST['rutadescarga']."/.htaccess";
					if(file_exists($DOCUMENT_ROOT.$_POST['rutadescarga']."/.htaccess"))
					unlink( $DOCUMENT_ROOT.$_POST['rutadescarga']."/.htaccess");
					$archivo=fopen($DOCUMENT_ROOT.$_POST['rutadescarga']."/.htaccess",'a+') or die('Error de apertura');

					fputs($archivo, "AuthName \"Adminfo Requiere clave para Entrar a esta direccion\"\n");
					fputs($archivo, "AuthType Basic\n");
					fputs($archivo, "Auth_PG_database bd\n");
					fputs($archivo, "Auth_PG_pwd_table software\n");
					fputs($archivo, "Auth_PG_uid_field codigo_usuario\n");
					fputs($archivo, "Auth_PG_pwd_field claveplanos\n");
					fputs($archivo, "Auth_PG_hash_type md5\n");
					fputs($archivo, "Auth_PG_pwd_whereclause \" and estado='A' and tipo='S' \"\n");
					fputs($archivo, "require user ".$_POST['codigo_usuario']."\n");
					fclose($archivo);
					$claveplanos="md5('".$_POST['clave']."')";
 
				}
			 else
			 $claveplanos="''";
			}
			else
			{
				$clave = $clavevie->fields['clave'];
				$claveplanos="'".$clavevie->fields['claveplanos']."'";
			}      
      // Insertar valores en la tabla software de la base de datos bd...
			if ( empty( $LABELS['software']['dias_para_inactivar']) === FALSE )
			{
				$camposinsert=",dias_para_inactivar";

				$campoinsert2= ",".$_POST['diasparainactivar'];

			}

			if ( empty( $LABELS['software']['tipo']) === FALSE )
			{
				$camposinsert=$camposinsert.",tipo,rutadescarga,claveplanos";

				$campoinsert2= $campoinsert2.",'".$_POST['tipo']."','".$_POST['rutadescarga']."',".$claveplanos."";

			}
			$fecha_grab = date('Y-m-d');

      $sqlInsertaEnSoftware = "
      INSERT INTO
      software
      (
      	host,
      	nombrebd,
      	nombres,
      	codigo_usuario,
      	puerto,
      	CasaCobranza,
      	nit,
      	clave,
      	fecha_i,
      	fecha_f,
      	hora_i,
      	hora_f,
      	estado,
      	dias_validez,
      	idioma,
      	usuagenda,
      	tipo_clave,
      	cambiar_clave,
      	fecha_act_clave,
				tipobd,
				usuariobd,
				empresa,
				lunes,
				martes,
				miercoles,
				jueves,
				viernes,
				sabado,
				domingo,
      	superusuario".$camposinsert."
      )
      VALUES
      (
        '".$GLOBALS['servidor']."',
        '" . $GLOBALS['nombrebd'] . "',
        '" . trim( $_POST['nombre'] ) . "',
        '" . strtolower(trim( $_POST['codigo_usuario'] )) . "',
        5432,
        '" . $_POST['empresa'] . "',
        '" . $_POST['nit'] . "',
        '" . $clave . "',
        '" . $_POST['fecha_i'] . "',
        '" . $_POST['fecha_f'] . "',
        '" . $_POST['hora_i'] . "',
        '" . $_POST['hora_f'] . "',
        '" . $_POST['estado'] . "',
        '" . $_POST['dias_validez_clave'] . "',
        '" . $_POST['idioma'] . "',
        'N',
        'SHA1',
        'S',
        '".$fecha_grab."',
				'postgres',
				'root',
				'tuya',
				'6:00 - 23:30',
				'6:00 - 23:30',
				'6:00 - 23:30',
				'6:00 - 23:30',
				'6:00 - 23:30',
				'6:00 - 23:30',
				'6:00 - 23:30',
        '" . $_REQUEST['superusuario'] . "' ".$campoinsert2."
      )
      ;"; 

      
			$rs = $conex->Execute( $sqlInsertaEnSoftware );
			//echo "<br> guarda nuevo 297 - ".$sqlInsertaEnSoftware;

    }
    // Cerrar la conexion anterior...
    $conex->close();

	
	//*******
	$conex=ADONewConnection($_SESSION['BDGeneral']['motor']);
	$conex->Connect($_SESSION['BDGeneral']['ip'],$_SESSION['BDGeneral']['usuario'],$_SESSION['BDGeneral']['clave'],'BDGeneral');
//$conex = ADONewConnection("postgres");
 // $conex->Connect('localhost','root','','bd');
  
 /* $sqlBuscaEmpresanit = "
  SELECT
    distinct nit_empresa
  FROM
    cantidadterm
  WHERE
    nombrebd = '" . $GLOBALS['nombrebd'] . "'
    and nombreempresa <> 'solati'
	and nombreempresa='" . $_POST['empresa'] . "';";
*/


		$sqlBuscaEmpresanit =" select distinct empresas.nit_empresa from software, empresas  where empresas.CasaCobranza=software.CasaCobranza and  software.nombrebd ='".$GLOBALS['nombrebd']."' and software.CasaCobranza not like 'solati'  and  software.CasaCobranza='" . $_POST['empresa'] . "'  order by software.CasaCobranza asc; ";

		$objBuscaEmpresanit = $conex->Execute( $sqlBuscaEmpresanit );
		$strEmpresanit = $objBuscaEmpresanit->fields['nit_empresa']; 
		$objBuscaEmpresanit->MoveNext( );

		$conex->close( );

/* programa viejo
$consultacampos=select("tabla_asociada,link_asociado,descrip_asociada,nom_variable,nom_tabla,tipo_campo,label_pred,alias,ordenamiento,nom_campo,query_campo","ncampos_tablas","nom_programa='usuarios' and mostrar='S'","ordenamiento",0,1);

for( $r=0; $r < $consultacampos->RecordCount(); $r++ ) {
	// si no se setea el campo ciudad, se pone a NULL
	if($consultacampos->fields['nom_campo'] == 'conciudad'){
		$agregarcampo2 = $agregarcampo2 . " , NULL";
	}
	else {
		$agregarcampo2 = $agregarcampo2." ,'".$_POST[$consultacampos->fields['nom_campo']]."'";
	}
	$agregarcampo=$agregarcampo." ,".$consultacampos->fields['nom_campo'];
	
	$consultacampos->movenext();
}*/

	
	/***************/
	
	
	
    // Insertar campos en la tabla nue_usuario en la base de datos local...
    $campos = "
    codigo,
    nombre,
    nit,
    fecha_i,
    fecha_f,
    autoriza,
    fecha,
    clave,
    prioridad,
    regional,
    estado,
    grabador,
		nit_empresa,
    hora_i,
    hora_f,
    idioma ".$agregarcampo."
    ";
    
    $valores = "
    '" . strtolower(trim( $_POST['codigo_usuario'] )) . "',
    '" . trim( $_POST['nombre'] ) . "',
    '" . $_POST['nit'] . "',
    '" . $_POST['fecha_i'] . "',
    '" . $_POST['fecha_f'] . "',
    'admon',
    '" . $fecha_grab . "',
    '" . $clave . "',
    '1',
    '" . $_POST['regional'] . "',
    '" . $_POST['estado'] . "',
    '" . $GLOBALS['usuario'] . "',
	'" . $strEmpresanit . "',
    '" . $_POST['hora_i'] . "',
    '" . $_POST['hora_f'] . "',
    '" . $_POST['idioma'] . "' ".$agregarcampo2."
    ";
    
		insert( "nue_usuario", $campos, $valores, 0, 1);
		
		$alianzas = arrphp_arrpg ($_POST['concontrol']);

		//insertamos en la tabla alianzausuarios la o las alianzas seleccionadas
		insert("alianzausuario" ,"usuario, concontrol, estado, fecha_grab" , "'" . strtolower(trim( $_POST['codigo_usuario'] )) . "', $alianzas, 'A', '".$fecha_grab."'", 0,0);
    
    
    
    if( empty( $_POST['grupo'] ) === false )
    {
      foreach( $_POST['grupo'] as $intIndex => $intValor )
      {
        if( empty( $intValor ) === false )
        {
		      $campos = "
		      usuario,
		      grupo,
		      estado,
		      grabador,
		      fecha
		      ";
		      
		      $valores = "
		      '" . strtolower(trim( $_POST['codigo_usuario'] )) . "',
		      '" . $intValor . "',
		      'A',
		      '" . $GLOBALS['usuario'] . "',
		      '" . date('Y-m-d') . "'
		      ";
		      
		      insert( "usergrup", $campos, $valores, 0, 1 );
        }
      }
    }
    
    
    
    
    alerta(14);
  }
  else
  { 
    alerta(19);
  }
  return $_POST['codigo_usuario'];
}


/**
 * Actualiza la informacion que proviene de la forma y hace las respectivas actualizaciones en 
 * las bases de datos correspondientes...
 * @return void
 * @author Jonathan Espinal (John...)
 */
function Guardar()
{
   //print_r( $_POST );
	if($_POST['regional']==""){
		$_POST['regional']=1;
	}
   Global $PHP_SELF, $GLOBALS, $_POST, $_GET, $db, $DOCUMENT_ROOT, $LABELS;
   $fecha_grab = date('Y-m-d');

   // Conectar con la base de datos bd...
   
		$conex=ADONewConnection($_SESSION['BDGeneral']['motor']);
		$conex->Connect($_SESSION['BDGeneral']['ip'],$_SESSION['BDGeneral']['usuario'],$_SESSION['BDGeneral']['clave'],'BDGeneral');
		//$conex=ADONewConnection("postgres");
		// $conex->Connect('localhost','root','','bd');

   // Busca la clave y el tipo para ser comparadas con la nueva...
		if ( empty( $LABELS['software']['tipo']) === FALSE )
					$solclaveplano=",claveplanos ";
				
			 $sqlBuscaClaveYTipo = "
			 SELECT
					clave,
					tipo_clave ".$solclaveplano."
			 FROM
					software
			 WHERE
					codigo_usuario = '" . $_POST['codigo_usuario'] . "' and
					nombrebd = '" . $GLOBALS['nombrebd'] . "'
			 ;";
			 $clavevie = $conex->Execute( $sqlBuscaClaveYTipo );

		if($_POST['tipo']=="S")
		{
		if(!file_exists($DOCUMENT_ROOT.$_POST['rutadescarga']))
						 mkdir( $DOCUMENT_ROOT.$_POST['rutadescarga'], 0777 );
						 //echo $DOCUMENT_ROOT.$_POST['rutadescarga']."/.htaccess";
						 if(file_exists($DOCUMENT_ROOT.$_POST['rutadescarga']."/.htaccess"))
						 unlink( $DOCUMENT_ROOT.$_POST['rutadescarga']."/.htaccess");
						$archivo=fopen($DOCUMENT_ROOT.$_POST['rutadescarga']."/.htaccess",'a+') or die('Error de apertura');
					 
					 fputs($archivo, "AuthName \"Adminfo Requiere clave para Entrar a esta direccion\"\n");
					 fputs($archivo, "AuthType Basic\n");
					 fputs($archivo, "Auth_PG_database bd\n");
					 fputs($archivo, "Auth_PG_pwd_table software\n");
					 fputs($archivo, "Auth_PG_uid_field codigo_usuario\n");
					 fputs($archivo, "Auth_PG_pwd_field claveplanos\n");
					 fputs($archivo, "Auth_PG_hash_type md5\n");
					 fputs($archivo, "Auth_PG_pwd_whereclause \" and estado='A' and tipo='S' \"\n");
					 fputs($archivo, "require user ".$_POST['codigo_usuario']."\n");
					 fclose($archivo);
		}
 
   if( $clavevie->fields['clave'] != $_POST['clave'] )
   {
      $clavediferente = 'V';
      $clave = sha1( $_POST['clave'] );
      $clave=sha1("4dm1nf0".md5(sha1($_POST['clave'])));
      $cambiar_clave = "S";
      $tipo_clave = 'SHA1';
      if($_POST['tipo']=="S")
      {
         //echo $DOCUMENT_ROOT.$_POST['rutadescarga'];
         
       $claveplanos="md5('".$_POST['clave']."')";
     }
       else
       $claveplanos="";
   }
   else
   {
      $clavediferente = 'F';
      $cambiar_clave = "N";
      $clave = $clavevie->fields['clave'];
      $tipo_clave = $clavevie->fields['tipo_clave'];
      $claveplanos="'".$clavevie->fields['claveplanos']."'";
   }
  
   // Registro de logs...
   //ojo verificar que el campo "nom_tabla" y tipo_campo esten seleccionados en la consulta de ncampos_tablas
   // ??
   $consulta = select( "nom_campo, nom_tabla, tipo_campo", "ncampos_tablas", "mostrar = 'S' and nom_programa = 'software' and tipo_campo not in ( 'inf', 'externo', 'titulo' )", "", 0, 1 );
   $pantallas = select( "log_cambios, llave", "pantallas", "nom_programa = '".$_REQUEST['nom_programa'] . "'", "", 0, 1);
  
   if($pantallas->fields['log_cambios']=="S")
   {
      $sql_log = $conex->Execute( "SELECT * FROM software WHERE codigo_usuario='".$_REQUEST['codigo_usuario']."' and nombrebd='".$GLOBALS['nombrebd']."';");
      $consulta->Move(0);
      $nota_cambio='';
      for($j=0; $j<$consulta->RecordCount(); $j++)
      {
         if($consulta->fields['tipo_campo']!='hidden' && $consulta->fields['tipo_campo']!='fgrab' &&    $consulta->fields['tipo_campo']!='global' && $consulta->fields['tipo_campo']!='titulo')
         {
            if(trim($sql_log->fields[$consulta->fields['nom_campo']])!=trim($_REQUEST[$consulta->fields['nom_campo']]))
            {
               $nota_cambio.="<font color=\"#000080\">".$consulta->fields['nom_campo']."</font> [".$sql_log->fields[$consulta->fields['nom_campo']]."] por [".$_REQUEST[$consulta->fields['nom_campo']]."], ";
            }
         }
         $consulta->MoveNext();
      }
   }
  
		// Actualizar datos en software...

		if ( empty( $LABELS['software']['dias_para_inactivar']) === FALSE )
		{
			$campoupdate=",dias_para_inactivar=".$_POST['diasparainactivar'];
		}
		if ( empty( $LABELS['software']['tipo']) === FALSE )
		{
			$campoupdate=$campoupdate.",tipo='".$_POST['tipo']."',rutadescarga='".$_POST['rutadescarga']."',claveplanos=".$claveplanos."";

		}
		/* programa viejo
		$sqlBuscaEmpresanit = "
			SELECT
				distinct nit_empresa
			FROM
				cantidadterm
			WHERE
				nombrebd = '" . $GLOBALS['nombrebd'] . "'
				and nombreempresa <> 'solati'
		 and nombreempresa='" . $_POST['empresa'] . "';";
			
			$objBuscaEmpresanit = $conex->Execute( $sqlBuscaEmpresanit );
			$strEmpresanit = $objBuscaEmpresanit->fields['nit_empresa']; 

		//echo $strEmpresanit."esta es <br>";
		*/

   $sqlActulizaDatosSoftware = "
   UPDATE
   software
   SET
     CasaCobranza='" . $_POST['empresa'] . "',
      nit='".$_POST['nit']."',
      superusuario     = '" . $_POST['superusuario']."',
      cambiar_clave    = '" . $cambiar_clave . "',
      clave            = '" . $clave . "',
      tipo_clave       = '" . $tipo_clave . "',
      fecha_i          = '" . $_POST['fecha_i'] . "',
      fecha_f          = '" . $_POST['fecha_f'] . "',
      hora_i           = '" . $_POST['hora_i'] . "',
      hora_f           = '" . $_POST['hora_f'] . "',
      estado           = '" . $_POST['estado'] . "',
      dias_validez = '" . $_POST['dias_validez_clave'] . "',
      idioma           = '" . $_POST['idioma'] . "',
      usuagenda        = 'N' ".$campoupdate."
   WHERE
      codigo_usuario = '" . $_POST['codigo_usuario'] . "'
   ;";   
   $rs = $conex->Execute( $sqlActulizaDatosSoftware );

/* programa viejo
$sqlActulizaEmpresa = "
   UPDATE
   software
   SET
     empresa='" . $_POST['empresa'] . "'
   WHERE
      codigo_usuario = '" . $_POST['codigo_usuario'] . "' and nombrebd='".$GLOBALS['nombrebd']."';";
   $rs2 = $conex->Execute( $sqlActulizaEmpresa );
*/
   $conex->close();
//echo $sqlActulizaDatosSoftware."<br>";
   //print_r($_POST['grupo']);

   $consultaperfiles=query ("select usuario,grupo,grupos.nombre_grupo from usergrup where usuario='".$_POST['codigo_usuario']."' and estado='A' and usergrup.grupo=grupos.consgrupo ",0,0);
   for($i=0;$i<$consultaperfiles->recordcount();$i++)
   { 
      $borrados[$consultaperfiles->fields['grupo']]='S';
      $nombregrupo[$consultaperfiles->fields['grupo']]=$consultaperfiles->fields['nombre_grupo'];
      $consultaperfiles->movenext();
   }
   $consultaperfiles->movefirst();
   //print_r($borrados);
   if( empty( $_POST['grupo'] ) === false )
   { 
      foreach( $_POST['grupo'] as $intIndex => $intValor )
      {
         $consultaperfiles->movefirst();
         $yaexiste=0;
         for($i=0;$i<$consultaperfiles->recordcount();$i++)
         {
            if($consultaperfiles->fields['grupo']==$intValor)
            {
               $yaexiste=1;
               $borrados[$consultaperfiles->fields['grupo']]='N';
            }
            $consultaperfiles->movenext();
         }
         if($yaexiste==0)
         {
            $campos = "
            usuario,
            grupo,
            estado,
            grabador,
            fecha
            ";
            $valores = "
            '" . trim( $_POST['codigo_usuario'] ) . "',
            '" . $intValor . "',
            'A',
            '" . $GLOBALS['usuario'] . "',
            '" . date('Y-m-d') . "'
            ";
            $revicerrado=query("select usuario,grupo from usergrup where usuario='".$_POST['codigo_usuario']."' and grupo='".$intValor."' and  estado='C'",0,0);

            if($revicerrado->recordcount()>0)
               query ("update usergrup set estado='A',fecha_cierre=null,grabador='".$GLOBALS['usuario']."' where grupo='".$intValor."' and usuario='".trim( $_POST['codigo_usuario'] )."'",0,0);
            else
               insert( "usergrup", $campos, $valores, 0, 1 );

            $nombgruponuevo=query("select nombre_grupo from grupos where consgrupo='".$intValor."'",0,0);

            $nota_cambio .= "<font color=\"#000080\"> agrego el usuario".trim( $_POST['codigo_usuario'] ). " al perfil ".$nombgruponuevo->fields['nombre_grupo']." ,";
         } 
      }
   }

   if (count($borrados)>0)
   {
      foreach( $borrados as $borIndex => $borValor )
      {
         if($borValor=="S")
         {  
            query ("update usergrup set estado='C',fecha_cierre=date(now()),grabador='".$GLOBALS['usuario']."' where grupo='".$borIndex."' and usuario='".trim( $_POST['codigo_usuario'] )."'",0,0);
   //echo $borIndex."<br>";

            $nota_cambio .= "<font color=\"#000080\"> desvinculo el usuario ".trim( $_POST['codigo_usuario'] ). " del perfil ".$nombregrupo[$borIndex]." ,";
      
         }
      }
   }
/*
  if( empty( $_POST['grupo'] ) === false )
  {
    //delete( 'usergrup', "usuario = '" . $_POST['codigo_usuario'] . "'", 1, 1 );
    foreach( $_POST['grupo'] as $intIndex => $intValor )
    {
      if( empty( $intValor ) === false )
      {
        $campos = "
        usuario,
        grupo,
        estado,
        grabador,
        fecha
        ";
        
        $valores = "
        '" . trim( $_POST['codigo_usuario'] ) . "',
        '" . $intValor . "',
        'A',
        '" . $GLOBALS['usuario'] . "',
        '" . date('Y-m-d') . "'
        ";
          
        insert( "usergrup", $campos, $valores, 0, 1 );
      }
    }
  }
  
*/

  // log cambios de la tabla nue_usuario
  // ojo verificar que el campo "nom_tabla" y tipo_campo esten seleccionados en la consulta de ncampos_tablas
  // ??
   $consulta = select( "nom_campo, nom_tabla, tipo_campo", "ncampos_tablas", "mostrar = 'S' and nom_programa = '" . $_REQUEST['nom_programa'] . "' and tipo_campo not in ( 'inf','externo','titulo' )", "", 0, 1 );
   $pantallas = select( "log_cambios, llave", "pantallas", "nom_programa = '" . $_REQUEST['nom_programa'] . "'", "", 0, 1);
  
   if( $pantallas->fields['log_cambios'] == "S" )
   {
      $sql_log = select( "*", "nue_usuario", "codigo = '" . $_REQUEST['codigo_usuario'] . "'", "", 0, 1 );
      $consulta->Move(0);
      for( $j = 0; $j < $consulta->RecordCount( ); $j++ )
      {
         if( $consulta->fields['tipo_campo'] != 'hidden' && $consulta->fields['tipo_campo'] != 'fgrab' &&   $consulta->fields['tipo_campo']!='global' && $consulta->fields['tipo_campo'] != 'titulo' )
         {
        
            if( trim( $sql_log->fields[$consulta->fields['nom_campo']] ) != trim(    $_REQUEST[$consulta->fields['nom_campo']] ) )
            {
               $nota_cambio .= "<font color=\"#000080\">" . $LABELS[$consulta->fields['nom_tabla']][$consulta->fields['nom_campo']] . "</font> [" . $sql_log->fields[$consulta->fields['nom_campo']] . "] por [" . $_REQUEST[$consulta->fields['nom_campo']] . "], ";
            }
         }
         $consulta->MoveNext();
      }
      $fecha_grab = date('Y/m/d');
      $hora_grab = date('H:i:s');
      if( trim( $nota_cambio ) != "" )
      {
         insert( "log_tablas", "llave, val_llave, nom_programa, nota, grabador, fecha_grab, hora_grab", "'" . $pantallas->fields['llave'] . "','" . $_REQUEST['codigo_usuario'] . "','" . $_REQUEST['nom_programa'] . "','$nota_cambio','" . $GLOBALS['usuario'] . "','$fecha_grab','$hora_grab'", 0, 1);
      }
   }
#--Fin log_cambios-----------------------------------------------------------------------------------------------------

/* programa viejo
// se setena otros campos para la tabla nue_usuario
$consultacampos=select("tabla_asociada,link_asociado,descrip_asociada,nom_variable,nom_tabla,tipo_campo,label_pred,alias,ordenamiento,nom_campo,query_campo","ncampos_tablas","nom_programa='usuarios' and mostrar='S'","ordenamiento",0,1);
for($r=0; $r<$consultacampos->RecordCount(); $r++)
{
	// Verificamos si se actualizo la ciudad.
	if( $consultacampos->fields['nom_campo']  == 'conciudad' && $_POST['nomconciudad'] == ""){
		$agregarcampo=$agregarcampo." ,".$consultacampos->fields['nom_campo']." = NULL";
	}
	else {
		$agregarcampo=$agregarcampo." ,".$consultacampos->fields['nom_campo']." = '".$_POST[$consultacampos->fields['nom_campo']]."'";
	}
	
	//$agregarcampo2=$agregarcampo2." ,'".$_POST[.$consultacampos->fields['nom_campo']]."'";
	$consultacampos->movenext();
}*/

		$conex=ADONewConnection($_SESSION['BDGeneral']['motor']);
		$conex->Connect($_SESSION['BDGeneral']['ip'],$_SESSION['BDGeneral']['usuario'],$_SESSION['BDGeneral']['clave'],'BDGeneral');
  // $conex = ADONewConnection("postgres");
  //$conex->Connect('localhost','root','','bd');
  
  /* $sqlBuscaEmpresanitu = "
  SELECT
    distinct nit_empresa
  FROM
    cantidadterm
  WHERE
    nombrebd = '" . $GLOBALS['nombrebd'] . "'
    and nombreempresa <> 'solati'
	and nombreempresa='" . $_POST['empresa'] . "';";
 */
$sqlBuscaEmpresanitu=" select distinct empresas.nit_empresa from software, empresas  where empresas.CasaCobranza=software.CasaCobranza and  software.nombrebd ='".$GLOBALS['nombrebd']."' and software.CasaCobranza!='solati' and software.CasaCobranza='" . $_POST['empresa'] . "' order by software.CasaCobranza asc; ";
 
  $objBuscaEmpresanitu = $conex->Execute( $sqlBuscaEmpresanitu );
  $strEmpresanitu = $objBuscaEmpresanitu->fields['nit_empresa']; 
    $objBuscaEmpresanitu->MoveNext( );

  $conex->close( );
  
   $campos = "
   nit='".$_POST['nit']."',
   nombre = '" . trim( $_POST['nombre'] ) . "',
   fecha_i = '" . $_POST['fecha_i'] . "',
   fecha_f = '" . $_POST['fecha_f'] . "',
   autoriza = 'admon',
   fecha = '" . $fecha_grab . "',
   clave = '" . $clave . "',
   prioridad = '1',
   regional = '" . $_POST['regional'] . "',
   estado = '" . $_POST['estado'] . "',
   grabador = '" . $GLOBALS['usuario'] . "',
   idioma = '" . $_POST['idioma'] . "',
   nit_empresa = '" . $strEmpresanitu . "' ".$agregarcampo."

   ";

   update( "nue_usuario", $campos, "codigo = '" . $_POST['codigo_usuario'] . "'", 0, 1);
   
   //insert("alianzausuario" ,"usuario, concontrol, estado, fecha_grab" , "'" . strtolower(trim( $_POST['codigo_usuario'] )) . "', $alianzas, 'A', '".$fecha_grab."'", 0,0);
   $alianzas = arrphp_arrpg ($_POST['concontrol']);
   
   
   update( "alianzausuario", "concontrol=$alianzas", "usuario = '" . $_POST['codigo_usuario'] . "'",0, 1 );
   
   alerta(16);
   if ($_POST['estado'] =='C')
   {  
      query ("update usergrup set estado='C',fecha_cierre=date(now()),grabador='".$GLOBALS['usuario']."' where  usuario='".trim( $_POST['codigo_usuario'] )."'",0,0);

      if (count($borrados)>0)
      { 
         foreach( $borrados as $borIndex => $borValor )
         { 
            if($borValor=="S")
            {  
               query ("update usergrup set estado='C',fecha_cierre=date(now()),grabador='".$GLOBALS['usuario']."' where grupo='".$borIndex."' and usuario='".trim( $_POST['codigo_usuario'] )."'",0,0);
   //echo $borIndex."<br>";
               $nota_cambio .= "<font color=\"#000080\"> desvinculo el usuario ".trim( $_POST['codigo_usuario'] ). " del perfil ".$nombregrupo[$borIndex]." ,";
            }
         }
      }
   }
   return $_POST['codigo_usuario'];
}






function Interface2( $codigo )
{
  Global $usuario, $PHP_SELF, $GLOBALS, $SERVER_NAME, $_POST, $_GET, $accion, $db, $DOCUMENT_ROOT,$LABELS;
  include_once($DOCUMENT_ROOT.'/padminfo/includes/combobox.php');
  //echo $LABELS['software']['dias_para_inactivar']."este es el label para inactivar usuarios";

  if( $_GET['nuevo'] != 'V' )
  {
    $where = "codigo = '$codigo'";
    $datos = select( "*", "nue_usuario", $where, '', 0, 1 );
    if ( empty( $LABELS['software']['dias_para_inactivar']) === FALSE )
   {
       $campoextra=",dias_para_inactivar";
  }

  if ( empty( $LABELS['software']['tipo']) === FALSE )
   {
       $campoextra=$campoextra.",tipo,rutadescarga";
  }
    #-------BD-------
    $conex=ADONewConnection($_SESSION['BDGeneral']['motor']);
        $conex->Connect($_SESSION['BDGeneral']['ip'],$_SESSION['BDGeneral']['usuario'],$_SESSION['BDGeneral']['clave'],'BDGeneral');
    //$conex = ADONewConnection( "postgres" );
    //$conex->Connect( 'localhost', 'root', '', 'bd' );
    $sqlBuscaDatosBd = "
    SELECT
      nit,
      codigo_usuario,
      clave,
      host,
      nombrebd,
      empresa,
      CasaCobranza,
      fecha_i,
      fecha_f,
      hora_i,
      hora_f,
      dias_validez,
      idioma,
      usuagenda,
      superusuario,
      estado ".$campoextra."
    FROM
      software
    WHERE
      codigo_usuario = '" . $codigo . "' and
      nombrebd = '" . $GLOBALS['nombrebd'] . "'
    ;";
	//echo "<br> 881 ".$sqlBuscaDatosBd ."<br>";
    $datos1       = $conex->Execute( $sqlBuscaDatosBd );
    $superusuario = $datos1->fields['superusuario'];
    $idioma       = $datos1->fields['idioma'];
    $usuagen      = $datos1->fields['usuagenda'];
    
    $conex->close( );
    #-----FIN BD-----
    
    $nuevo='F';
  }
  else
  { 
    #-------BD-------
   if ( empty( $LABELS['software']['dias_para_inactivar']) === FALSE )
   {
       $campoextra=",dias_para_inactivar";
  }

   
if ( empty( $LABELS['software']['tipo']) === FALSE )
   {
       $campoextra=$campoextra.",tipo,rutadescarga";
  }
	$conex=ADONewConnection($_SESSION['BDGeneral']['motor']);
        $conex->Connect($_SESSION['BDGeneral']['ip'],$_SESSION['BDGeneral']['usuario'],$_SESSION['BDGeneral']['clave'],'BDGeneral');
    //$conex = ADONewConnection("postgres");
    //$conex->Connect('localhost','root','','bd');
    $sqlBuscaDatosBd = "
    SELECT
      host,
      nombrebd,
      empresa,
      fecha_i,
      fecha_f,
      hora_i,
      hora_f,
      dias_validez,
      superusuario ".$campoextra."
    FROM
      software
    WHERE
       codigo_usuario = '" . $usuario . "' and
       nombrebd = '" . $GLOBALS['nombrebd'] . "'
    ;";
    //echo "<br> 926 ".$sqlBuscaDatosBd ."  <br>";
    $datos1        = $conex->Execute( $sqlBuscaDatosBd );
    $baseusurnuevo = $datos1->fields['nombrebd'];
    $superusuario  = $datos1->fields['superusuario'];
    $idioma        = 'Espanol';
    $usuagen       = 'N';
    $conex->close( );
    #-----FIN BD-----

    $nuevo='V';
  }
  if( $_GET['nom_programa'] == "" )
  {
    $nom_programa = $_POST['nom_programa'];
  }
  else
  {
    $nom_programa = $_GET['nom_programa'];
  }
  $pantallas = select( "*", "pantallas", "nom_programa = '" . $nom_programa . "'", "", 0, 1);
  $titulo = ucwords( strtolower( $pantallas->fields['titulopantalla'] ) );
  
  // Busca todas las empresas de la actual base de datos en la tabla software de la
  // base de datos bd
  
	$conex=ADONewConnection($_SESSION['BDGeneral']['motor']);
	$conex->Connect($_SESSION['BDGeneral']['ip'],$_SESSION['BDGeneral']['usuario'],$_SESSION['BDGeneral']['clave'],'BDGeneral');
//$conex = ADONewConnection("postgres");
  //$conex->Connect('localhost','root','','bd');
  
/*   $sqlBuscaEmpresas = "
  SELECT
    distinct nombreempresa as nombreempresa
  FROM
    cantidadterm
  WHERE
    nombrebd = '" . $GLOBALS['nombrebd'] . "'
    and nombreempresa <> 'solati' ;";
*/
 
	$sqlBuscaEmpresas =" select distinct empresas.CasaCobranza as nombreempresa from empresas, software where empresas.nombreEmpresa = software.empresa and  software.nombrebd ='".$GLOBALS['nombrebd']."' and empresas.CasaCobranza not like 'solati'  order by software.CasaCobranza asc; ";
	
	//echo "<br> 968 ".$sqlBuscaEmpresas;
 
  $objBuscaEmpresas = $conex->Execute( $sqlBuscaEmpresas );
  
  for( $j = 0; $j < $objBuscaEmpresas->RecordCount( ); $j++ )
  { 
    $strEmpresas .= $objBuscaEmpresas->fields['nombreempresa'] . '|'; 
    $objBuscaEmpresas->MoveNext( );
  }
  
  $conex->close( );
  
  include_once($DOCUMENT_ROOT.'/padminfo/includes/encabezado.php');
  
  /**
  echo "<pre>";
  print_r($datos->fields);
  echo "<hr />";
  print_r($datos1->fields);
  echo "</pre>";
  */
?>

<script src="../jquery/jquery.js" type="text/javascript"> </script>
<script src="../jquery/plugins/FastSerialize.js" type="text/javascript"> </script>
<script type='text/javascript' src='/padminfo/jscalendar/calendar.js'></script>
<script type='text/javascript' src='/padminfo/jscalendar/lang/calendar-es.js'></script>
<script type='text/javascript' src='/padminfo/jscalendar/calendar-setup.js'></script>

<link rel='stylesheet' type='text/css' media='all' href='/padminfo/jscalendar/calendar-win2k-cold-1.css' title='win2k-cold-1' />

<style type="text/css">
input, select
{
  border: 1px solid #000;
  border-color: #555;
}
</style>

<script language="javascript">
<!--
function validar2()
{
	valores_alianza = $("#concontrol").val() || [];

	
 if( $('#nit').val() == '' || $('#codigo_usuario').val() == '' || $('#nombre').val() == '' || $('#clave').val() == '' || $('#fecha_i').val() == '' || $('#fecha_f').val() == '' || $('#hora_i').val() == '' || $('#hora_f').val() == '' || $('#dias_validez_clave').val() == '' || $('#empresa').val() == '' || valores_alianza== '')
  {
    if( parseInt( $('#clave').attr('length') ) < parseInt( 6 ) )
    {
      alert('Debe Suministrar una Clave Valida.\nMinimo 6 Caracteres.');
    }
    else
    {
     alert('CAMPOS REQUERIDOS:\n- Nit / Cedula\n- Usuario\n- Nombre\n- Clave\n- Inicio Validez Clave\n- Usuario Caduca El\n- Hora Inicio\n- Hora Final\n- Dias Validez Clave\n- Nombre Empresa\n- Alianza\n');
    }
    return false;
  }

 
<?php
   if ( empty( $LABELS['software']['dias_para_inactivar']) === FALSE )
   {
        echo "
             var diaspara=$('#diasparainactivar').val();";
      echo "if($('#diasparainactivar').val() == '')
          {
           alert('Debe colocar los dias para inactivar la clave');
           return false;
          }
     ";
   }
   if ( empty( $LABELS['software']['tipo']) === FALSE )
   {
        echo "
             var diaspara=$('#tipo').val();";
      echo "if($('#tipo').val() == 'S' && $('#rutadescarga').val()=='')
          {
           alert('Debe colocar la ruta');
           return false;
          }
     ";
   }

?>

return true;
}

function valida4(a)
{
  var vlemb=a.value;
  var cadena2="0123456789";
  var estecar2;
  var contador22=0;
  for(var h2=0; h2<vlemb.length; h2++)
  {
    estecar2=vlemb.substring(h2,h2+1);
    if(cadena2.indexOf(estecar2)!=-1)
    contador22++;
  }
  if(contador22!=vlemb.length)
  {
    var cant=vlemb.substring(0,contador22);
    a.value=cant;
    a.focus();
    alert('Debe Digitar Solo Numeros');
  }
  else
  {
    if((vlemb==0)&&(vlemb!=""))
    {
      alert('NO PUEDE SER CERO');
      a.value=1;
      a.focus();
    }
  }
}

/*
 * @deprecated 
 */
function buscabd (y, usu, clav, hos, bd, emp, feci, fecf , regional )
{
  nueva_ventana3 = open("buscabd.php?nit=" + y + "&idusu="+usu+"&idclav="+clav+"&idhos="+hos+"&idbd="+bd+"&idemp="+emp+"&idfeci="+feci+"&idfecf="+fecf+"&idregional="+regional,"miventana2","top=0,left=0,alwaysRaised=yes,toolbar=no,location=no,menubar=no,resizable=no,scrollbars=yes,width=10,height=10");
}

/*
 * @deprecated 
 */
function finbuscabd(codusu,idusu,clave,idclav,host,idhos,feci,idfeci,fecf,idfecf,idregional)
{
  var codusu2 = idusu.toString( );
  var elemento = document.getElementById(codusu2);
  elemento.value=codusu;
  var clave2=idclav.toString();
  var elemento=document.getElementById(clave2);
  elemento.value=clave;
  var host2=idhos.toString();
  var elemento=document.getElementById(host2);
  elemento.value=host;
  var feci2=idfeci.toString();
  var elemento=document.getElementById(feci2);
  elemento.value=feci;
  var fecf2=idfecf.toString();
  var elemento=document.getElementById(fecf2);
  elemento.value=fecf;
  var Region=idregional.toString();
  var elemento=document.getElementById(Region);
  elemento.value=idregional;
  nueva_ventana3.close();
}

/**
 * Busca la informacion del usuario por el nit.
 *
 * @param integer nit del usuario
 * @return void
 * @author Jonathan Espinal (John...)
 */
function buscaUsuarioPorNit( intNit )
{ 
  /**
  var vlemb = intNit;
  var cadena2 = "0123456789";
  var estecar2;
  var contador22 = 0;
  for(var h2 = 0; h2 < vlemb.length; h2++ )
  {
    estecar2 = vlemb.substring( h2, h2 + 1 );
    if( cadena2.indexOf( estecar2 ) != -1 )
    {
      contador22++;
    }
  }
  if( contador22! = vlemb.length )
  {
    $('#codigo_usuario').val( '' );
    $('#nombre').val( '' );
    $('#clave').val( '' );
    $('#nuevo').val( 'V' );
    $('#codigo_usuario').removeAttr( 'readonly' );
    $('#nombre').removeAttr( 'readonly' );
    return false;
  }
  */
    
  if( intNit == '' )
  {
    $('#codigo_usuario').val( '' );
    $('#nombre').val( '' );
    $('#clave').val( '' );
    $('#nuevo').val( 'V' );
    $('#codigo_usuario').removeAttr('readonly');
    $('#nombre').removeAttr('readonly');
    return false;
  }
  $.ajax({
    type: "POST",
    url: "xmlhttp/Ajax.busca_bd.php",
    data: "nit=" + intNit,
    dataType: "json",
    success: function( jsonResponse )
    {
      // alert( jsonResponse );
      if( jsonResponse.resultado == 1 )
      {
        $('#codigo_usuario').val( jsonResponse.codigo_usuario );
        $('#nombre').val( jsonResponse.nombre );
        $('#estado').val( jsonResponse.estado );
        $('#clave').val( jsonResponse.clave );
        $('#idioma').val( jsonResponse.idioma );
        $('#fecha_i').val( jsonResponse.fecha_i );
        $('#fecha_f').val( jsonResponse.fecha_f );
        $('#hora_i').val( jsonResponse.hora_i );
        $('#hora_f').val( jsonResponse.hora_f );
        $('#dias_validez_clave').val( jsonResponse.dias_validez_clave );
        $('#empresa').val( jsonResponse.empresa );
        $('#superusuario').val( jsonResponse.superusuario );
        $('#regional').val( jsonResponse.regional );
        $('#nuevo').val( '' );
        if( jsonResponse.grupos != null )
        {
          for( contadorGrupos = 0; contadorGrupos < jsonResponse.grupos.length; contadorGrupos++ )
          {
            $('#grupo_' + jsonResponse.grupos[contadorGrupos] ).attr( 'checked', 'checked' );
            //alert( jsonResponse.grupos[contadorGrupos] );
          }
        }
        
        $('#codigo_usuario').attr('readonly','readonly');
        $('#nombre').attr('readonly','readonly');
        // $('#nit').attr('readonly','readonly');
        
        /**
        if( jsonResponse.resultado == 2 )
        {
          $('#accion').css('visibility', 'hidden');
        }
        else
        {
          $('#accion').css('visibility', 'visible');
        }
        **/
      }
      if( jsonResponse.resultado == -1 )
      {
        // alert( "Para crear un usuario con este nit favor comunicarse con las oficinas de solati ltda." );
        $('#codigo_usuario').val( '' );
        $('#nombre').val( '' );
        $('#clave').val( '' );
        $('#nuevo').val( 'V' );
        $('#codigo_usuario').removeAttr('readonly');
        $('#nombre').removeAttr('readonly');
      }
      
      if( jsonResponse.resultado == 0 )
      {
        $('#codigo_usuario').val( jsonResponse.codigo_usuario );
        $('#nombre').val( jsonResponse.nombre );
        $('#estado').val( 'A' );
        $('#clave').val( '' );
        $('#nuevo').val( 'V' );
        $('#codigo_usuario').attr('readonly','readonly');
        $('#nombre').attr('readonly','readonly');
      }
    },
    error: function( request, settings )
    {
      alert( "Error consultado datos." );
    }
  });
}

function confirmaNombreUsuario( strUsuario, intNit )
{
  if( strUsuario == '' )
  {
    return false;
  }
  $.ajax({
    type: "POST",
    url: "xmlhttp/Ajax.busca_bd_usuario.php",
    data: "usuario=" + strUsuario + "&nit=" + intNit,
    dataType: "json",
    success: function( jsonResponse )
    {
      // alert( jsonResponse );
      if( jsonResponse.resultado == 1 )
      {
        alert( "Este nombre de usuario (" + strUsuario + ") no esta disponible..." );
        $('#codigo_usuario').val( '' );
      }
    },
    error: function( request, settings )
    {
      alert( "Error consultado datos." );
    }
  });
}
-->
</script>

<br />
<form action="<?php echo $PHP_SELF ?>" method="post" name="formulario" onsubmit='return validar2( )'>
 
<?php $columnas = $pantallas->fields['columnaspantalla']; ?>
<table border="0" cellspacing="2" cellpadding="2" bordercolor="#FFFFFF" width="100%">
<tr>
  <td>Nit / Cedula</td>

<?php
 if( $_GET['nuevo'] != 'V' )
{
	echo "<td><input type='text' value=\"".$datos1->fields['nit']."\" id=\"nit\" name=\"nit\" onkeyup=\"valida4( this )\" MAXLENGTH=\"15\" style=\"width:160\"></td>";
}
else
{
	echo "<td><input type='text' value=\"".$datos1->fields['nit']."\" id=\"nit\" name=\"nit\" onkeyup=\"valida4( this )\" onblur=\"buscaUsuarioPorNit( this.value )\" MAXLENGTH=\"15\" style=\"width:160\"></td>";
}
?>

  <td>Usuario</td>
  <td><input type="text" value="<?php echo $datos1->fields['codigo_usuario'] ?>" id="codigo_usuario" name="codigo_usuario" style="width:160" onkeyup='this.value=this.value.toLowerCase()' onblur="confirmaNombreUsuario( this.value, document.getElementById( 'nit' ).value )"></td>
</tr>
<tr>
  <td>Nombre</td>
  <td><input type='text' value="<?php echo $datos->fields['nombre'] ?>" id="nombre" name="nombre" style="width:160"></td>
  <td>Estado</td>
  <td><?php combobox2( "estado", $datos1->fields['estado'], "A-Abierto|C-Retirado|I-Inactivo", "70" ) ?></td>
</tr>

<?php // i0nclude($DOCUMENT_ROOT.'/padminfo/includes/armapantalla.php'); // importante para que se arme el capturador con ncampos ?>
<?php
  if( $datos1->fields['host'] == '' )
  {
    $datos1->fields['host'] = $SERVER_NAME;
  }
  if( $datos1->fields['nombrebd'] == '' )
  {
    $datos1->fields['nombrebd'] = $baseusurnuevo;
  }
?>

<tr>
  <td>Clave</td>
  <td><input type="password" value="<?php echo $datos1->fields['clave'] ?>" id="clave" name="clave" style="width:160"></td>
  <td>Idioma</td>
  <td><?php combobox( "idioma", "$idioma", "Espanol|Ingles|Frances|Portugues|Italiano", "100" ) ?></td>
</tr>
<tr>
  <td>Inicio Validez Clave</td>
  <td>
    <?php
    $strFechaInicio = $datos1->fields['fecha_i'];
    $strFechaFin = $datos1->fields['fecha_f'];

    if( $nuevo  === "V" )
    {
      $strFechaInicio = date( 'Y-m-d' );
      $strFechaFin=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+360,date("Y")));
    }

    ?>
    <input type="text" value="<?php echo $strFechaInicio ?>" id="fecha_i" name="fecha_i" style="width:100" />
    <img src='/padminfo/jscalendar/img.gif' id='trigger_fecha_i' style='cursor: pointer;' title='Seleccione la Fecha'/>
    <script type="text/javascript">
     Calendar.setup ({
       inputField: 'fecha_i',
       ifFormat: '%Y-%m-%d',
       button: 'trigger_fecha_i',
       align: 'Bl',
       singleClick: true });
    </script>
  <td>Usuario Caduca el :</td>
  <td>
    <input type="text" value="<?php echo $strFechaFin ?>" id="fecha_f" name="fecha_f" style="width:100" />
    <img src='/padminfo/jscalendar/img.gif' id='trigger_fecha_f' style='cursor: pointer;' title='Seleccione la Fecha'/>
    <script type="text/javascript">
     Calendar.setup ({
       inputField: 'fecha_f',
       ifFormat: '%Y-%m-%d',
       button: 'trigger_fecha_f',
       align: 'Bl',
       singleClick: true });
    </script>
  </td>
</tr>
<tr>
  <td>Hora Inicio - Fin</td>
  <td>
  <select name="hora_i" id="hora_i" style="width:50">
  <?php
  for( $k = 0; $k <= 23; $k++ )
  {
    if( str_pad ( $k, 2, 0, STR_PAD_LEFT ) . ":00:00" == $datos1->fields['hora_i'] )
    {
      echo "<option selected value='";
    }
    else
    {
      echo "<option value='";
    }
    echo str_pad($k,2,0,STR_PAD_LEFT).":00'>".str_pad($k,2,0,STR_PAD_LEFT).":00</option>\n";
  }
  ?>
  </select>
  -
  <select name="hora_f" id="hora_f" style="width:50">
  <?php
  $x=0;
  for($k=0; $k<=23; $k++)
  {
    if(str_pad($k,2,0,STR_PAD_LEFT).":00:00" == $datos1->fields['hora_f'])
    {
      $x=1;
      echo "<option selected value='";
    }
    else
    {
      echo "<option value='";
    }
    echo str_pad($k,2,0,STR_PAD_LEFT).":00'>".str_pad($k,2,0,STR_PAD_LEFT).":00</option>\n";
  }
  if($x==0)
  {
    echo "<option selected value='23:00'>23:00</option>";
  }
  ?>
  </select>
  </td>
  <td>Dias Validez Clave</td>
  <td><input type="text" value="<?php echo $datos1->fields['dias_validez'] ?>" id="dias_validez_clave" name="dias_validez_clave" style="width:40"></td>
</tr>
<!--
<tr>
  <td width="100">Host</td>
  <td><input type="text" value="<?php echo $datos1->fields['host'] ?>" id="host" name="host" style="width:160"></td>
  <td width="100">Base de Datos</td>
  <td><input type="text" value="<?php echo $datos1->fields['nombrebd'] ?>" id="nombrebd" name="nombrebd" style="width:160"></td>
</tr>
-->
<tr>
  <td>Nombre Empresa</td>
  <td><?php combobox( "empresa", $datos1->fields['CasaCobranza'], $strEmpresas, "100" ) ?></td>
  <td>Super Usuario</td>
  <td><?php combobox("superusuario","$superusuario","N|S","40") ?></td>
</tr>
<?php

echo "<tr>";
if ( empty( $LABELS['software']['dias_para_inactivar']) === FALSE )
{
  
  echo "<td>".$LABELS['software']['dias_para_inactivar']."</td><td><input type=\"text\" MAXLENGTH='2' name=\"diasparainactivar\" id=\"diasparainactivar\"  value=\"".$datos1->fields['dias_para_inactivar']."\"  style=\"width:40\"  onkeyup=\"if(isNaN(this.value)) {alert('Solo Acepto Numeros'); this.value='';}\"></td>";
}
echo "</tR>";
if ( empty( $LABELS['software']['tipo']) === FALSE )
{
	echo "<tr><td>".$LABELS['software']['tipo']."</td>";
	echo "<td> <select name='tipo' id='tipo' style='width: 40; height: 18;' tabindex=1' onchange =\"if(this.value=='S')  document.formulario.rutadescarga.disabled=false; else  {document.formulario.rutadescarga.value=''; document.formulario.rutadescarga.disabled=true;}\">";

	if($datos1->fields['tipo']=="S")
	{
	echo "
	 <option value='N'>N</option>
	 <option selected value='S'>S</option>";
	}

	else
	{
		echo "
	 <option selected value='N'>N</option>
	 <option value='S'>S</option>";
		
	}
	echo "
	</select>
	";
	echo "</td>";

	if($datos1->fields['tipo']=="S")
	{
		echo "<td>Ruta Descarga </td><td><input type=\"text\"  name=\"rutadescarga\" id=\"rutadescarga\" value=\"".$datos1->fields['rutadescarga']."\" ></td>";
	}
	else
	{
		echo "<td>Ruta Descarga </td><td><input type=\"text\" disabled  name=\"rutadescarga\" id=\"rutadescarga\" value=\"".$datos1->fields['rutadescarga']."\" ></td>";
	}

}
echo "</tR>";

/* configuracion para vincular con alianza
 * ______________________________________________________________________________________________
 */

$arr_alianza = query("SELECT concontrol, nombresucur FROM control WHERE estado = 'A'",0,0);

//$arr_alianza = $ado_arr_alianza->getarray($ado_arr_alianza);
/*
echo "<tr><td><pre>";
 print_r($arr_alianza);
 echo "</td></tr>";
*/
$arreglos_alianzas = array();
if( $_GET['nuevo'] != 'V' )
{
	$alianza_user = query("SELECT * FROM alianzausuario  WHERE estado = 'A' and usuario = '".$datos1->fields['codigo_usuario']."' limit 1;",0,0);
	if($alianza_user->recordcount()>0)
	$arreglos_alianzas = arrpg_arrphp($alianza_user->fields['concontrol'], false);
}

if (empty( $LABELS['alianzausuario']['concontrol']) === FALSE )
{
	?>
	<tr title = 'Mantenga presionada la tecla Ctrl para seleccionar varias opciones'>
	<td><?php echo $LABELS['alianzausuario']['concontrol']; ?></td>
	<td>
	<select name='concontrol[]' id='concontrol' style="padding:2px;width:100%;" multiple="multiple" size='3' >
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
	<?php
}


/*  fin configuracion para vincular con alianza
 * ______________________________________________________________________________________________
 */

//document.formulario.nombresecuestre.disabled=true


/* programa viejo
$consultacampos=select("tabla_asociada,link_asociado,descrip_asociada,nom_variable,nom_tabla,tipo_campo,label_pred,alias,ordenamiento,nom_campo,query_campo","ncampos_tablas","nom_programa='".$nom_programa."' and mostrar='S'","ordenamiento",0, 1);
$Num_Filas=0;
for($r=0; $r<$consultacampos->RecordCount(); $r++)
	{	#echo $consultacampos->fields['nom_variable'] ."-".$consultacampos->fields['tipo_campo']."<br>"; 
 		if($Num_Filas%2==0)	echo "<tr>";
		if($consultacampos->fields['tipo_campo']=="ciudad")
			{	$valor=$datos->fields[$consultacampos->fields['nom_campo']];
			  if($valor!="")
			    { $ciudad=select("nomciudad","ciudades","conciudad='$valor'","nomciudad",0,1);
			     $nomciudad=$ciudad->fields['nomciudad'];
			    }
		    else
		     	$nomciudad="";
		    echo "<td width='100'><a href='javascript:actualizar_ciudad2(window.document.formulario.nom".$consultacampos->fields['nom_campo'].",window.document.formulario.".$consultacampos->fields['nom_campo'].");'><b><font color=\"0000FF\"><u>".ucwords(strtolower(ucfirst($LABELS['nue_usuario'][$consultacampos->fields['nom_campo']])))."</u></font</b></a>";
		    echo "<td width='150'>";
		    echo "<script language='javascript' type='text/javascript' src='/padminfo/javascript/ciudades.js'></script><input type='text' name='nom".$consultacampos->fields['nom_campo']."' id='nom".$consultacampos->fields['nom_campo']."' value='$nomciudad' $longitud style='width: ".$anchocampo."' tabindex=1>";
		    echo "<input type='hidden' name='".$consultacampos->fields['nom_campo']."' id='".$consultacampos->fields['nom_campo']."' value='$valor'>";
			}
		elseif($consultacampos->fields['tipo_campo']=="seleccion")
			{ $consultaopciones =query ($consultacampos->fields['query_campo'],0,1);
				$c1 = $consultaopciones->FetchField(0);
				$c2 = $consultaopciones->FetchField(1);
			  echo "<td>".$LABELS['nue_usuario'][$consultacampos->fields['nom_campo']]."</td><td>
							<select name=\"".$consultacampos->fields['nom_campo']."\" id=\"".$consultacampos->fields['nom_campo']."\"><option value =''>&nbsp;</option>";
				for($sp=0;$sp<$consultaopciones->recordcount();$sp++)
					{ if($datos->fields[$consultacampos->fields['nom_campo']]==$consultaopciones->fields[$c1->name])
					    echo "<option selected value ='".$consultaopciones->fields[$c1->name]."'>".$consultaopciones->fields[$c2->name]."</option>";
						else
 							echo "<option value ='".$consultaopciones->fields[$c1->name]."'>".$consultaopciones->fields[$c2->name]."</option>";
					 	$consultaopciones->movenext();
					}
				echo "</select>";
			}
	elseif($consultacampos->fields['tipo_campo']=="opciones")
			{ $opciones = explode( '|', $consultacampos->fields['query_campo'] );
				echo "<td>".$LABELS['nue_usuario'][$consultacampos->fields['nom_campo']]."</td><td>";
				 echo "\n<select name='".$consultacampos->fields['nom_campo']."' id='".$consultacampos->fields['nom_campo']."' style='width: ".$consultacampos->fields['ancho_campo']."; height: 18;' tabindex=1'>\n";
				for ( $k = 0; $k < count( $opciones ); $k++ )
						{  $arrValorReal = explode( '::', $opciones[$k] );
								if ( trim( $arrValorReal[0] ) == trim( $datos->fields[$consultacampos->fields['nom_campo']] ) )
										echo " <option selected value='";
								else	 echo " <option value='";
								if ( isset( $arrValorReal[1] ) )
									echo $arrValorReal[0] . "'>" . ucwords( strtolower( $arrValorReal[1] ) ) . "</option>\n";
								else echo $arrValorReal[0] . "'>" . ucwords( strtolower( $arrValorReal[0] ) )."</option>\n";
						}
				echo "</select>\n";
			}	
		else
			{	echo "<td>".$LABELS['nue_usuario'][$consultacampos->fields['nom_campo']]."</td><td><input type=\"text\"   name=\"".$consultacampos->fields['nom_campo']."\" id=\"".$consultacampos->fields['nom_campo']."\" value=\"".$datos->fields[$consultacampos->fields['nom_campo']]."\" ></td>";
			}
 		if($Num_Filas%2==1)
			echo "</tr>";
 		$consultacampos->movenext();
		$Num_Filas++;
	}*/




if ( empty( $LABELS['software']['regional']) === FALSE )
{
  echo "<tr>
  <td>Codigo Oficina</td>
  <td><input type='text' value=\"".$datos->fields['regional']."\" id=\"regional\" name=\"regional\" MAXLENGTH=\"3\" style=\"width:100\"></td>
</tr>";
}
else
echo "<input type='hidden' value=\"1\" id=\"regional\" name=\"regional\">";


?>
<?php
/* programa viejo
<tr>
	<td>Servicios</td>
	<td colspan="3">
	<div style="height:50px; border:1px solid #000; background-color:#fff; overflow-y:auto;padding:5px">
	<?php
	 echo servicios_check($datos1->fields['codigo_usuario'],'I'); 
	 echo '<br>';
	 echo servicios_check($datos1->fields['codigo_usuario'],'A'); 
	 ?>
	 </div>
	 </td>


	</tr>
*/
?>


<tr>
<?php
$arrGruposActuales = array( );
$objGruposActuales = select( '*', 'usergrup', "usuario='" . $datos1->fields['codigo_usuario'] . "' and estado='A'", '', 0, 1 );
if( $objGruposActuales->RecordCount( ) > 0 )
{
  for( $j = 0; $j < $objGruposActuales->RecordCount( ); $j++ )
  {
    $arrGruposActuales[$j+1] = $objGruposActuales->fields['grupo'];
    $objGruposActuales->MoveNext( );  
  }
}
?>
  <td>Grupos</td>
  <td colspan="3">
  <div style="height:120px; border:1px solid #000; background-color:#fff; overflow-y:auto;padding:5px">
  <?php

  $objGrupos = select( '*', "grupos", "estado='A'", 'nombre_grupo', 0, 1 );
  for( $j = 0; $j < $objGrupos->RecordCount( ); $j++ )
  {
    $strChecked = '';
    
    if( array_search( $objGrupos->fields['consgrupo'], $arrGruposActuales ) )
    {
      $strChecked = 'checked = "checked"';
    }
    ?>
    <div><input type="checkbox" <?php echo $strChecked ?> class="class_grupos" id="grupo_<?php echo $objGrupos->fields['consgrupo'] ?>" name="grupo[<?php echo $objGrupos->fields['consgrupo'] ?>]" value="<?php echo $objGrupos->fields['consgrupo'] ?>" /><label for="grupo_<?php echo $objGrupos->fields['consgrupo'] ?>"> <?php echo $objGrupos->fields['nombre_grupo'] ?></label></div>
    <?php
    $objGrupos->MoveNext( );
  }
  ?>
  </div>
  </td>
</tr>
</table>

<table>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
<td colspan=4 align='right'>
<?php
  if($nuevo!='V')
  {
    if( $pantallas->fields['log_cambios'] == 'S' )
    {
      echo "<input type='button' value='".$LABELS['generico']['log_cambios']."' name='logcambios' onclick=\"window.open('/padminfo/automatica/lista_log_cambios.php?opcionsalir=N&llave=".$pantallas->fields['llave']."&nom_programa=".$_REQUEST['nom_programa']."&val_llave=".$datos1->fields['codigo_usuario']."','logcambios','top=100,left=100,alwaysRaised=yes,toolbar=no,location=no,menubar=no,resizable=no,scrollbars=yes,width=700,height=500')\" tabindex='2'>";
    }
    //echo "<input type='button' value='".$LABELS['generico']['log_cambios']."' name='logcambios' onclick=\"window.open('/padminfo/automatica/lista_log_cambios.php?opcionsalir=N&llave=".$pantallas->fields['llave']."&nom_programa=".$_REQUEST['nom_programa']."&val_llave=".$datos1->fields['codigo_usuario']."','logcambios','top=100,left=100,alwaysRaised=yes,toolbar=no,location=no,menubar=no,resizable=no,scrollbars=yes,width=700,height=500')\" tabindex='2'>";
    // echo "<input type='submit' value='".$LABELS['generico']['eliminar']."' id=eliminar name='accion' onclick=\"if(confirm('Esta Seguro que desea Eliminar este Registro?')) return true; else return false;\" style='width:80'>";
  }
?>
<input type="submit" value="<?php echo $LABELS['generico']['guardar'] ?>" name="accion" id="accion" style="width: 80">
<input type="hidden" name="nuevo" id="nuevo" value="<?php echo $nuevo ?>">
<input type="hidden" name="nom_programa" value="<? echo $nom_programa ?>">
</td>
</tr>
</table>

</form>

<?php
include($DOCUMENT_ROOT.'/padminfo/includes/pie.php');
}
?>
