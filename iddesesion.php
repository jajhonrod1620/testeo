<?php
ini_set('session.cache_limiter', '');
	header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: no-cache');
session_id('slondoño'.date('Ymdhis'));
session_start();
echo "sesiosn";

?>
