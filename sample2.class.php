<?php

class Sample {
	private $PATH = 'novel-unified-sample.txt';
	private $DATA = array();
	private $IDINDEX = 5;
	private $SRCINDEX = 1;
	private $DSTINDEX = 2;
	
	private $PAGENUM = 20;

	function __construct() {
		$this->load();
	}

	function load() {
        	$fd = fopen($this->PATH, 'r');
        	while (($line = fgets($fd))) {
			$line = trim($line);
                	$parts = explode("\t", $line);
                	$this->DATA[] = $parts;
        	}
        	fclose($fd);
	}

	function save() {
        	$fd = fopen($this->PATH, 'w');
        	$i = 0;
        	for ($i; $i<count($this->DATA); $i++) {
                	fwrite($fd, implode("\t", $this->DATA[$i])."\n");
       		}
        	fclose($fd);
	}

	function reverse($input) {
	        if ($input === '1') {
        	        return '0';
	        } else {
                	return '1';
        	}
	}

	function correct($src, $dst) {
        	$i = 0;
        	for ($i; $i<count($this->DATA); $i++) {
                	if (trim($this->DATA[$i][$this->SRCINDEX]) === $src && trim($this->DATA[$i][$this->DSTINDEX]) === $dst) {
                        	$this->DATA[$i][$this->IDINDEX] = $this->reverse($this->DATA[$i][$this->IDINDEX]);
				return true;
                	}
        	}
		return false;
	}
	
	function getall() {
		return $this->DATA;
	}

	function getpage($index) {
		return array_slice($this->DATA, $this->PAGENUM * $index, $this->PAGENUM);
	}
	
	function getpagesum() {
		return count($this->DATA) / $this->PAGENUM;
	}
}

