<?php
/**
  这个模块是用来写日志用的

  LOG_LEVEL:
    EVENT  0  一些要求记录的事件，不可以屏蔽
    ERROR  1  
    WARN   2  
    INFO   3 
    DEBUG  4

  通过设置 conf.php 中的 LL_LEVEL 值，可以决定只输出 LEVEL小于等于指定值的LOG

  使用例子：
 
  _logger(_LL_DEBUG, 'hello world, this is my first log msg!' );
*/

include_once( dirname(__FILE__) . '/mkdirs.php');

// Log Level define
define( '_LL_EVENT', 0 );
define( '_LL_ERROR', 1 );
define( '_LL_WARN' , 2 );
define( '_LL_INFO' , 3 ); 
define( '_LL_DEBUG', 4 ); 

/**
  根据LOG LEVEL和当前的日期来生成LOG输出文件的路径, 例如

  ~/log/event_20040806.log

  每天生成一个文件
*/
function _genLogFilePath( $prefix ) {
	return sprintf("%s/%s_%s.log", LOG_FILE_PATH, $prefix, date('Ymd') );
}

function _logger( $level, $msg ) {
	static $logLevelMsg = array ( // 写入LOG文件中日志记录前的提示信息
		_LL_EVENT	=>	'Event',
		_LL_ERROR	=>	'Error',
		_LL_WARN	=>	'Warn',
		_LL_INFO	=>	'Info',
		_LL_DEBUG	=>	'Debug',
	);
	static $logFilePrefix = array ( // 输出文件的前缀
		_LL_EVENT	=>	'event',
		_LL_ERROR	=>	'error',
		_LL_WARN	=>	'error',
		_LL_INFO	=>	'debug',
		_LL_DEBUG	=>	'debug',
	);

	if( $level == _LL_EVENT || ( $level <= MAX_LOG_LEVEL && $level >= 0 ) ) {
		$logMsg = sprintf( "%s #%d %s: %s\r\n", date('Y-m-d H:i:s'), getmypid(), $logLevelMsg[$level], $msg );
		$logFileName = _genLogFilePath( $logFilePrefix[$level] );
		$f = _fopen_force ($logFileName, 'a+');
		if ($f) {
			fwrite($f, $logMsg);
			fclose($f);
		}
		chmod($logFileName, 0666);
	}
}

function _log_runtime($prefix = '') {
    static $execution_time_t1;
    static $execution_step = 0;
    if (empty($execution_time_t1)) $execution_time_t1 = microtime(true);
    $execution_step++;
    $t2 = microtime(true);
    $exec_time = ($t2 - $execution_time_t1)*1000;
    _logger( _LL_DEBUG, $prefix  . ' ' . sprintf("Step%s %.2fms", $execution_step, $exec_time));
    $execution_time_t1 = $t2;
    return $exec_time;
}
?>