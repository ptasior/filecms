<?php
global $DATA_PATH;

function list_files($path)
{
	global $DATA_PATH;
	$list = array();
	if ($handle = opendir($path))
	{
		while (false !== ($entry = readdir($handle)))
		{
			if($entry[0] == ".") continue;
			$tmp = $path.'/'.$entry;
			if(is_dir($tmp)) continue;

			$user_path = substr($path, strlen($DATA_PATH)+2).'/'.$entry;
			if(!allow_path($user_path)) continue;

			$list[] = $entry;
		}
		closedir($handle);
	}
	return $list;
}

function show_file($file)
{
	require_once('wiky.php');
	$wiky = new wiky;

	$input = file_get_contents($file);
	$input = htmlspecialchars($input);
	template('show', array('txt'=>$wiky->parse($input)));
}

$path = $request['path'];
$user_path = substr($path, strlen($DATA_PATH)+1);

if(is_dir($path))
{
	if($user_path[strlen($user_path)-1] != '/')
		$user_path .= '/';

	if(!allow_path($user_path))
		print_error('No priviledges to see this');

	$t = array( 'path'=>$user_path,
				'files'=>list_files($path));
	template('dir', $t);
}
else if(is_file($path))
{
	if(!allow_path($user_path))
		print_error('No priviledges to see this');

	if(substr($path, -4) == '.txt')
		show_file($path);
	else if(substr($path, -4) == '.php')
		include $path;
	else print_error('Cannot open given extension');
}
else
	print_error('Don\'t know what to do with: '.$path);
?>

