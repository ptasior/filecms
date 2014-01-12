<?php
	global $LOGO_FILE;

	if(isset($_REQUEST['text']))
	{
		$fp = fopen($LOGO_FILE, "w");
		if($fp === false)
			print_error('Cannot open the file');

		fwrite($fp, $_REQUEST['text']);
		fclose($fp);

		forward($_REQUEST['file']);
	}

	$content = file_get_contents($LOGO_FILE);
?>

<h1>Edit Logo</h1>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<textarea cols="50" rows="10" name="text"><?=$content?></textarea>
	<input type="submit" value="Save"></input>
</form>

Whatever you're going to put here remember that it's displayed on every page and should look aesthetically<br><br>

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

