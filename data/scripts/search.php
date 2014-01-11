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

	function search($path='')
	{
		$results=glob($path.'*.txt');
		$search = trim($_REQUEST['q']);
		$res = array_filter($results, function ($item) use ($search) {
				if(!allow_path('/'.$item)) return false;
				return (stristr(file_get_contents($item), $search));
			});

		$dirs=glob($path.'*', GLOB_ONLYDIR);
		foreach($dirs as $d)
			$res = array_merge($res, search($d.'/'));

		return $res;
	}

	global $DATA_PATH;
	chdir($DATA_PATH);

	$time = microtime(true);
	$results = search();
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
	<hr><div><a href="/<?=$v?>"><?=basename(substr($v, 0, -4))?></a><br><?=$v?></div>
<?php endforeach?>


