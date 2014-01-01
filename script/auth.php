<?php
function load_users()
{
	global $USERS_FILE;

	if(!is_file($USERS_FILE))
		return array('groups'=> array('public'=>array(
										'allow'=>array('.*'),
										'deny'=>array(),
										'users'=>array()
									)));

	$fp = fopen($USERS_FILE, "rb");
	if($fp === false)
		print_error('Cannot open users database');

	if(!flock($fp, LOCK_SH)) // 1 - blocking
		print_error('Cannot lock users database');

	$contents = fread($fp, filesize($USERS_FILE));
	flock($fp, LOCK_UN);
	fclose($fp);

	$users = json_decode($contents, true);
	if($users === NULL)
		print_error('Cannot decode users database');

	return $users;

	// Make a copy of the file
}

function auth_action()
{
	// todo handle extensions (.php!)
	if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'logout')
	{
		unset($_SESSION);
		session_destroy();
		forward('/');
		return;
	}

	$file = load_users();

	if(isset($_SESSION['user'])) print_error('Already logged');

	if(!isset($_REQUEST['login']) || $_REQUEST['login'] == '')
		print_error('No credentials given');

	$login = $_REQUEST['login'];

	if(!isset($file['users'][$login]))
		print_error('No such user');

	// Add pwd hashing
	if($_REQUEST['password'] != $file['users'][$login])
		print_error('Wrong pasword');

	$_SESSION['user']['login'] = $login;
	$allow = array();
	$deny = array();
	foreach($file['groups'] as $g)
		if(in_array($login, $g['users']))
		{
			$allow = array_merge($g['allow'], $allow);
			$deny = array_merge($g['deny'], $deny);
		}
	$_SESSION['user']['allow'] = $allow;
	$_SESSION['user']['deny'] = $deny;

	forward('/');
}
?>

