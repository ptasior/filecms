<?php
	if(!isset($_REQUEST['edit']))
	{
		$create_in = '/';
		if(isset($_REQUEST['create_in']))
			$create_in = $_REQUEST['create_in'].'/';
		?>
			<h3>Create a file</h3>
			<form action="<?=$user_path?>" method="get">
				<input type="text" name="edit" value="<?=$create_in?>"></input>
				<input type="submit" value="Create"></input>
			</form>
		<?php 
		return;
	}
	$file = $_REQUEST['edit'];

	if(is_dir($DATA_PATH.'/'.$file))
		if($file == '/') $file = '/index.txt';
		else $file .= '/index.txt';

	if(!allow_path($file))
		print_error('Acces deined');

	if(substr($file, -4) != '.txt')
		print_error('You can only edit .txt files');

	$actual_file = $DATA_PATH.'/'.$file;
	if(isset($_REQUEST['text']))
	{
		global $DATA_PATH;

		$fp = fopen($actual_file, "w");
		if($fp === false)
			print_error('Cannot open the file');

		fwrite($fp, $_REQUEST['text']);
		fclose($fp);
		forward($file);
	}

	if(!is_file($actual_file)) $content = '';
	else                       $content = file_get_contents($actual_file);
?>

<h3>Edit</h3>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="edit" value="<?=$_REQUEST['edit']?>"></input>
	<textarea cols="50" rows="10" name="text"><?=$content?></textarea>
	<input type="submit" value="Save"></input>
</form>

Syntax:
<ul>
<li>== Heading ==</li>
<li>=== Subheading ===</li>
<li>=== Subsubheading ====</li>
<li>'''' Bold-italic '''''</li>
<li>'' Bold '''</li>
<li>' Italic ''</li>
<li>[enter][enter] New Paragraph</li>
<li>--- Horizontal Line</li>
<li>: Indentation</li>
<li>:: Subindentation</li>
<li>* Unordered list (up to four levels "**** text")</li>
<li># Ordered list (up to four levels "#### text")</li>
<li>[[file:http://example.com/image.jpg title]] an image ([[file|img:http|https|ftp://example.com/image.jpg optional]])</li>
<li>[http://example.com An Example Link] a link ([http|https|ftp://example.com optional])</li>
</ul>
