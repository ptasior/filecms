<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<style>
body{
	text-align: center;
	background-color: #507642;
	color: #F3F4EC;
}
ul{
	padding-left: 15px;
}
h1, h2, h3, h4{
	margin: 0;
	padding: 1px 5px;
	background-color: #A37B45;
	color: #507642;
}
a{
	color: #CCCFBC;
}
a:visited{
}
#main_box{
	margin: 0 auto;
	width: 1000px;
	text-align: left;
}
.box{
	margin: 5px;
	padding: 5px;
	border: 1px solid black;
	background-color: #86942A;
	border-radius: 5px;
}
#top{
	width: 977px;
}
#menu{
	width: 150px;
	float: left;
}
#content{
	width: 805px;
	float: left;
}
</style>
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

