<?php

class DBUtils {
	private $mysql_host = '210.32.133.17';
	private $mysql_port = '3309';
	private $mysql_user = 'wwx';
	private $mysql_password = '092408';
	private $mysql_db = 'test';

	private $db;
	

	function __construct() {
		$this->db = mysql_connect($this->mysql_host, $this->mysql_user, $this->mysql_password) or die("Could not connect: " . mysql_error());
		mysql_set_charset('utf8', $this->db);
		mysql_select_db($this->mysql_db);
	}

	function query($sql) {
		return mysql_query($sql);	
	}
}

#$dbUtils = new DBUtils();
#try {
#	$result = $dbUtils->query("insert into novel_sample(name, src, dst, _key, bayes, unify, solved) values('Novel@根据相关法律法规和政策，此作品未予显示。','http://novel.hongxiu.com/a/1059564/list.html','http://www.xs8.cn/book/241515/readbook.html','KEY(NO_LOG)','BAYES(0.500000,name:0.600000;0.600000)',1,0)") or die(mysql_error());
#} catch (Exception $e) {
#	echo $e->getMessage(),"\n";
#}

#print_r($result);

#$result = $dbUtils->query('select * from novel_sample');
#while (($row = mysql_fetch_row($result))) {
#	print_r($row);
#}

#?>
