<?php
if(isset($_REQUEST['rename']))
	{$act = 'rename'; $file = $_REQUEST['rename'];}
else if(isset($_REQUEST['remove']))
	{$act = 'remove'; $file = $_REQUEST['remove'];}
else
	print_error('No such action');

global $DATA_PATH;
if(!allow_path($file))
	print_error('Access to resource is denied');

if($act == 'remove')
{
	if(!file_exists($DATA_PATH.'/'.$file))
		print_error('File doesn\'t exist');
	unlink($DATA_PATH.'/'.$file);
	forward(dirname($file));
}
else
{
	if(!isset($_REQUEST['new_name']))
	{?>
		<form action="/actionPlugin?file=<?=filename(__FILE__)?>" method="post">
			<input type="hidden" name="rename" value="<?=$file?>"></input>
			File: <input type="text" name="new_name" id="new_name" value="<?=dirname($file)?>"><br>
			<input type="submit" name="submit" value="Rename">
		</form>
	<?php }
	else
	{
		$new_name = preg_replace('/[^a-zA-Z0-9\._~\/]|\.{2,}/', '_', $_REQUEST['new_name']);
		$old_name = preg_replace('/[^a-zA-Z0-9\._~\/]|\.{2,}/', '_', $file);

		if(!allow_path($old_name))
			print_error('Old location is not alowed');

		if(!allow_path($new_name))
			print_error('New location is not alowed');

		if (!file_exists($DATA_PATH.'/'.$old_name))
			print_error($old_name.' doesn\'t exists.');

		if (file_exists($DATA_PATH.'/'.$new_name))
			print_error($new_name.' already exists.');

		rename($old_name, $new_name);
	}
}
?>


