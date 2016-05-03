<?php
require_once('sample.class.php');
require_once('config.php');
$s = new Sample();
$s->export();
$filepath = DEFAULT_EXPORT_FILEPATH;
if (file_exists($filepath)) {
	header('Content-Type: text/plain');
	header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
	header('Content-Length: '.filesize($filepath));
	readfile($filepath);
}
