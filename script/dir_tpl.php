<h1>Content</h1>

<?php foreach($params['files'] as $l):?>
	<a href="<?=$params['path'].$l?>"><?=$l?></a><br/>
<?php endforeach;?>

