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
$t = array( 'path'=>substr($path, strlen($DATA_PATH)+2),
			'files'=>list_files($path));
// var_dump($t);
template('dir', $t);
?>

