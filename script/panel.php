<?php
if(!isset($_SESSION['user']))
	return;

global $SCRIPTS_PATH;

if($params['mod'] == 'upload')
{
	$params = array(
		'upload_href'=>'/'.$SCRIPTS_PATH.'/upload.php?upload_to='.$request['url'],
		'mkdir_href'=>'/'.$SCRIPTS_PATH.'/re_move.php?mkdir='.$request['url'],
		'rmdir_href'=>'/'.$SCRIPTS_PATH.'/re_move.php?rmdir='.$request['url']);
	template('upload', $params);
}
else if($params['mod'] == 'ctrl')
{
	$params = array(
		'rename_href'=>'/'.$SCRIPTS_PATH.'/re_move.php?rename='.$params['file'],
		'remove_href'=>'/'.$SCRIPTS_PATH.'/re_move.php?remove='.$params['file']);

	template('panel', $params);
}
else print_error('Unknown action in panel.php');

?>

