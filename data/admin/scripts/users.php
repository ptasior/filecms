<?php
	global $USERS_FILE;

	$users = load_users();

	if(isset($_REQUEST['file'])) // Writing
	{
		// Modify it

		$fp = fopen($USERS_FILE, "w");
		if($fp === false)
			print_error('Cannot open users database');

		if(!flock($fp, LOCK_EX, 1)) // 1 - blocking
			print_error('Cannot lock users database');

		fwrite($fp, json_encode($users, JSON_PRETTY_PRINT));

		flock($fp, LOCK_UN);
		fclose($fp);

		forward($user_path);
	}

// $tab = ['qq'=>'rq', 'aa'=>'bb'];
// $tab[] = $tab;
// $ret = json_encode($tab, JSON_PRETTY_PRINT);
// var_dump($ret);
// echo "<br><br>";
// 
// $z = json_decode($ret);
// var_dump($z);

	if(isset($_REQUEST['file']))
		forward('/');
?>
<form action="/actionPlugin?file=<?=$user_path?>" method="post">
	<input type="text" name="login"> </input>
	<input type="text" name="password"> </input>
	<input type="submit" value="Login"></input>
</form>
