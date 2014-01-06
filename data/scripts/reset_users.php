<?php
	global $USERS_FILE;
	$users = array('users'=> array('ja'=>'qq', 'admin'=>'xxx') ,
				'groups'=>array(
					'public'=>array(
							'allow'=>array('^\/[^\/]*$'),
							'deny'=>array('\.php$'),
							'users'=>array()
						),
					'users'=>array(
							'allow'=>array('.*'),
							'deny'=>array('^\/admin.*', '^\/scripts.*', '\.php$'),
							'users'=>array('ja')
						),
					'admin'=>array(
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

	fwrite($fp, json_encode($users));

	flock($fp, LOCK_UN);
	fclose($fp);
	echo 'done';
?>
