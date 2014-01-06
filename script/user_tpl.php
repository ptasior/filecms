<?php if(isset($_SESSION['user']['login'])):?>
	Logged user: <em><?=($_SESSION['user']['login'])?></em>
	<a href="/actionLogin?act=logout" class="button" title="logout">Logout</a>
<?php else:?>
	<form action="/actionLogin" method="post">
		Login: <input type="text" name="login"> </input>
		Password: <input type="text" name="password"> </input>
		<input type="submit" value="Login"></input>
	</form>
<?php endif?>

