<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<title>Website</title>
<link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>
	<div id="main_box">
	<div id="logo" class="box"><h1>网页</h1></div>
	<div id="top" class="box">
		<?php module('user')?>
	</div>
	<div id="menu" class="box">
		<?php module('menu');?>
	</div>
	<div id="content" class="box">
		<?php module('content')?>
	</div>
	</div>
</body>
</html>

