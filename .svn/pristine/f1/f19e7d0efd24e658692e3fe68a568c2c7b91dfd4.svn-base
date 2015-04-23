<?php

/*
  设置个人、老人机的信息
 */

define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once BASEPATH . 'model/user.php';

$input = new CI_Input();
$username = trim($input->get_post('user'));
$imei = trim($input->get_post('imei'));
$nickname = trim($input->get_post('nickname'));
$sex = trim($input->get_post('sex'));
$birthday = trim($input->get_post('birthday'));
$mobile = trim($input->get_post('mobile'));
$action = trim($input->get_post('action'));

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
if (empty($username) || empty($action)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (!$auth->verify()) {
	$reVal['content'] = _display_error('101');
	$reVal['status'] = 101;
} else {
	$user = new user_model();
	switch ($action) {
		case 'cdma': //管理员老人机
			//管理员
			if(empty($mobile)){
				$reVal['content'] = _display_error('102');
				$reVal['status'] = 102;
			}
			$info = $user->check_record("select id from `T_group_info` WHERE  `isadmin`='" . $username . "' limit 1");
			if ($info) {
				if (!empty($nickname)) {
//					$query = $auth->_main_user_db->query("update T_phone_info set names='" . $nickname . "' where imei='" . $imei . "'");
					$data['names'] = $nickname;
//					$auth->_main_user_db->query("update T_user_imei set names='" . $nickname . "' where mobile='" . $mobile . "'");
				}
				if (strlen($sex) > 0) {
					$data['sex'] = $sex;
//					$query = $auth->_main_user_db->query("update T_phone_info set sex='" . $sex . "' where imei='" . $imei . "'");
				}
				if (!empty($birthday)) {
					$data['birthday'] = $birthday;
//					$query = $auth->_main_user_db->query("update T_phone_info set birthday='" . $birthday . "' where imei='" . $imei . "'");
				}
//				if (!empty($mobile)) {
//					$data['mobile'] = $mobile;
//					$query = $auth->_main_user_db->query("update T_phone_info set mobile='" . $mobile . "' where imei='" . $imei . "'");
//				}
				$query = $user->update_userinfo('T_phone_info','mobile',$mobile,$data);
//				if ($query && $auth->_main_user_db->affected_rows() > 0) {
					$reVal['status'] = 0;
					$reVal['content'] = _display_error('174');
//				}
				unset($query);
			} else {
				$reVal['status'] = 165;
				$reVal['content'] = _display_error('165');
			}
			unset($info);
			break;
		case 'machine': //智能机
			if (!empty($nickname)) {
				$data['names'] = $nickname;
			}
			if (strlen($sex) > 0) {
				$data['sex'] = $sex;
			}
			if (!empty($birthday)) {
				$data['birthday'] = $birthday;
			}
			$data['username'] = $username;
			$query = $user->update_userinfo('T_user_info','username',$username,$data);
				$reVal['status'] = 0;
				$reVal['content'] = _display_error('174');
			unset($query);
			break;
	}
}
	echo json_encode($reVal);
?>