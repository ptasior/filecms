<?php
	global $USERS_FILE;

	require_once 'script/auth.php';
	$users = load_users();

	if(isset($_REQUEST['file'])) // Writing
	{
		if(!isset($users['users'][$_SESSION['user']['login']]))
			print_error('Such user doesn\'t exists');

		if(strlen($_REQUEST['pwd']) < 4)
			print_error('Password is too short');

		$users['users'][$_SESSION['user']['login']]['pwd'] = md5($_REQUEST['pwd']);

		$fp = fopen($USERS_FILE, "w");
		if($fp === false)
			print_error('Cannot open users database');

		if(!flock($fp, LOCK_EX))
			print_error('Cannot lock users database');

		fwrite($fp, json_encode($users));

		flock($fp, LOCK_UN);
		fclose($fp);

		forward($_REQUEST['file'].'?ok');
	}
?>

<h1>Change password</h1>
<?php if(isset($_REQUEST['ok'])):?>
	<div>Password is changed</div><br>
<?php endif ?>

<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	New password: <input type="password" name="pwd"></input>
	<input type="submit" value="Change"></input>
</form>

