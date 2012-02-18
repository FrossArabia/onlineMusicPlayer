<?php
header("Content-type:text/html;charset=utf-8");
if(isset($_POST['query'])){
	$song = iconv("UTF-8","GBK",$_POST['query']);
    $url = 'http://mp3.sogou.com/lyric.so?query='.urlencode($song);
    $lyric_list=file_get_contents($url);
	$lyric_list=iconv("GBK","UTF-8",$lyric_list);
	$td_preg="/<div class=\"lyrbox\">(.*)<\/div>/iUs";
	    preg_match_all($td_preg,$lyric_list,$lyric);
	if(isset($lyric[1][0])){
	   echo $lyric[1][0];
	}else{
	   echo '对不起没有匹配的歌词';
	}
 }
?>