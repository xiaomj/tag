<?php

$src = $_GET['src'];
$dst = $_GET['dst'];

require_once('sample.class.php');
$s = new Sample();
$ret = $s->correct($src, $dst);
error_log($ret, 3, 'log.txt');
$ret = $s->set_solved($src, $dst);
error_log($ret, 3, 'log.txt');
header('Content-Type: application/json');
echo json_encode(['success'=>$ret]);
