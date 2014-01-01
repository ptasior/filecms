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

function print_error($msg)
{
	echo 'error: '.$msg;
	exit(0);
}

function forward($url)
{
	header('location:'.$url);
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

function check_privs($privs, $name)
{
	foreach($privs['deny'] as $p)
		if(preg_match('/'.$p.'/', $name))
			return false;

	foreach($privs['allow'] as $p)
		if(preg_match('/'.$p.'/', $name))
			return true;

	return false;
}

function allow_path($name)
{
	// echo $name.'<br>';

	if(isset($_SESSION['user']))
		return check_privs($_SESSION['user'], $name);

	require_once 'auth.php';
	foreach(load_users()['groups'] as $g)
		if($g['name'] == 'public')
			return check_privs($g, $name);

	return false;
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

	if(!allow_path($_SERVER['REQUEST_URI']))
		return array('method'=>'error', 'msg'=>'Permission denied');

	if(is_file($path) && !in_array(substr($path, -4), $handled_ext))
		return array('method'=>'download', 'file'=>$path);

	if(is_dir($path) || in_array(substr($path, -4), $handled_ext))
		return array('method'=>'display', 'path'=>$path);

	return array('method'=>'error', 'msg'=>'Unknown command');
}

function handle_action($action)
{
	global $DATA_PATH;
	switch($action)
	{
		case 'Login': require_once 'auth.php'; auth_action(); break;
		case 'Plugin':	if(!isset($_REQUEST['file']))
							print_error('No plugin specified');
						if(!allow_path($_REQUEST['file']))
							print_error('Acces denied');
						if(!is_file($DATA_PATH.'/'.$_REQUEST['file']))
							print_error('No such plugin');
						require $DATA_PATH.'/'.$_REQUEST['file'];
						break;
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

