<?php
require_once('DBUtils.class.php');
require_once('log.php');
require_once('config.php');

class Sample {
	private $DATA = array();
	private $dbUtils = NULL;

	function __construct() {
		$this->dbUtils = new DBUtils();
	}

	function load() {
        	$fd = fopen(PATH, 'r');
		$sql = "delete from novel_sample";
		$this->dbUtils->query($sql);
        	while (($line = fgets($fd))) {
			$line = trim($line);
                	$parts = explode("\t", $line);
			$sql = sprintf("insert into novel_sample(name, src, dst, _key, bayes, unify, solved) values('%s','%s','%s','%s','%s',%s,%d)",
				$parts[NAMEINDEX], 
				$parts[SRCINDEX], 
				$parts[DSTINDEX], 
				$parts[KEYINDEX],
				$parts[BAYESINDEX],
				$parts[UNIFYINDEX],
				0
			);
			$this->dbUtils->query($sql);
        	}
        	fclose($fd);
	}

	function save() {
        	$fd = fopen(PATH, 'w');
		$sql = "select name, src, dst, _key, bayes, unify from novel_sample";
		$result = $this->dbUtils->query($sql);
		while (($row = mysql_fetch_row($result))) {
                	fwrite($fd, implode("\t", $row)."\n");
		}	
        	fclose($fd);
	}

	function correct($src, $dst) {
		$sql = sprintf("update novel_sample set unify=(unify+1)%%2 where src='%s' and dst='%s'", $src, $dst);
		$this->dbUtils->query($sql) or error(mysql_error());
		$this->solve($src, $dst);
		return true;
	}

	function set_correct($src, $dst) {
		$sql = sprintf("update novel_sample set unify=1 where src='%s' and dst='%s'", $src, $dst);
		$this->dbUtils->query($sql) or error(mysql_error());
		$this->solve($src, $dst);
		return true;
	}

	function solve($src, $dst) {
		$sql = sprintf("update novel_sample set solved=(solved+1)%%2 where src='%s' and dst='%s'", $src, $dst);
		$this->dbUtils->query($sql);
		return true;
	}

	function set_solved($src, $dst) {
		$sql = sprintf("update novel_sample set solved=1 where src='%s' and dst='%s'", $src, $dst);
		$this->dbUtils->query($sql) or error(mysql_error());
		return true;
	}	

	function unreach($src, $dst) {
		$sql = sprintf("update novel_sample set unreach=(unreach+1)%%2 where src='%s' and dst='%s'", $src, $dst);
		$this->dbUtils->query($sql);
		return true;
	}

	function set_unreach($src, $dst) {
		$sql = sprintf("update novel_sample set unreach=1 where src='%s' and dst='%s'", $src, $dst);
		$this->dbUtils->query($sq);
		return true;
	}
	
	function getall() {
		$data = [];
		$sql = "select name, src, dst, _key, bayes, unify, solved, unreach from novel_sample order by name";
                $result = $this->dbUtils->query($sql);
                while (($row = mysql_fetch_row($result))) {
			$data[] = $row;
                }
		return $data;
	}

	function getpage($index) {
		$data = $this->getall();
		return array_slice($data, PAGENUM * $index, PAGENUM);
	}
	
	function getpagesum() {
		$data = $this->getall();
		return count($data) / PAGENUM;
	}

	function getnext($src, $dst) {
		$sql = sprintf("select src, dst from novel_sample where id>(select id from novel_sample where src='%s' and dst='%s' limit 1) limit 1", $src,$dst);
		$result = $this->dbUtils->query($sql);
		return mysql_fetch_row($result);
	}
	
	function getdetail($src,$dst) {
		$sql = sprintf("select * from novel_sample where src='%s' and dst='%s' limit 1", $src, $dst);
		$result = $this->dbUtils->query($sql);
		return mysql_fetch_row($result);
	}

	function export() {
		$fd = fopen(DEFAULT_EXPORT_FILEPATH, 'w');
		$sql = "select name, src, dst,_key,bayes, unify from novel_sample where unreach=0 and solved=1";
		$result = $this->dbUtils->query($sql);
		while (($row = mysql_fetch_row($result))) {
			fwrite($fd, implode("\t", $row)."\n");
		}
		fclose($fd);
	}
}


#$s = new Sample();
#print_r($s->getpage(0));
#$next = $s->getnext('http://novel.hongxiu.com/a/1089212', 'http://www.xs8.cn/book/242111/readbook.html');
#$detail = $s->getdetail($next[0], $next[1]);
#print_r($next);
#print_r($detail);
