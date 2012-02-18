<?php
define('HOST','localhost');
define('USER','root');
define('PWD','');
define('DATABASE','toplists');
$conn=@mysql_connect(HOST,USER,PWD) or die('数据库连接出错');
mysql_select_db(DATABASE) or die('未找到指定数据库');
mysql_query('SET NAMES UTF8') or die('字符集错误');
