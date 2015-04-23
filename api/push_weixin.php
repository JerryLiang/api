<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/2/27
 * Time: 9:43
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
//include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once INCLUDE_PATH . 'libraries/Weixin.class.php';
include_once INCLUDE_PATH . 'libraries/Redis.class.php';

//define('USER_PATH', realpath(BASEPATH . '../') . '/user/');
include_once BASEPATH . 'model/api.php';

$input = new CI_Input();

$signature = $input->get('signature');
$timestamp = $input->get('timestamp');
$nonce = $input->get('nonce');
$echostr = $input->get('echostr');

$wechatObj = weixin_api::getInstance($dbconfig['mainuser']);
$wechatObj->valide();


