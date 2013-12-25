<?php
global $DATA_PATH;

function list_dir($path)
{
	global $DATA_PATH;
	$list = [];
	if ($handle = opendir($path))
	{
		while (false !== ($entry = readdir($handle)))
		{
			if(!allow_path($entry)) continue;
			if($entry[0] == ".") continue;
			$tmp = $path.'/'.$entry;
			if(!is_dir($tmp)) continue;

			$list[] = array('name'=>$entry,
					'path'=>substr($path, strlen($DATA_PATH)).'/'.$entry,
					'list'=>list_dir($tmp));
		}
		closedir($handle);
	}
	return $list;
}
$t = array('tree'=>array('name'=>'home', 'path'=>'/', 'list'=>list_dir($DATA_PATH)));
#var_dump($t);
template('menu', $t);
?>
