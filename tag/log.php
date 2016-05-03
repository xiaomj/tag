<?php

function error($msg) {
	error_log($msg.'\n', 3, './log.txt');
}
