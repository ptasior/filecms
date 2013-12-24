<?php
$request;

function template($name, $params=[])
{
	include 'script/'.$name.'_tpl.php';
}

function module($name)
{
	global $request;
	require $name.'.php';
}

function allow_path($name)
{
	return strpos($name, 'q') === false;
}

function urlParse()
{
	var_dump($_SERVER['REQUEST_URI']);
}


$request = urlParse();

require_once 'index_tpl.php';
?>

