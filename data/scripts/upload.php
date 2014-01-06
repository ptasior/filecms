<?php
if(!isset($_REQUEST['upload_to']))
	print_error('Script cannot be invoked like this');

if(count($_FILES))
{
	global $DATA_PATH;
	$uplTo = $_REQUEST['upload_to'];

	foreach($_FILES as $file)
	{
		if ($file["error"] > 0)
			print_error('Error: '.$file["error"]);

		if (!allow_path($uplTo))
			print_error('Access to location is denied');

		$name = preg_replace('/[^a-zA-Z0-9\._~]/', '_', $file["name"]);
		if (file_exists($DATA_PATH.'/'.$uplTo.'/'.$name))
			print_error($name.' already exists.');

		if(substr($name, -4) == '.php')
			print_error('This extension is forbidden');

		move_uploaded_file($file['tmp_name'], $DATA_PATH.'/'.$uplTo.'/'.$name);

		// echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		// echo "Type: " . $_FILES["file"]["type"] . "<br>";
		// echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		// echo "Stored in: " . $_FILES["file"]["tmp_name"];
	}

	forward($uplTo);
}
?>

<form action="/actionPlugin?file=<?=filename(__FILE__)?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="location" value="<?=$user_path?>"></input>
	<input type="hidden" name="upload_to" value="<?=$_REQUEST['upload_to']?>"></input>
	File: <input type="file" name="file" id="file"><br>
	<input type="submit" name="submit" value="Upload">
</form>

