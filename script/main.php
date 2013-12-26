<?php
session_start();
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
	// todo handle extensions (.php!)
}

function url_parse()
{
	if(substr($_SERVER['REQUEST_URI'], 0, 7) == '/action')
	{
		$act = substr($_SERVER['REQUEST_URI'], 7);
		$qm = strpos($act, '?');

		if($qm === false)
			return array('method'=>'action', 'action'=>$act);
		
		$tmp = $act;
		$act = substr($tmp, 0, $qm);
		$params = substr($tmp, $qm+1);
		return array('method'=>'action', 'action'=>$act);
	}

	global $DATA_PATH;
	$path = $DATA_PATH.'/'.$_SERVER['REQUEST_URI'];
	$handled_ext = array('.txt', '.php');

	if(!allow_path($path))
		return array('method'=>'error', 'msg'=>'Permission denied');

	if(is_file($path) && !in_array(substr($path, -4), $handled_ext))
		return array('method'=>'download', 'file'=>$path);

	if(is_dir($path) || in_array(substr($path, -4), $handled_ext))
		return array('method'=>'display', 'path'=>$path);

	return array('method'=>'error', 'msg'=>'Unknown command');
}

function print_error($msg)
{
	echo 'error: '.$msg;
	exit(0);
}

function display($url)
{
	global $request;
	global $DATA_PATH;

	if($url[0] == '/') $url = $DATA_PATH.$url;
	$request['path'] = $url;

	require_once 'index_tpl.php';
	exit(0);
}

function handle_action($action)
{
	switch($action)
	{
		case 'Login': include 'auth.php'; break;
		default: print_error('No such action: '.action); break;
	}
}

$request = url_parse();

switch($request['method'])
{
	case 'display': display($request['path']); break;
	case 'download': echo 'download: '.$request['file']; break;
	case 'error': print_error($request['msg']); break;
	case 'action': handle_action($request['action']); break;
}

?>

