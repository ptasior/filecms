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

				if(strlen($_REQUEST['login']) < 3)
					print_error('Login is too short');

				if(strlen($_REQUEST['pwd']) < 4)
					print_error('Password is too short');
				
				if(empty($_REQUEST['groups']))
					print_error('You must specify at least one group');

				$groups = array_map('trim', explode("\n", $_REQUEST['groups']));
				foreach($groups as $g)
					if(!isset($users['groups'][trim($g)]))
						print_error('Group '.$g.' doesn\'t exist');

				$users['users'][$_REQUEST['login']] = array(
												'pwd' => md5($_REQUEST['pwd']),
												'groups' => $groups);
				break;
			case 'password':
				if(!isset($users['users'][$_REQUEST['login']]))
					print_error('Such user doesn\'t exists');

				if(strlen($_REQUEST['pwd']) < 4)
					print_error('Password is too short');

				$users['users'][$_REQUEST['login']]['pwd'] =
														md5($_REQUEST['pwd']);
				break;
			case 'groups':
				if(!isset($users['users'][$_REQUEST['login']]))
					print_error('Such user doesn\'t exists');

				if(empty($_REQUEST['groups']))
					print_error('You must specify at least one group');

				$groups = array_map('trim', explode("\n", $_REQUEST['groups']));

				foreach($groups as $g)
					if(!isset($users['groups'][trim($g)]))
						print_error('Group '.$g.' doesn\'t exist');

				$users['users'][$_REQUEST['login']]['groups'] = $groups;
				break;
		}

		// var_dump($users);
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
	<input type="hidden" name="action" value="password"></input>
	Password: <input type="password" name="pwd"></input>
	<input type="submit" value="Change"></input>
</form>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="login" value="<?=$login?>"></input>
	<input type="hidden" name="action" value="groups"></input>
	Groups: <textarea name="groups"><?=join($users['users'][$login]['groups'], "\n")?></textarea>
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
	Login: <input type="text" name="login"> </input><br>
	Password: <input type="password" name="pwd"></input><br>
	Groups: <textarea name="groups"></textarea><br>
	<input type="submit" value="Add"></input>
</form>

