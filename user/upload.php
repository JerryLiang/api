<?php

/**
 * 头像上传
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once INCLUDE_PATH . 'helpers/cloudfiles_helper.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';
include_once BASEPATH . 'model/user.php';

$input = new CI_Input();
$username = trim($input->get_post('user'));
//$imei = trim($input->get_post('imei'));
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
	if (!empty($_FILES['pic']['name'])) {
		$data = uploadFile($_FILES['pic'], '/head');

		$photo_path = $data['path'];
		// 删除临时文件
		deleteFile($_FILES['pic']['tmp_name']);
		if (isset($data['error']) && $data['error'] === 0) {
			switch ($action) {
				case 'cdma': //老人机
					//管理员
					$info = $user->check_record("select id from `T_group_info` WHERE  `isadmin`='" . $username . "' limit 1");
					if ($info) {
						if (!empty($photo_path)) {
							$query = $auth->_main_user_db->query("update T_phone_info set headimag='" . $photo_path . "' where mobile='" . $mobile . "'");
							$auth->_main_user_db->query("update T_user_imei set headimag='" . $photo_path . "' where mobile='" . $mobile . "'");
						}
					} else {
						$reVal['status'] = 165;
						$reVal['content'] = _display_error('165');
					}
					unset($info);
					break;
				case 'machine': //智能机
					if (!empty($photo_path)) {
						$query = $user->update_userinfo('T_user_info','username',$username,array('headimag'=>$photo_path));
					}
					break;
			}
//			if ($query) {
				$reVal['status'] = 0;
				$reVal['content'] = _display_error('176');
				$reVal['data'] = array('headimag'=>$url_prefixs[array_rand($url_prefixs)].$photo_path);
//			}
			unset($query);
		}
	} else {
		$reVal['status'] = 175;
		$reVal['content'] = _display_error('175');
	}
}
echo json_encode($reVal);
