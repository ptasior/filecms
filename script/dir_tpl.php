<h1>Content</h1>
<div>Path: <span class="breadcrumb"><?=$params['path']?></span></div>
<?php module('panel', array('mod'=>'upload'))?>

<?php foreach($params['files'] as $l):?>
	<a href="<?=$params['path'].$l?>"><?=$l?></a>
	<?php module('panel', array('mod'=>'ctrl', 'file'=>$params['path'].$l))?>
	<br/>
<?php endforeach;?>

