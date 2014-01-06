<div id="panel">
<?php if(isset($params['upload_href'])):?>
	<a href="<?=$params['upload_href']?>">Upload a file</a>
<?php endif ?>
<?php if(isset($params['mkdir_href'])):?>
	<a href="<?=$params['mkdir_href']?>">Create a directory</a>
<?php endif ?>
<?php if(isset($params['rmdir_href'])):?>
	<a href="<?=$params['rmdir_href']?>">Remove the directory</a>
<?php endif ?>
</div>

