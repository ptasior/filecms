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

	return array(array('login'=>'ja'));
}

if($_REQUEST['act'] == 'logout')
{
	unset($_SESSION);
	session_destroy();
	display('/');
}
else
{
	$file = load_users();

	if($_SESSION['user']['login'] != '') print_error('Already logged');
	if($_REQUEST['login'] == '') print_error('No credentials given');

	foreach($file as $u)
		if($u['login'] == $_REQUEST['login'])
		{
			$_SESSION['user'] = $u;
			display('/');
		}
	print_error('No such user');
}

?>

