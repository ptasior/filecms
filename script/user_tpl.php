<?php global $SCRIPTS_PATH; ?>
<?php if(allow_path($SCRIPTS_PATH.'/search.php')):?>
	<form action="/<?=$SCRIPTS_PATH?>/search.php" method="get">
		<input type="text" name="q"
			value="<?php if(isset($_REQUEST['q'])) echo $_REQUEST['q'];?>" >
		</input>
		<input type="submit" name="b" value="search"></input>
	</form>
<?php endif?>

<?php if(isset($_SESSION['user']['login'])):?>
	Logged user: <em><?=($_SESSION['user']['login'])?></em>
	<a href="/actionLogin?act=logout" class="button" title="logout">Logout</a>
<?php else:?>
	<form action="/actionLogin" method="post">
		Login: <input type="text" name="login"> </input>
		Password: <input type="password" name="password"> </input>
		<input type="submit" value="Login"></input>
	</form>
<?php endif?>

