<?php
	global $USERS_FILE;

	require_once 'script/auth.php';
	$users = load_users();

	if(isset($_REQUEST['file'])) // Writing
	{
		// Modify it
		switch($_REQUEST['action'])
		{
			case 'del':
				if(!isset($users['users'][$_REQUEST['login']]))
					print_error('Such user doesn\'t exists');
				unset($users['users'][$_REQUEST['login']]);
				break;
			case 'add':
				if(isset($users['users'][$_REQUEST['login']]))
					print_error('Such user already exists');
				$users['users'][$_REQUEST['login']] = $_REQUEST['password'];
				break;
			case 'change':
				if(!isset($users['users'][$_REQUEST['login']]))
					print_error('Such user doesn\'t exists');
				$users['users'][$_REQUEST['login']] = $_REQUEST['password'];
				break;
		}

		$fp = fopen($USERS_FILE, "w");
		if($fp === false)
			print_error('Cannot open users database');

		if(!flock($fp, LOCK_EX))
			print_error('Cannot lock users database');

		fwrite($fp, json_encode($users));

		flock($fp, LOCK_UN);
		fclose($fp);

		forward($_REQUEST['file']);
	}
?>

<?php foreach($users['users'] as $login=>$pwd):?>
<h3><?=$login?></h3>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="login" value="<?=$login?>"></input>
	<input type="hidden" name="action" value="change"></input>
	password: <input type="text" name="password"></input>
	<input type="submit" value="Change"></input>
</form>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="login" value="<?=$login?>"></input>
	<input type="hidden" name="action" value="del"></input>
	<input type="submit" value="Delete user"></input>
</form>
<hr>
<?php endforeach?>

<h3>Add new user:</h3>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="action" value="add"></input>
	login: <input type="text" name="login"> </input>
	password: <input type="text" name="password"> </input>
	<input type="submit" value="Add"></input>
</form>

