<<<<<<< HEAD
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
$caller = $input->get_post('caller');
$called = $input->get_post('called');

//charge_voip('008618665318667','10000001','12663056');
//exit;
//调用拨打电话接口
$ret = voip($caller,$called);
_logger(_LL_DEBUG,'call_voip:'.$ret.',caller:'.$caller.',called:'.$called);
$ret = json_decode($ret,true);

if(CLIENT_PLATFORM == 'iphone' || CLIENT_PLATFORM == 'android'){
    $format = 'json';
}
else{
    $format = 'txt';
    $status = $ret['status'];
    $info = !empty($ret['info']) ? ','.$ret['info'] : '';
    $status = $status.$info;
    header("Content-Type: text/html;charset=utf-8");
    header("Content-Length: ".strlen($status));
}
sendput($status,$format);
=======
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
$caller = $input->get_post('caller');
$called = $input->get_post('called');

//charge_voip('008618665318667','10000001','12663056');
//exit;
//调用拨打电话接口
$ret = voip($caller,$called);
_logger(_LL_DEBUG,'call_voip:'.$ret.',caller:'.$caller.',called:'.$called);
$ret = json_decode($ret,true);

if(CLIENT_PLATFORM == 'iphone' || CLIENT_PLATFORM == 'android'){
    $format = 'json';
}
else{

    $format = 'txt';
    $status = $ret['status'];
    $info = !empty($ret['info']) ? ','.$ret['info'] : '';
    $status = $status.$info;
    header("Content-Type: text/html;charset=utf-8");
    header("Content-Length: ".strlen($status));
}
sendput($status,$format);
>>>>>>> 63b94a7e1b4167248a21999ae09c4dde81b786e9
