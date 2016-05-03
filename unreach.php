<?php

$src = $_GET['src'];
$dst = $_GET['dst'];

require_once('sample.class.php');
$s = new Sample();
$ret = $s->unreach($src, $dst);
$ret = $s->set_solved($src, $dst);
header('Content-Type: application/json');

echo json_encode(['success'=>$ret]);
