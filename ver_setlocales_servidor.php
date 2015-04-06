<?php
function list_system_locales(){
    ob_start();
    system('locale -a');
    $str = ob_get_contents();
    ob_end_clean();
    return split("\n", trim($str));
}
$a=list_system_locales();
echo "<pre>";
print_r($a);
?>
