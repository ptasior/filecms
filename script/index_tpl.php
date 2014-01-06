<html>
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<style>
body{
	text-align: center;
	background-color: #003366;
	color: #006699;
}
#menu ul{
	padding-left: 8px;
	list-style-type: none;
	
}
#menu li{
	color: #097054;
}
#menu ul li:before {
		 content: "\00BB";
	     }
h1, h2, h3, h4{
	margin: 0;
	padding: 1px 5px;
	background-color: #FFCC00;
	color: #692DAC;
	border-bottom: black 1px solid;
	border-top: black 1px solid;
	border-right: black 1px solid;
	border-left: black 1px solid;
}
a{
	color: navy;
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
	background-color: #CCCCCC;
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
.button{
	padding: 0 2px;
	background-color: #AAAAAA;
	border: 1px solid gray;
	border-radius: 5px;
	color: black;
	font-size: 80%;
	text-decoration: none;
}
textarea, input {
	background-color: #DDDDDD;
	color: #006699;
}
#top{
	text-align: right;
}
#top form{
	margin: 0;
}
.breadcrumb{
	font-weight: bold;
}
#panel{
	text-align: right;
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

