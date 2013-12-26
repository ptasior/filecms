<html>
<head>
<style>
ul{
	padding-left: 15px;
}
div{
	border: 1px solid black;
}
#top{
	width: 100%;
}
#menu{
	width: 100px;
	float: left;
}
#content{
	width: 600px;
	float: left;
}
</style>
</head>
<body>
	<div id="top">
		<?php module('user')?>
	</div>
	<div id="menu">
		<?php module('menu');?>
	</div>
	<div id="content">
		<?php module('content')?>
	</div>
</body>
</html>

