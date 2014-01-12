<?php
	global $LOGO_FILE;

	if(!file_exists($LOGO_FILE)) return;

	require_once('wiky.php');
	$wiky = new wiky;

	$input = file_get_contents($LOGO_FILE);
	$input = htmlspecialchars($input);

	echo $wiky->parse($input);
?>

