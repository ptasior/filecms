<?php
	global $USERS_FILE;
	$users = array('users'=> array('ja'=>'qq', 'admin'=>'xxx') ,
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

	$fp = fopen($USERS_FILE, "w");
	if($fp === false)
		print_error('Cannot open users database');

	if(!flock($fp, LOCK_EX))
		print_error('Cannot lock users database');

	fwrite($fp, json_encode($users, JSON_PRETTY_PRINT));

	flock($fp, LOCK_UN);
	fclose($fp);
	echo 'done';
?>