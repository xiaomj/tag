<?php

require_once('./sample.class.php');
$s = new Sample();
$s->load();

header("location: tag.php?page=0");
