<?php

/**
 * 用户设备切换
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
$udid = trim($input->get_post('udid'));
$action = trim($input->get_post('action'));

$auth = Auth::getInstance($dbconfig['mainuser']);
$img_url_prefix = $url_prefixs[array_rand($url_prefixs)];
$reVal = array('content' => '', 'status' => 103);
if (empty($username) || empty($udid) || empty($action)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (!$auth->verify()) {
	$reVal['content'] = _display_error('101');
	$reVal['status'] = 101;
} else {
	$user = new user_model();
	switch ($action) {
		case 'list':
			$temp_1 = array();
			$query = $auth->_main_user_db->query("select imei,names,headimag from T_user_imei where username='" . $username . "'");
			if ($query && $query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					$temp_1[] = array('imei' => !empty($row['imei']) ? $row['imei'] : '', 'names' => !empty($row['names']) ? $row['names'] : '', 'image' => !empty($row['headimag']) ? $img_url_prefix . $row['headimag'] : '');
				}
			}
			unset($query);
			$reVal['status'] = 0;
			$reVal['list'] = $temp_1;
			break;
		case 'switch':
			//日志记录
			$info = $user->check_record("select id from `T_group_info` WHERE `imei`='" . $imei . "'");
			if ($info) {
				$reVal['status'] = 0;
				$reVal['imei'] = $imei;
				$reVal['content'] = _display_error('177');
			} else {
				$reVal['status'] = 178;
				$reVal['content'] = _display_error('178');
			}
			unset($info);
			break;
	}
}
echo json_encode($reVal);
