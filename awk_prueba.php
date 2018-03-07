<?php
shell_exec("awk -F\",\" 'BEGIN { OFS = \"|\" } {\$2=\"NULL\"; print}' output1.txt > CAR_OPEN7_20130606ok.txt");
?>