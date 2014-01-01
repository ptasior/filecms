<?php
function load_users()
{
// $tab = ['qq'=>'rq', 'aa'=>'bb'];
// $tab[] = $tab;
// $ret = json_encode($tab, JSON_PRETTY_PRINT);
// var_dump($ret);
// echo "<br><br>";
// 
// $z = json_decode($ret);
// var_dump($z);

	// create a mutex at read/write
	// todo handle extensions (.php!)
	// Make a copy of the file
	return array('users'=> array('ja'=>'qq', 'admin'=>'xxx') ,
				'groups'=>array(
					array(  'name'=>'public',
							'allow'=>array('^\/[^\/]*$'),
							'deny'=>array('\.php$'),
							'users'=>array()
						),
					array(  'name'=>'users',
							'allow'=>array('.*'),
							'deny'=>array('^\/admin.*', '\.php$'),
							'users'=>array('ja')
						),
					array(  'name'=>'admin',
							'allow'=>array('.*'),
							'deny'=>array(),
							'users'=>array('admin')
						)
					));
}

function auth_action()
{
	if(isset($_REQUEST['act']) && $_REQUEST['act'] == 'logout')
	{
		unset($_SESSION);
		session_destroy();
		display('/');
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

	display('/');
}
?>

