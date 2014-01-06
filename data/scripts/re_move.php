<?php
if(isset($_REQUEST['rename']))      $act = 'rename'; 
else if(isset($_REQUEST['remove'])) $act = 'remove';
else if(isset($_REQUEST['mkdir']))  $act = 'mkdir'; 
else if(isset($_REQUEST['rmdir']))  $act = 'rmdir'; 
else                                print_error('Script cannot be invoked like this');

$file = $_REQUEST[$act];

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
if($act == 'rmdir')
{
	if(!is_dir($DATA_PATH.'/'.$file))
		print_error('Directory doesn\'t exist');
	if(!rmdir($DATA_PATH.'/'.$file))
		print_error('Could not remove the directory. Is it empty?');
	forward(dirname($file));
}
else if($act == 'rename')
{
	if(!isset($_REQUEST['new_name']))
	{?>
		<form action="/actionPlugin?file=<?=filename(__FILE__)?>" method="post">
			<input type="hidden" name="rename" value="<?=$file?>"></input>
			Name: <input type="text" name="new_name" id="new_name" value="<?=dirname($file)?>"><br>
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

		forward(dirname($new_name));
	}
}
else if($act == 'mkdir')
{
	if(!isset($_REQUEST['name']))
	{?>
		<form action="/actionPlugin?file=<?=filename(__FILE__)?>" method="post">
			<input type="hidden" name="mkdir" value="<?=$file?>"></input>
			Name: <input type="text" name="name" id="new_name"><br>
			<input type="submit" name="submit" value="Create">
		</form>
	<?php }
	else
	{
		$name = preg_replace('/[^a-zA-Z0-9\._~\/]|\.{2,}/', '_', $_REQUEST['name']);
		$name = $file.'/'.$name;

		if(!allow_path($file))
			print_error('Old location is not alowed');

		if(!allow_path($name))
			print_error('New location is not alowed');

		if (is_dir($DATA_PATH.'/'.$name))
			print_error('Directory already exists');

		mkdir($DATA_PATH.'/'.$name);
		forward($name);
	}
}
?>


