<?php
global $DATA_PATH;

function list_dir($path)
{
	global $DATA_PATH;
	$list = array();
	if ($handle = opendir($path))
	{
		while (false !== ($entry = readdir($handle)))
		{
			if($entry[0] == ".") continue;
			$tmp = $path.'/'.$entry;
			if(!is_dir($tmp)) continue;

			$user_path = substr($path, strlen($DATA_PATH)).'/'.$entry;
			if(!allow_path($user_path.'/')) continue;

			$list[] = array('name'=>$entry,
					'path'=>$user_path,
					'list'=>list_dir($tmp));
		}
		closedir($handle);
	}

	sort($list);
	return $list;
}
$t = array('tree'=>array('name'=>'home', 'path'=>'/', 'list'=>list_dir($DATA_PATH)));
#var_dump($t);
template('menu', $t);
?>
