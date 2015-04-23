<?php

/*
  服务列表接口
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
<<<<<<< HEAD
include_once INCLUDE_PATH . 'config/common.config.php';
include_once BASEPATH . 'config/imserver.config.php';
include_once INCLUDE_PATH . 'libraries/Redis.class.php';
include_once INCLUDE_PATH . 'libraries/ImServerApi.class.php';

//$cache = new RedisInit();
$input = new CI_Input();
$format = trim($input->get_post('format'));
//$im = trim($input->get_post('im'));
$imserverapi = new ImServerApi();
//注意：redis中无服务器列表，就会报imserverapi   weight错误
$server = $imserverapi->get_server($sips_server_config);
//$k = $cache->redis()->get('192.168.137.131:20013');
//var_dump($k);exit;
//$reVal['servers'] = array(
//	array('type' => 'im', 'ip' => '115.29.210.243', 'port' => 12345),
//);
$reVal['servers'] = $server;
$reVal['status'] = 0;

if (!empty($format) && ($format == 'json' || $format == 'txt')) {
    switch ($format) {
        case 'json' :
            echo json_encode($reVal);
            break;
        case 'txt' :
//			print_r($reVal['servers']);exit;
			$list = '';
			$list .= 'type:im,ip:'.$reVal['servers']['ip'].',port:'.$reVal['servers']['port'].';';
			$c = strlen($list);
			header("Content-Length: ".$c);
			echo $list;
=======

$input = new CI_Input();
$format = trim($input->get_post('format'));
if (!empty($format) && ($format == 'json' || $format == 'txt')) {
    switch ($format) {
        case 'json' :
            $return = array(
                'type' => 'im',
                'ip' => '121.40.144.58',
                'port' => 6688
            );
            echo json_encode($return);
            break;
        case 'txt' :
            echo "type:im,ip:121.40.144.58,port:6688";
>>>>>>> b9a688ea130c7f77368aff79e27ba30aee5b24c7
            break;
    }
}
?>
