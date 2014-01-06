<?php
if(!isset($_SESSION['user']))
	return;

global $SCRIPTS_PATH;
$urls = array();

if(allow_path('/'.$SCRIPTS_PATH.'/upload.php'))
	$urls = array_merge($urls, array(
		'upload_href'=>'/'.$SCRIPTS_PATH.'/upload.php?upload_to='.$request['url']));

if(allow_path('/'.$SCRIPTS_PATH.'/re_move.php'))
{
	$urls = array_merge($urls, array(
		'mkdir_href'=>'/'.$SCRIPTS_PATH.'/re_move.php?mkdir='.$request['url'],
		'rmdir_href'=>'/'.$SCRIPTS_PATH.'/re_move.php?rmdir='.$request['url']));
	if(isset($params['file']))
		$urls = array_merge($urls, array(
			'rename_href'=>'/'.$SCRIPTS_PATH.'/re_move.php?rename='.$params['file'],
			'remove_href'=>'/'.$SCRIPTS_PATH.'/re_move.php?remove='.$params['file']));
}

if(allow_path('/'.$SCRIPTS_PATH.'/edit.php'))
	$urls = array_merge($urls, array(
		'edit_href'=>'/'.$SCRIPTS_PATH.'/edit.php?edit='.$request['url']));


if($params['mod'] == 'upload')    template('upload', $urls);
else if($params['mod'] == 'ctrl') template('panel', $urls);
else if($params['mod'] == 'edit') template('edit', $urls);
else                              print_error('Unknown action in panel.php');

?>

