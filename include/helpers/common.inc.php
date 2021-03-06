<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

function diffdate($expire_date) {
	$diffdate = false;
	if (!empty($expire_date)) {
		$datetime1 = date_create('now');
		$datetime2 = date_create($expire_date);
		$interval = date_diff($datetime1, $datetime2);
		$diffdate = (int) $interval->format('%R%a');
	}
	return $diffdate;
}

/**
 * Determines if the current version of PHP is greater then the supplied value
 *
 * Since there are a few places where we conditionally test for PHP > 5
 * we'll set a static variable.
 *
 * @access	public
 * @param	string
 * @return	bool	TRUE if the current version is $version or higher
 */
if (!function_exists('is_php')) {

	function is_php($version = '5.0.0') {
		static $_is_php;
		$version = (string) $version;

		if (!isset($_is_php[$version])) {
			$_is_php[$version] = (version_compare(PHP_VERSION, $version) < 0) ? FALSE : TRUE;
		}

		return $_is_php[$version];
	}

}

/**
 * HTTP内容请求辅助函数
 * string $url 请求的url地址
 * array $data POST数据
 * array $headers 发送的http头信息
 * array $options curl的参数
 */
function httpfetch($url, $data = null, $headers = array(), $options = array()) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	if (!empty($options)) {
		curl_setopt_array($ch, $options);
	}

	if (!empty($headers))
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	if (!empty($data)) {
		curl_setopt($ch, CURLOPT_POST, 1);

		if (is_array($data)) {
			$postdata = '';
			foreach ($data as $key => $val) {
				//$postdata .= $key . '=' . urlencode($val) . '&';
				$postdata .= $key . '=' . $val . '&';
			}
			$data = trim($postdata, '&');
		}

		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 设置连接超时时间 2 秒
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	// 设置超时时间 10 秒
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	$out = curl_exec($ch);
	if ($out === false) {
		_logger(_LL_ERROR, 'Connect failed: ' . $url);
	} else {
		$out = trim($out);
	}
	curl_close($ch);
	// _logger(_LL_DEBUG, "content: $url, RESULT: $out");
	// $out = json_decode($out, true);
	return $out;
}

/**
 * 异步HTTP请求辅助函数,只发请求不等待返回结果
 * string $url 请求的url地址
 * array $data POST数据
 */
function async_httpfetch($url, $data = array()) {
	if (!empty($data) && is_array($data)) {
		$params = '';
		foreach ($data as $key => $val) {
			// im非标准http,不接受urlencode
			// $params .= $key . '=' . urlencode($val) . '&';
			$params .= $key . '=' . $val . '&';
		}
		$length = strlen($params);
		$method = 'POST';
	} else {
		$method = 'GET';
	}
	$url_array = parse_url($url);
	!empty($url_array['port']) || $url_array['port'] = 80;

	$fp = fsockopen($url_array['host'], $url_array['port'], $errno, $errstr, 5);
	if (!$fp) {
		_logger(_LL_ERROR, "Failed to open socket to " . $url_array['host'] . ":" . $url_array['port'] . "ERROR: $errno - $errstr");
		return false;
	} else {
		switch ($method) {
			case 'POST':
				$header = "POST " . $url_array['path'] . (!empty($url_array['query']) ? '?' . $url_array['query'] : '') . " HTTP/1.1\r\n";
				$header .= "Host: " . $url_array['host'] . "\r\n";
				$header .= "Content-Length: " . $length . "\r\n";
				$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
				$header .= "Connection: Close\r\n\r\n";
				$header .= $params . "\r\n";
				break;
			case 'GET':
			default:
				$header = "GET " . $url_array['path'] . (!empty($url_array['query']) ? '?' . $url_array['query'] : '') . " HTTP/1.1\r\n";
				$header .= "Host: " . $url_array['host'] . "\r\n";
				$header .= "Connection: Close\r\n\r\n";
				break;
		}
		fwrite($fp, $header);
		fclose($fp);
		return true;
	}
}

/**
 * CI_DB日志文件扩展函数
 */
if (!function_exists('log_message')) {

	function log_message($level = 'error', $message, $php_error = FALSE) {
		switch ($level) {
			case 'error':
				$level = _LL_ERROR;
				break;
			case 'debug':
				$level = _LL_DEBUG;
				break;
			default:
				$level = _LL_DEBUG;
				break;
		}
		_logger($level, $message);
	}

}

if (!function_exists('show_error')) {

	function show_error($message) {
		_logger(_LL_ERROR, $message);
	}

}

if (!function_exists('auth')) {

	function auth($pwd, $username, $public_key, $private_key = '') {
		if (DEBUG == true)
			return true;
		if ($pwd === md5($username . $public_key . $private_key))
			return true;
		return false;
	}

}

/**
 * 权重分配函数
 * @param array $weight 权重 例如array('a'=>200,'b'=>300,'c'=>500)
 * @return string key 键名
 */
function _roll($weight = array()) {
	$roll = rand(1, array_sum($weight));

	$_tmpW = 0;
	$rollnum = 0;
	foreach ($weight as $k => $v) {
		$min = $_tmpW;
		$_tmpW += $v;
		$max = $_tmpW;
		if ($roll > $min && $roll <= $max) {
			$rollnum = $k;
			break;
		}
	}
	return $rollnum;
}

//随机产生浮点数
function randomFloat($min = 0, $max = 1) {
	return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}

/**
 * 根据UA分析用户的终端类型、客户端版本号、屏幕分辨率
 * UA规范：//Mozilla/5.0 (Android; OS/10; Version/1.0.0; zh-cn;)
//Mozilla/5.0 (iPhone; OS/5.1.1; Version/V6.2.4; zh-cn; Ispb/UNPB;)
 */
function get_device() {
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$ua = $_SERVER['HTTP_USER_AGENT'];
	}
//	$ua = strtolower($ua);
//	var_dump(preg_match('/\((.+); os\/(\S+); version\/(\S+); (\S+)-(\S+); .*\)/i', $ua, $match));exit;
	if (!empty($ua) && preg_match('/\((.+); os\/(\S+); version\/(\S+); (\S+)-(\S+); .*\)/i', $ua, $match)) {
		if (!defined('CLIENT_PLATFORM')) {
			define('CLIENT_PLATFORM', strtolower($match[1]));
			if (CLIENT_PLATFORM == 'iphone') {
				if (preg_match('/ispb\/(\S+)/i', $ua, $match3)) {
					if (!defined('CLIENT_ISPB')) {
						define('CLIENT_ISPB', substr(strtolower($match3[1]), 0, strlen($match3[1]) - 2));
					}
				}
			}
		}

        if (!defined('CLIENT_OS')) {
			define('CLIENT_OS', strtolower($match[2]));
		}
		if (!defined('CLIENT_VERSION')) {
			define('CLIENT_VERSION', strtolower($match[3]));
		}
		if (!defined('CLIENT_LANGUAGE')) {
            $lang = strtolower($match[5]);
//            _logger(_LL_DEBUG,'common.inc.php,line:'.__LINE__.'lang:'.$lang);
            $lang_list = array('cn','en','it'); //目前支持语言
            foreach($lang_list as $v){
                $ret = stripos($lang,$v);
                if($ret !== false) {
                    $language = $v;
                    break;
                }
            }
            //暂时解决意大利语问题，默认英文
            if(empty($language)) $language='cn';
			define('CLIENT_LANGUAGE',$language);
		}
	}

    if (!defined('CLIENT_PLATFORM')) {
		define('CLIENT_PLATFORM', '');
	}
	if (!defined('CLIENT_OS')) {
		define('CLIENT_OS', '');
	}
	if (!defined('CLIENT_VERSION')) {
		define('CLIENT_VERSION', '');
	}
	if (!defined('CLIENT_LANGUAGE')) {
		define('CLIENT_LANGUAGE', '');
	}
}


//智能机显示错误错误码
function _display_error($errorno) {
//    $statuscode = array(
	$language = CLIENT_LANGUAGE;
	$language = !empty($language) ? $language : 'cn';
	include INCLUDE_PATH . 'config/lang/lang_'.$language.'.php';
    return $statuscode[$language][$errorno];
}

//功能机显示错误码
function _display_phone_error($errorno,$lang='cn') {
	$lang_list = array('cn','en'); //目前支持语言
	foreach($lang_list as $v){
		$ret = stripos($lang,$v);
		if($ret) {
			$language = $v;
			break;
		}
	}
	$language = !empty($language) ? $language : 'cn';
	include_once INCLUDE_PATH . 'config/lang/lang_'.$language.'.php';
	return $statuscode[$language][$errorno];
}


/**
 * @param $msg
 * @param $format
 * 输出格式
 */
function sendput($msg,$format){
	if($format == 'json'){
		$ret = array('status'=>$msg);
		echo json_encode($ret);
	}
	else{
		echo $msg;
	}
}

/**
 * @param $str
 * @param $url
 * @param $mobile
 * @return string
 * 短信输出格式
 */
function output($str,$url,$mobile,$code=''){
    $mobile = format_mobile($mobile);
    if($code == ''){
        $code = $url;
    }
    return sprintf($str,$mobile,$code,$url);
}

/**
 * @param int $length
 * @return string
 * 生成4位随机码
 */
function generate_password($length = 4)
{
	$chars = '0123456789';
	$password = '';
	for ($i = 0; $i < $length; $i++) {
		$password .= $chars[mt_rand(0, strlen($chars) - 1)];
	}
	return $password;
}

function shorturl($url) {
	$url = crc32($url);
	$result = sprintf("%u", $url);
	//return $url;
	//return $result;
	return code62($result);
}
//voip注册接口
function reg_voip($mobile){
    $mobile= format_mobile($mobile);
    $reg_url = 'http://www.byheetech.com/v2/m/regByMtk'; //注册接口
    $data = array('caller'=>$mobile,'client_id'=>'21088000203');
    $data = json_encode($data);
    $header = array('Content-Type: application/json','Content-Length: ' . strlen($data));
    $result = httpfetch($reg_url,$data,$header);
    return $result;
}
//充值接口
function charge_voip($mobile,$cardid,$cardpw){
    $mobile= format_mobile($mobile);
    $charge_url = 'http://www.byheetech.com/v2/m/rcgcardByMtk'; //充值接口
    $data = array('caller'=>$mobile,'cardid'=>$cardid,'cardpw'=>$cardpw,'client_id'=>'21088000203');
    $data = json_encode($data);
    $header = array('Content-Type: application/json','Content-Length: ' . strlen($data));
    $result = httpfetch($charge_url,$data,$header);
    return $result;
}
//打电话接口
function voip($caller,$called){
    $caller= format_mobile($caller);
    $called= format_mobile($called);
    $voip_url = 'http://www.byheetech.com/v2/m/cbByMtk'; //打电话接口
    $data = array('caller'=>$caller,'callee'=>$called,'client_id'=>'21088000203');
    $data = json_encode($data);
    $header = array('Content-Type:application/json','Content-Length:'.strlen($data));
    $result = httpfetch($voip_url,$data,$header);
    return $result;
}

function account($caller){
    $caller= format_mobile($caller);
    $voip_url = 'http://www.byheetech.com/v2/m/callerByMtk'; //打电话接口
    $data = array('caller'=>$caller,'client_id'=>'21088000203');
    $data = json_encode($data);
    $header = array('Content-Type:application/json','Content-Length:'.strlen($data));
    $result = httpfetch($voip_url,$data,$header);
    return $result;
}

/**
 * @param $mobile
 * @return string
 * 国内号码格式过滤
 */
function format_mobile($mobile){
    if(strpos($mobile,'0086') !== false){
        $str = substr($mobile,4);
    }
    return $str;
}


