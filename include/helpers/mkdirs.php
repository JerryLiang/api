<?php

function _mkdirs( $dirname ) {
	if( file_exists( $dirname ) ) {
		return true;
	} else {
		if( _mkdirs(dirname($dirname)) ) {
		$ret = mkdir( $dirname );
		chmod($dirname, 0777);
		return $ret;
		} else {
		return false;
		}
	}
}

function _fopen_force( $file_name, $mode ) {
	if( ($f = @fopen( $file_name, $mode )) ) {
		return $f;
	} else {
		if( _mkdirs( dirname( $file_name ) ) ) {
		return fopen( $file_name, $mode );
		} else {
		return false;
		}
	}
}

/*
根据字符串, 生成cache文件的路径
*/
function _genCacheFilePath( $baseDir, $url ) {
	$md5String = strtoupper( md5( $url ) );
		return sprintf("%s/%s/%s", $baseDir, substr($md5String, 0, 2), $md5String );
	}

function _genCacheFilePath2( $baseDir, $url ) {
	$md5String = strtoupper( md5( $url ) );
	$p1 = substr($md5String, 0, 2);
	$p2 = substr($md5String, 2, 2);
	return sprintf("%s/%s/%s/%s", $baseDir, $p1, $p2, $md5String );
}

/*
根据字符串, 生成hash文件的路径
baseDir, 基准路径，路径的最后没有斜杠，例如： /home/image_c
src, 用于生成hash文件的源字符串, 可以是 url 或者其它的任意字符串
hashLevel, 支持 0,1,2,3三种层次的hash层次
firstHash, 第一层次的hash目录分为多少个子目录，例如可以制造出16x256的目录结构
prefix, 文件名前面，可以增加任意前缀
suffix, 文件名后面，可以增加任意后缀
nameLen, 文件名的md5部分，的长度可选
*/
function _genHashFileByStr( $baseDir, $url, $hashLevel = 2, $firstHash = 256, $prefix = "", $suffix="", $nameLen = 16 ) {
	$md5String = strtoupper( substr( md5( $url ), 0, $nameLen ) );
	if( $hashLevel == 0 ) {
		return sprintf("%s/%s%s%s", $baseDir, $prefix, $md5String, $suffix );
	} else if( $hashLevel == 1 ) {
		$p1 = strtoupper( dechex( hexdec( substr($md5String, 0, 2) ) % $firstHash ) );
		if (strlen($p1)==1) { $p1 = "0".$p1; }
		return sprintf("%s/%s/%s%s%s", $baseDir, $p1, $prefix, $md5String, $suffix );
	} else if( $hashLevel == 2 ) {
		$p1 = strtoupper( dechex( hexdec( substr($md5String, 0, 2) ) % $firstHash ) );
		if (strlen($p1)==1) { $p1 = "0".$p1; }
		$p2 = substr($md5String, 2, 2);
		return sprintf("%s/%s/%s/%s%s%s", $baseDir, $p1, $p2, $prefix, $md5String, $suffix );
	} else {
		$p1 = strtoupper( dechex( hexdec( substr($md5String, 0, 2) ) % $firstHash ) );
		if (strlen($p1)==1) { $p1 = "0".$p1; }
		$p2 = substr($md5String, 2, 2);
		$p3 = substr($md5String, 4, 2);
		return sprintf("%s/%s/%s/%s/%s%s%s", $baseDir, $p1, $p2, $p3, $prefix, $md5String, $suffix );
	}
}

/*
根据数字, 生成hash文件的路径
baseDir, 基准路径，路径的最后没有斜杠，例如： /home/image_c
id, 用于生成hash文件的源字符串, 可以是 url 或者其它的任意字符串
prefix, 文件名前面，可以增加任意前缀
suffix, 文件名后面，可以增加任意后缀
batch, 最底层的数字保留多少位, 一般为100 eg: 
		1234567 => base/123/45/1234567.db
		如果设置为1000, 则
		1234567 => base/12/34/1234567.db
*/
function _genHashFileById( $baseDir, $id, $prefix = "", $suffix="", $batch = 100 ) {
	$p1 = strtoupper( dechex( floor( $id / 100 / $batch ) ) );
	if (strlen($p1)==1) { $p1 = "0".$p1; }
	$p2 = strtoupper( dechex( floor( $id / $batch ) % 100 ) );
	if (strlen($p1)==1) { $p1 = "0".$p1; }
	return sprintf( "%s/%s/%s/%s%d%s", $baseDir, $p1, $p2, $prefix, $id, $suffix );
}

?>