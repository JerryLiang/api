<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2014/11/6
 * Time: 18:54
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'helpers/cloudfiles_helper.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once INCLUDE_PATH . 'libraries/Redis.class.php';
include_once BASEPATH . 'model/user.php';

$input = new CI_Input();
$username = trim($input->get_post('user'));
$msg_num = trim($input->get_post('msgnum'));
$devicetoken = trim($input->get_post('devicetoken'));

//if(defined(CLIENT_PLATFORM)){
	if(CLIENT_PLATFORM == 'iphone') $table = 'T_ios_token';
	else $table = 'T_android_token';
//}
$auth = Auth::getInstance($dbconfig['mainuser']);

$user = new user_model();
if (!$auth->verify()) {
	$reVal['content'] = _display_error('101');
	$reVal['status'] = 101;
}else{
	if(!empty($username)){
		$data['username'] = $username;
		$data['token'] = $devicetoken;
		$data['created'] = date("Y-m-d H:i:s");
		$ret = $user->get_num($table,array('username'=>$username));
		if($ret){
			if(isset($msg_num)){
				$redis = new RedisInit();
				$redis->redis()->set('msg_num_'.$username,$msg_num,strtotime('+7 days'));
				$reVal['status'] = 0;
				$reVal['content'] = 'success';
//				echo json_encode($reVal);exit;
			}
			_logger(_LL_DEBUG, 'update,username:' . $username . ',data:'.print_r($data,true));
			$user->update_data($table,array('username'=>$username),$data);
		}
		else{
			_logger(_LL_DEBUG, 'insert,username:' . $username . ',data:'.print_r($data,true));
			$user->insert_data($table,$data);
		}

		$reVal['status'] = 0;
		$reVal['content'] = 'success';
	}
	else{
		$reVal['content'] = _display_error('102');
		$reVal['status'] = 102;
	}
}

echo json_encode($reVal);exit;