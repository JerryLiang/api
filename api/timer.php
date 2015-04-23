<?php
/**
 * Created by PhpStorm.
 * User: jerry
 * Date: 2015/4/7 0007
 * Time: 16:35
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

define('USER_PATH', realpath(BASEPATH . '../') . '/user/');
include_once BASEPATH . 'model/api.php';

$input = new CI_Input();
$_table = 'messages';

$mobile = $input->get_post('mobile');
$username = $input->get_post('user');
//$time = $input->get_post('time'); //09:30
//$day = $input->get_post('day');//星期，以,号分割：1,2,3,4,
//$rep = $input->get_post('rep');//是否重复
//$comment = $input->get_post('comment');//备注
//$audio = $input->get_post('audio');//语音留言地址

$reVal = array('content' => '', 'status' => 103);

if(empty($mobile) || empty($username)){
    $reVal['content'] = '参数错误';
    $reVal['status'] = '102';
}
else{
    $api = new api_model();
    $item = $api->get_im_info($_table,array('to'=>$mobile,'sender'=>$username,'msgtype'=>'alarm'));
    $reVal['status'] = '0';
    $reVal['content'] = $item;
}
echo json_encode($reVal);


