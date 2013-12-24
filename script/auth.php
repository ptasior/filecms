<?php
$tab = ['qq'=>'rq', 'aa'=>'bb'];
$tab[] = $tab;
$ret = json_encode($tab, JSON_PRETTY_PRINT);
var_dump($ret);
echo "<br><br>";

$z = json_decode($ret);
var_dump($z);
?>

