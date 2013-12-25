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
	global $DATA_PATH;
	$path = $DATA_PATH.'/'.$_SERVER['REQUEST_URI'];
	if(!allow_path($path)) return array('method'=>'error', 'msg'=>'Permission denied');

	if(is_file($path)) return array('method'=>'download', 'file'=>$path);
	if(is_dir($path)) return array('method'=>'display', 'path'=>$path);

	return array('method'=>'error', 'msg'=>'Unknown command');
}


$request = urlParse();

switch($request['method'])
{
	case 'display': require_once 'index_tpl.php'; break;
	case 'download': echo 'download: '.$request['file']; break;
	case 'error': echo 'error: '.$request['msg']; break;
}

?>

