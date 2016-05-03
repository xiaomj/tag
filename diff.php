<!DOCTYPE html>
<html>
<head>
<meta charset="utf8"/>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript" src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
$src = $_GET['src'];
$dst = $_GET['dst'];
require_once('./sample.class.php');
require_once('./config.php');
$s = new Sample();
$next = $s->getnext($src,$dst);
$detail = $s->getdetail($src,$dst);
?>
<div style="margin:20px; text-align: center;">
<input type="button" value="标错" id='correct' class="btn btn-primary" style="top:0px;margin-left: 10px;"></input>
<input type="button" style="margin-left:40px;" id='solve' class="btn btn-primary" value="标记为已处理"<?=$detail[SOLVEINDEX]?'disabled':''?>></input>
<input type="button" style="margin-left:40px;" id="unreach" class="btn btn-primary" value="标记为不可访问" <?=$detail[UNREACHINDEX]?'disabled':''?>></input>
<input type="button" style="margin-left:40px;" id="next" class="btn btn-primary" value="下一条记录>>"></input>
<label style="margin-left: 40px">目前处理结果：<?=$detail[UNIFYINDEX]?'不合并':'合并'?></label>
</div>
<div style="margin-left:1%">
<iframe src="<?=$src?>" width=50% height=900px>
  <p>Your browser does not support iframes.</p>
</iframe>
<iframe src="<?=$dst?>" width=49% height=900px>
  <p>Your browser does not support iframes.</p>
</iframe>
</div>
<script type="text/javascript">
$("#next").click(function() {
	window.location="?src=<?=$next[0]?>&dst=<?=$next[1]?>";
});
$("#unreach").click(function() {
	$.ajax("unreach.php?src=<?=$src?>&dst=<?=$dst?>").done(function(ret){
		console.log(JSON.stringify(ret));
		if (!ret['success']) {
			alert('失败!');
		} else {
			$("#unreach").each(function() {
				$(this).attr('disabled', true);
			});
			$("#solve").attr('disabled', true);

		}
	});
});
$("#solve").click(function() {
	$.ajax("solve.php?src=<?=$src?>&dst=<?=$dst?>").done(function(ret) {
		if (ret['success']) {
			$("#solve").attr('disabled', true);
		}
	});
});
$("#correct").click(function() {
	$.ajax("correct.php?src=<?=$src?>&dst=<?=$dst?>").done(function(ret) {
		if (ret['success']) {
			$("#correct").attr('disabled', true);
			$("#solve").attr('disabled', true);
		}
	});
});
</script>
</body>
</html>
