<?php global $SCRIPTS_PATH; ?>
<h1>Search</h1>
<form action="/<?=$SCRIPTS_PATH?>/search.php" method="get">
	<input type="text" name="q"
		value="<?php if(isset($_REQUEST['q'])) echo $_REQUEST['q'];?>" >
	</input>
	<input type="submit" name="b" value="search"></input>
</form>

<?php
	if(!isset($_REQUEST['q']))
		return;

	function search($path='./')
	{
		// echo $path.'<br>';
		$search_what = trim($_REQUEST['q']);
		if(!($handle = opendir($path)))
			return array();

		$res = array();

		while (false !== ($entry = readdir($handle)))
			if(is_file($path.$entry))
			{
				if(substr($entry, -4) != '.txt') continue;

				if(!allow_path(substr($path.$entry, 1))) continue;

				if(stristr(file_get_contents($path.$entry), $search_what))
					$res[] = substr($path.$entry, 1);
			}
			else if(is_dir($path.$entry) && $entry[0] != '.')
				$res = array_merge($res, search($path.$entry.'/'));
			
		closedir($handle);

		return $res;
	}

	global $DATA_PATH;
	chdir($DATA_PATH);

	$time = microtime(true);
	$results = search();
	sort($results);
	$time = microtime(true) - $time;

	chdir('..');
?>

<div>
	<?php if(!count($results)):?>
		No results for query "<?=$_REQUEST['q']?>"
	<?php else:?>
		Results for query
	<?php endif?>
	(<?=round($time*1000, 2)?>ms)
</div>

<?php foreach($results as $v):?>
	<hr><div><a href="<?=$v?>"><?=basename(substr($v, 0, -4))?></a><br><?=$v?></div>
<?php endforeach?>


