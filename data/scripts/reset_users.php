<?php
	global $USERS_FILE;
	$users = array(
				'users'=> array(
					'ja'=>array(
							'groups'=>array('users'),
							'pwd'=>md5('qq')
						),
					'admin'=>array(
							'groups'=>array('admin'),
							'pwd'=>md5('xxx')
						)
					) ,
				'groups'=>array(
					'public'=>array(
							'allow'=>array(),
							'deny'=>array('^\/.*\/.*$', '^.*\.php$'),
						),
					'users'=>array(
							'allow'=>array('\/scripts\/search\.php'),
							'deny'=>array('^\/admin.*$', '^\/scripts.*$', '^.*\.php$'),
						),
					'admin'=>array(
							'allow'=>array('^.*$'),
							'deny'=>array(),
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
