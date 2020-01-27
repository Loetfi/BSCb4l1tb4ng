<?php 

$output = shell_exec('ls -lart');
echo "<pre>$output</pre>";

$open = shell_exec('chmod -R 777 /assets/json');
echo "<pre>$p$</pre>";

$buat = shell_exec('mkdir /assets/json/2020 && chmod -R 777 /assets/json/2020');

echo '<pre>'. $buat . '</pre>';
