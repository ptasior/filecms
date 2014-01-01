<?php
global $DATA_PATH;

function list_files($path)
{
	global $DATA_PATH;
	$list = [];
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
	// var_dump($t);
	template('dir', $t);
}
else if(is_file($path))
{
	if(!allow_path($user_path))
		print_error('No priviledges to see this');

	if(substr($path, -4) == '.txt')
		echo file_get_contents($path);
	else if(substr($path, -4) == '.php')
		include $path;
	else echo 'Unhandled extension';
}
else
	echo 'Que?'.$path;
?>

