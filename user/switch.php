<<<<<<< HEAD
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
$mobile = trim($input->get_post('mobile'));
$udid = trim($input->get_post('udid'));
$action = trim($input->get_post('action'));

$auth = Auth::getInstance($dbconfig['mainuser']);
$img_url_prefix = $url_prefixs[array_rand($url_prefixs)];
$reVal = array('content' => '', 'status' => 103);
if (empty($username) ||  empty($action)) {
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
			$query = $auth->_main_user_db->query("select mobile,names,headimag from T_user_imei where username='" . $username . "'");
			if ($query && $query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					//返回老人机开机，关机时间
					$item = $user->get_item('T_phone_info',"mobile = '".$row['mobile']."'");
					$info = !empty($item['info']) ? unserialize($item['info']) : '';
					$temp_1[] = array('mobile' => !empty($row['mobile']) ? $row['mobile'] : '', 'names' => !empty($item['names']) ? $item['names'] : '', 'image' => !empty($item['headimag']) ? $img_url_prefix . $item['headimag'] : '','start'=>!empty($info['start']) ? $info['start'] : '','shutdown'=>!empty($info['shutdown']) ? $info['shutdown'] : '');
				}
			}
			unset($query);
			$reVal['status'] = 0;
			$reVal['list'] = $temp_1;
//			_logger(_LL_DEBUG, "\n reVal = ".print_r($reVal,true)."switch == list");
			break;
		case 'switch':
			//日志记录
			$info = $user->check_record("select id from `T_group_info` WHERE `mobile`='" . $mobile . "'");
			if ($info) {
				$auth->_main_user_db->query("update T_user_info set mobile='" . $mobile . "' where username='" . $username . "'");
				$reVal['status'] = 0;
				$reVal['mobile'] = $mobile;
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
=======
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
$mobile = trim($input->get_post('mobile'));
$udid = trim($input->get_post('udid'));
$action = trim($input->get_post('action'));

$auth = Auth::getInstance($dbconfig['mainuser']);
$img_url_prefix = $url_prefixs[array_rand($url_prefixs)];
$reVal = array('content' => '', 'status' => 103);
if (empty($username) ||  empty($action)) {
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
			$query = $auth->_main_user_db->query("select mobile,names,headimag from T_user_imei where username='" . $username . "'");
			if ($query && $query->num_rows() > 0) {
				foreach ($query->result_array() as $row) {
					//返回老人机开机，关机时间
					$item = $user->get_item('T_phone_info',"mobile = '".$row['mobile']."'");
					$info = !empty($item['info']) ? unserialize($item['info']) : '';
					$temp_1[] = array('mobile' => !empty($row['mobile']) ? $row['mobile'] : '', 'names' => !empty($item['names']) ? $item['names'] : '', 'image' => !empty($item['headimag']) ? $img_url_prefix . $item['headimag'] : '','start'=>!empty($info['start']) ? $info['start'] : '','shutdown'=>!empty($info['shutdown']) ? $info['shutdown'] : '');
				}
			}
			unset($query);
			$reVal['status'] = 0;
			$reVal['list'] = $temp_1;
//			_logger(_LL_DEBUG, "\n reVal = ".print_r($reVal,true)."switch == list");
			break;
		case 'switch':
			//日志记录
			$info = $user->check_record("select id from `T_group_info` WHERE `mobile`='" . $mobile . "'");
			if ($info) {
				$auth->_main_user_db->query("update T_user_info set mobile='" . $mobile . "' where username='" . $username . "'");
				$reVal['status'] = 0;
				$reVal['mobile'] = $mobile;
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
>>>>>>> 63b94a7e1b4167248a21999ae09c4dde81b786e9
