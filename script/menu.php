<?php

function list_dir($path)
{
	$list = [];
	if ($handle = opendir($path))
	{
		while (false !== ($entry = readdir($handle)))
		{
			if(!allow_path($entry)) continue;
			if($entry[0] == ".") continue;
			$tmp = $path.'/'.$entry;
			if(!is_dir($tmp)){ $list[] = $entry; continue;}

			$list[] = array('name'=>$entry,
					'path'=>substr($path, strlen(dirname($path))).'/'.$entry,
					'list'=>list_dir($tmp));
		}
		closedir($handle);
	}
	return $list;
}
$t = array('tree'=>array('name'=>'/', 'path'=>'', 'list'=>list_dir('data')));
template('menu', $t);
?>
