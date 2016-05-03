<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8" />
	<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
	<script type="text/javascript" src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
	<link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		body {
			margin: 20px;
		}
	</style>
</head>
<body>
	<table class="table">
		<thead>
		<tr>
			<th>小说名</th>
			<th>src</th>
			<th>dst</th>
			<th>unified</th>
			<th>纠错</th>
			<th>已解决</th>
			<th>不可访问</th>
		</tr>
		</thead>
		<tbody>
<?php
$pagenum=$_GET['page'];
require_once('./sample.class.php');
$s = new Sample();
$d = $s->getpage($pagenum);
$pagesum = $s->getpagesum();
foreach ($d as $i) { 
?> 
		<tr>
			<td><?=$i[0]?></td>
			<td><a href="<?=$i[1]?>"><?=$i[1]?></a></td>
			<td><a href="<?=$i[2]?>"><?=$i[2]?></a></td>
			<td><?=!$i[5]?'合并':'不合并'?></td>
			<td><input type="checkbox" data-src=<?=$i[1]?> data-dst=<?=$i[2]?> class='correct'></input></td>
			<td><input type="checkbox" data-src=<?=$i[1]?> data-dst=<?=$i[2]?> class='solve' <?=$i[6]?checked:''?>></input></td>
			<td><input type="checkbox" data-src=<?=$i[1]?> data-dst=<?=$i[2]?> class='unreach'<?=$i[7]?checked:''?>></input></td>
			<td><a href="diff.php?src=<?=$i[1]?>&dst=<?=$i[2]?>">对比</a></td>
		</tr>
<?php } ?>
		</tbody>
	</table>

<ul class="pagination">
<li><a href="#">&laquo;</a></li>

<?php
for ($i=0; $i<$pagesum; $i+=1) {
        if ($i === (int)$pagenum) {
                echo "<li class='active'><a href='?page=".$i."'>".$i."</a></li>";
        } else {
                echo "<li><a href='?page=".$i."'>".$i."</a></li>";
        }
}
?>
<li><a href="#">&raquo;</a></li>
</ul>

</body>

<script type="text/javascript">
	function register() {
		$(".correct").click(function(){
			var src=$(this).attr('data-src');
			var dst=$(this).attr('data-dst');
			$.ajax("correct.php?src="+src+"&dst="+dst).done(function(ret){console.log('ret'); window.location.reload();});
		});
		$(".solve").click(function() {
			var src=$(this).attr('data-src');
			var dst=$(this).attr('data-dst');
			$.ajax("solve.php?src="+src+"&dst="+dst).done(function(ret){console.log('ret'); window.location.reload();});
		});
		$(".unreach").click(function() {
			var src=$(this).attr('data-src');
			var dst=$(this).attr('data-dst');
			$.ajax("unreach.php?src="+src+"&dst="+dst).done(function(ret){console.log('ret'); window.location.reload();});
		});
	}

	$(document).ready(function() {
		register();
	});
</script>
</html>
