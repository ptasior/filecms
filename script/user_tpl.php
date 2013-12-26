<?php if(isset($_SESSION['user']['login'])):?>
	Logged user: <?=($_SESSION['user']['login'])?>
	<a href="/actionLogin?act=logout">Logout</a>
<?php else:?>
	<form action="actionLogin" method="post">
		<input type="text" name="login"> </input>
		<input type="text" name="password"> </input>
		<input type="submit" value="Login"></input>
	</form>
<?php endif?>

