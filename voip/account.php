<?php
/**
 * Created by PhpStorm.
 * User: jerry
 * Date: 2015/3/19 0019
 * Time: 10:22
 */
define("BASEPATH", dirname(__FILE__) . '/');

include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'model/voip.php';
include_once INCLUDE_PATH . 'libraries/SmsGateway.class.php';
include_once INCLUDE_PATH . 'libraries/Redis.class.php';

$input = new CI_Input();
$caller = trim($input->get_post('caller'));

//charge_voip('008618665318667','10000001','12663056');
//exit;
//调用拨打电话接口
$ret = account($caller);
_logger(_LL_DEBUG,'account:'.$ret.',caller:'.$caller);
$ret = json_decode($ret,true);

if(CLIENT_PLATFORM == 'iphone' || CLIENT_PLATFORM == 'android'){
    $format = 'json';
}
else{
    header("Content-Type: text/html;charset=utf-8");
    header("Content-Length: 1");
    $format = 'txt';
}
sendput($ret['status'],$format);