<?php
global $DATA_PATH;

function list_files($path)
{
	$list = [];
	if ($handle = opendir($path))
	{
		while (false !== ($entry = readdir($handle)))
		{
			if(!allow_path($entry)) continue;
			if($entry[0] == ".") continue;
			$tmp = $path.'/'.$entry;
			if(is_dir($tmp)) continue;

			$list[] = $entry;
		}
		closedir($handle);
	}
	return $list;
}

$path = $request['path'];
if(is_dir($path))
{
	$t = array( 'path'=>substr($path, strlen($DATA_PATH)+2),
				'files'=>list_files($path));
	// var_dump($t);
	template('dir', $t);
}
else if(is_file($path))
{
	if(!allow_path($entry))
	{
		echo 'No priviledges to see this';
		return;
	}
	if(substr($path, -4) == '.txt')
		echo file_get_contents($path);
	else if(substr($path, -4) == '.php')
		include $path;
	else echo 'Unhandled extension';
}
else
	echo 'Que?'.$path;
?>

