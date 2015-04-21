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
    if (!empty($ua) && preg_match('/\((.+); os\/(\S+); version\/(\S+); zh-(\S+); .*\)/i', $ua, $match)) {
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
            define('CLIENT_LANGUAGE', strtolower($match[4]));
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

//错误码
function _display_error($errorno) {
    $statuscode = array(
        'cn' => array(
            "101" => "授权码有误,请重试",
            "102" => "参数有误,请重试",
            "1022" => "加密串有误,请重试",
            "104" => "登陆失败,请检查您的账号或密码是否正确",
            "105" => "抱歉,此账号已注册,请重试",
            "106" => "此账号未被注册",
            "108" => "您账号还未绑定,请先绑定您的号码",
            "109" => "系统繁忙,请稍后重试",
            "118" => "抱歉,此账号已注册,请重试",
            "119" => "此账号未被注册",
            "120" => "手机号码有误,请重试",
            "121" => "一天只有三次机会,请明天重试",
            "122" => "验证发送成功,请查询短信",
            "123" => "验证发送有误,请重试",
            "125" => "您账号认证失败",
            "126" => "找回密码成功,请查看找回密码短信",
            "127" => "短信发送失败,稍后请重试",
            "128" => "您账号未绑定手机号码或手机号码有误；请联系我们客服",
            "129" => "您账号信息未注册；请先注册",
            "130" => "密码修改成功",
            "131" => "密码修改失败",
            "132" => "账号注册成功",
            "133" => "账号注册失败",
            "135" => "您账号已被注册或请不要频繁注册,请稍后重试",
            "136" => "您账号已经认证成功",
            "137" => "原始密码与新密码不能相同,请重新输入",
            "138" => "感谢您的反馈,我们技术与客服会第一时间处理您的反馈",
            "139" => "对不起,不能使用中文作为账号",
            "140" => "对不起,您的账号必须大于6位或小于12位的长度",
            "151" => "抱歉,您的提交过于频繁,请稍后重试",
            "154" => "您的版本已是最新版本",
            "157" => "抱歉,您已反馈过了,我们会及时处理您反馈的问题",
            "159" => "您的帐号认证成功",
            "160" => "对不起,您的账号必须为您的手机号码",
            "161" => "设置添加成功，请继续完善其它资料",
            "162" => "该IMEI已经添加过了，请添加其它IMEI或被邀请加入",
            "163" => "生成邀请成功",
            "164" => "生成邀请失败",
            "165" => "注意！只有管理员才能操作此功能",
            "166" => "移交管理员成功",
            "167" => "移交管理员失败",
            "168" => "邀请码不存在，请确认是否输入正确",
            "169" => "关注成功",
            "170" => "关注失败",
            "171" => "取消关注成功",
            "172" => "取消关注失败",
            "173" => "注意！管理员不能取消关注",
            "174" => "修改信息成功",
            "175" => "上传图片信息有误，请重试",
            "176" => "上传图片成功",
            "177" => "切换设备信息成功",
            "178" => "切换设备信息失败",
            "901" => "无坐标信息",
        ),
        'en' => array(
            "101" => "auth error",
        ),
    );
    $language = CLIENT_LANGUAGE;
    return $statuscode[!empty($language) ? $language : 'cn'][$errorno];
}
