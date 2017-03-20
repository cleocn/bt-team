<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link type="text/css" href="/htmleditor/Public/build/min.css" rel="stylesheet" >
	<script src="/htmleditor/Public/build/lib.js"></script>
	<script src="/htmleditor/Public/assets/js/lib/require.js" data-main="Public/build/app"></script>
	<script type="text/javascript">
		var _config = {userid : <?php echo ($data["id"]); ?>,name : '<?php echo ($data["name"]); ?>'};
	</script>
	<style type="text/css">
	div.row-2{border-left:3px solid #6699FF;padding-left:5px;}
	div.row-1{border-left:3px solid #FF66CC;padding-left:5px;}
</style>
</head>
<body>
<header></header>
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
		<input type="text" placeholder="无标题">
		<div class="content" contenteditable="true">
			<div class="row-<?php echo ($data["id"]); ?>-1 row-<?php echo ($data["id"]); ?> ">从这里开始</div>
		</div>
	</div>
</div>
 	<footer></footer>
	<footer>&copy BT出口</footer>
	</body>
</html>