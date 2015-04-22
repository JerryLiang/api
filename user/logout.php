<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/12/25
 * Time: 18:04
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once INCLUDE_PATH . 'libraries/Redis.class.php';

$input = new CI_Input();
$username = trim($input->get_post('user'));
//$upass = trim($input->get_post('upass'));


$redis = new RedisInit();
//$msg_num = $redis->redis()->get('msg_num_'.$username);
$redis->redis()->del('login_status_'.$username);
$reVal = array('status'=>0,'content'=>'success');
echo json_encode($reVal);exit;




