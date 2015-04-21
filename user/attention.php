<?php

/*
  邀请关注接口
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
$code = trim($input->get_post('code'));
$action = trim($input->get_post('action'));

$auth = Auth::getInstance($dbconfig['mainuser']);
$reVal = array('content' => '', 'status' => 103);
if (empty($username) || empty($imei) || empty($action)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (!$auth->verify()) {
	$reVal['content'] = _display_error('101');
	$reVal['status'] = 101;
} else {
	$user = new user_model();
	switch ($action) {
		case 'sendcode':
			//生成随机码
			$rand_code = generate_password();
			$data = array(
				'username' => $username,
				'imei' => $imei,
				'udid' => $udid,
				'code' => $rand_code
			);
			if ($auth->_main_user_db->insert('T_attention_info', $data) && $auth->_main_user_db->affected_rows() > 0) {
				$reVal['status'] = 0;
				$reVal['code'] = $rand_code;
				$reVal['content'] = _display_error('163');
			} else {
				$reVal['status'] = 164;
				$reVal['content'] = _display_error('164');
			}
			break;
		case 'adduser':
			//添加用户
			$info = $user->check_record("select id from `T_attention_info` WHERE `imei`='" . $imei . "' and `code`='" . $code . "' limit 1");
			if ($info) {
				//群中去重或加载
				$query = $auth->_main_user_db->query("select member from `T_group_info` WHERE `imei`='" . $imei . "' limit 1");
				if ($query && $query->num_rows() > 0) {
					$member = unserialize($query->row()->member);
					if (is_array($member)) {
						$member[] = array('username' => $username, 'udid' => $udid);
						$tmp_arr = array();
						foreach ($member as $k => $v) {
							if (in_array($v['username'], $tmp_arr)) {
								unset($member[$k]);
							} else {
								$tmp_arr[] = $v['username'];
							}
						}
						sort($member);
						//加入该用户老人机列表
						$ret = $auth->_main_user_db->query("select names,headimag from T_phone_info where imei='" . $imei . "'");
						$res = $auth->_main_user_db->query("select id from T_user_imei   where  `imei`='" . $imei . "' and `username` = '".$username."'");

						if ($ret->num_rows() > 0 && $res->num_rows() == 0) {
								$auth->_main_user_db->query("update T_group_info set member='" . serialize($member) . "' where  `imei`='" . $imei . "'");
								$status = $auth->_main_user_db->query("insert into T_user_imei(username,udid,imei,names,headimag)value('".$username ."','". $udid . "','" . $imei . "','" . $ret->row()->names . "','" . $ret->row()->headimag . "')");
								//更新用户信息
								$auth->_main_user_db->query("update T_user_info set imei='" . $imei . "' where username='" . $username . "'");
						}
						if(!empty($status)){
							$reVal['status'] = 0;
							$reVal['content'] = _display_error('169');
						}
						 else {
							$reVal['status'] = 170;
							$reVal['content'] = _display_error('170');
						}
						unset($ret);
					}
				}
				unset($query);
			} else {
				$reVal['status'] = 168;
				$reVal['content'] = _display_error('168');
			}
			unset($info);
			break;
		case 'canceluser':
			//非管理员取消关注用户
			$info = $user->check_record("select id from `T_group_info` WHERE `imei`='" . $imei . "' and `isadmin`='" . $username . "' limit 1");
			if (!$info) {
				//群中去重
				$query = $auth->_main_user_db->query("select member from `T_group_info` WHERE `imei`='" . $imei . "' limit 1");
				if ($query && $query->num_rows() > 0) {
					$member = unserialize($query->row()->member);
					//去除
					foreach ($member as $k => $v) {
						if ($v['username'] == $username) {
							unset($member[$k]);
						}
					}
					//
//					在该用户关注列表中取消
					$user->cancel_user('T_user_imei',$username,$imei);
					if (is_array($member)) {
						//插入
						$status = $auth->_main_user_db->query("update T_group_info set member='" . serialize($member) . "' where  `imei`='" . $imei . "'");
						if ($status && $auth->_main_user_db->affected_rows() > 0) {
							$reVal['status'] = 0;
							$reVal['content'] = _display_error('171');
						} else {
							$reVal['status'] = 172;
							$reVal['content'] = _display_error('172');
						}
					}
				}
				unset($query);
			} else {
				$reVal['status'] = 173;
				$reVal['content'] = _display_error('173');
			}
			unset($info);
			break;
	}
}
echo json_encode($reVal);

function generate_password($length = 8)
{
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$password = '';
	for ($i = 0; $i < $length; $i++) {
		$password .= $chars[mt_rand(0, strlen($chars) - 1)];
	}
	return $password;
}

?>