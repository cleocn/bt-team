<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="/Public/build/lib.js"></script>
	<script src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js" data-appid="101139503" data-callback="true" data-redirecturi="http://im.5i5s.net" charset="utf-8"></script>
	<script type="text/javascript" src="/Public/assets/js/lib/bootstrap.min.js"></script>
	<link type="text/css" href="/Public/build/min.css" rel="stylesheet" >
	<script type="text/javascript">
		var _config = {userinfo : null,CONTROLLER_NAME : '/Home/<?php echo CONTROLLER_NAME;?>',path : '/'},
			_is_back = false,
			node = null,
			friend = [];
		function log(val){
			console.log(val);
		}
	</script>
	<style type="text/css">
		.navbar{width:100%;border-radius:0;margin:0;border:0;}
		.menu{margin:auto;width:100%;}
		.navbar-default{background: none;}
		.user img{width:30px;height: 30px;border-radius: 20px;margin-right:5px;}
		#edit-box .row-1{border-left:2px solid #ff0000;}
		.dropdown-menu{min-width: 120px;}
		.navbar-right .dropdown-menu{left:0;}
		.dropdown-menu .divider{height: 2px;}
	</style>
</head>
<body>
<header>
	<div class="menu">
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid"> 
			    <div class="navbar-header">
			        <a class="navbar-brand" href="#">BT 文档</a>
			    </div>
			    <?php if(! empty($data['is_login'])): ?><!--向右对齐-->
			        <ul class="nav navbar-nav navbar-right">
			            <li class="dropdown">
			                <a href="#" class="dropdown-toggle user" data-toggle="dropdown"><img src="">...</a>
			                <ul class="dropdown-menu">
			                	<li><a></a></li>
			                	<li class="divider"></li>
			                    <li><a href="<?php echo U('logout');?>" class="logout">退出</a></li>
			                </ul>
			            </li>
			        </ul><?php endif; ?>
			</div>
		</nav>
	</div>
</header>

<div class="html">
	<!-- 控制 -->
	<div class='Controls' class='span9' style=' padding:5px;'>
		<div class='btn-group'>
			<a class='btn' data-role='undo' href='#'><i class='icon-undo'></i></a>
			<a class='btn' data-role='redo' href='#'><i class='icon-repeat'></i></a>
		</div>
		<div class='btn-group'>
			<a class='btn' data-role='bold' href='#'><b>Bold</b></a>
			<a class='btn' data-role='italic' href='#'><em>Italic</em></a>
			<a class='btn' data-role='underline' href='#'><u><b>U</b></u></a>
			<a class='btn' data-role='strikeThrough' href='#'><strike>abc</strike></a>
		</div>
		<div class='btn-group'>
			<a class='btn' data-role='justifyLeft' href='#'><i class='icon-align-left'></i></a>
			<a class='btn' data-role='justifyCenter' href='#'><i class='icon-align-center'></i></a>
			<a class='btn' data-role='justifyRight' href='#'><i class='icon-align-right'></i></a>
			<a class='btn' data-role='justifyFull' href='#'><i class='icon-align-justify'></i></a>
		</div>
		<div class='btn-group'>
			<a class='btn' data-role='indent' href='#'><i class='icon-indent-right'></i></a>
			<a class='btn' data-role='outdent' href='#'><i class='icon-indent-left'></i></a>
		</div>
		<div class='btn-group'>
			<a class='btn' data-role='insertUnorderedList' href='#'><i class='icon-list-ul'></i></a>
			<a class='btn' data-role='insertOrderedList' href='#'><i class='icon-list-ol'></i></a>
		</div>
		<div class='btn-group'>
			<a class='btn' data-role='h1' href='#'>h<sup>1</sup></a>
			<a class='btn' data-role='h2' href='#'>h<sup>2</sup></a>
			<a class='btn' data-role='p' href='#'>p</a>
		</div>
		<div class='btn-group'>
			<a class='btn' data-role='subscript' href='#'><i class='icon-subscript'></i></a>
			<a class='btn' data-role='superscript' href='#'><i class='icon-superscript'></i></a>
		</div>
	</div>
	<!-- 正文 -->
	<div class='editor'>
		<input type="text" id="title" placeholder="无标题">
		<div class="content" contenteditable="true" id="edit-box">
			
		</div>
	</div>
</div>
<script type="text/javascript">
	node = document.getElementById('edit-box');
</script>
 	<script src="/Public/assets/js/lib/require.js" data-main="/Public/build/app"></script>
	<footer></footer>
	<footer>&copy BT出口</footer>
	</body>
</html>