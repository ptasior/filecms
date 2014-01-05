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
				if(!isset($users['groups'][$_REQUEST['group']]))
					print_error('Such group doesn\'t exists');
				unset($users['groups'][$_REQUEST['group']]);
				break;
			case 'name':
				if(!isset($users['groups'][$_REQUEST['group']]))
					print_error('Such group doesn\'t exists');
				$tmp = $users['groups'][$_REQUEST['group']];
				unset($users['groups'][$_REQUEST['group']]);
				$users['groups'][$_REQUEST['name']] = $tmp;
				break;
			case 'allow':
				if(!isset($users['groups'][$_REQUEST['group']]))
					print_error('Such group doesn\'t exists');
				$users['groups'][$_REQUEST['group']]['allow'] =
												split("\n", $_REQUEST['allow']);
			case 'deny':
				if(!isset($users['groups'][$_REQUEST['group']]))
					print_error('Such group doesn\'t exists');
				$users['groups'][$_REQUEST['group']]['deny'] =
												split("\n", $_REQUEST['deny']);
			case 'users':
				if(!isset($users['groups'][$_REQUEST['group']]))
					print_error('Such group doesn\'t exists');
				$users['groups'][$_REQUEST['group']]['users'] =
												split("\n", $_REQUEST['users']);
				break;
			case 'add':
				if(isset($users['groups'][$_REQUEST['name']]))
					print_error('Such group already exists');
				$users['groups'][$_REQUEST['name']] = array(
							'allow'=> split("\n", $_REQUEST['allow']),
							'deny'=> split("\n", $_REQUEST['deny']),
							'users'=> split("\n", $_REQUEST['users'])
							);
				break;
		}

		$fp = fopen($USERS_FILE, "w");
		if($fp === false)
			print_error('Cannot open users database');

		if(!flock($fp, LOCK_EX))
			print_error('Cannot lock users database');

		fwrite($fp, json_encode($users, JSON_PRETTY_PRINT));

		flock($fp, LOCK_UN);
		fclose($fp);

		forward($_REQUEST['file']);
	}
?>

<?php foreach($users['groups'] as $name=>$g):?>
<h3><?=$name?></h3>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="group" value="<?=$name?>"></input>
	<input type="hidden" name="action" value="name"></input>
	<input type="text" name="name" value="<?=$name?>"></input>
	<input type="submit" value="Change name"></input>
</form>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="group" value="<?=$name?>"></input>
	<input type="hidden" name="action" value="allow"></input>
	Allow: <textarea name="allow"><?=join($g['allow'], "\n")?></textarea>
	<input type="submit" value="Change"></input>
</form>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="group" value="<?=$name?>"></input>
	<input type="hidden" name="action" value="deny"></input>
	Deny: <textarea name="deny"><?=join($g['deny'], "\n")?></textarea>
	<input type="submit" value="Change"></input>
</form>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="group" value="<?=$name?>"></input>
	<input type="hidden" name="action" value="users"></input>
	Users: <textarea name="users"><?=join($g['users'], "\n")?></textarea>
	<input type="submit" value="Change"></input>
</form>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="group" value="<?=$name?>"></input>
	<input type="hidden" name="action" value="del"></input>
	<input type="submit" value="Delete group"></input>
</form>
<hr>
<?php endforeach?>

<h3>Add new group:</h3>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="hidden" name="action" value="add"></input>
	Name: <input type="text" name="name"></input><br>
	Allow: <textarea name="allow"></textarea><br>
	Deny: <textarea name="deny"></textarea><br>
	Users: <textarea name="users"></textarea><br>
	<input type="submit" value="Add"></input>
</form>
