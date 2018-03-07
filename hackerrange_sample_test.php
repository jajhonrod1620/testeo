<?php
/*
 * Complete the function below.
 */

    function findNumber($arr, $k) {
        return in_array($k, $arr)? 'YES':'NO';
    }

    $file = fopen(getenv('OUTPUT_PATH'),"w");
    $var = getenv('OUTH_PATH');
    echo $var;

    /*    
    $__fp = fopen("php://stdin", "r");

    $_arr_cnt = 0;
    fscanf($__fp, "%d", $_arr_cnt);
    $_arr = array();
    for ($_arr_i=0; $_arr_i < $_arr_cnt; $_arr_i++) { 
        fscanf($__fp, "%d", $_arr_item);
        $_arr[] = $_arr_item;
    }


    fscanf($__fp, "%d", $_k);

    $res = findNumber($_arr, $_k);
    echo $res ."\n";
    //fwrite($file, $res . "\n" );
*/
    fclose($file);
?>