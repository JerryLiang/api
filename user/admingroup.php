<?php

/*
  首次添加设备成为管理员,移交管理员，加载列表
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
		case 'list': //成员列表
			$reVal['list'] = array();
			$query = $auth->_main_user_db->query("select member from `T_group_info` WHERE `imei`='" . $imei . "' limit 1");
			if ($query && $query->num_rows() > 0) {
				$member = unserialize($query->row()->member);
				foreach ($member as $key => $val) {
					$temp[$key] = $val;
					$ret = $auth->_main_user_db->query("select headimag from `T_user_info` WHERE `username`='" . $username . "' limit 1");
					$temp[$key]['headimag'] = $ret->row()->headimag;
				}
				$reVal['status'] = 0;
				$reVal['list'] = $temp;
			}
			unset($query);
			break;
		case 'move': //移交管理员
			$moveuser = trim($input->get_post('moveuser'));
			if (empty($moveuser)) {
				$reVal['content'] = _display_error('102');
				$reVal['status'] = 102;
			} else {
				$info = $user->check_record("select id from `T_group_info` WHERE `isadmin`='" . $username . "' and `imei` = ".$imei, 'val');
//				echo $info;exit;
				if ($info) {
					$auth->_main_user_db->set('isadmin', $moveuser);
					$auth->_main_user_db->where('id', $info);
					if ($auth->_main_user_db->update('T_group_info') && $auth->_main_user_db->affected_rows() > 0) {
						$reVal['content'] = _display_error('166');
						$reVal['status'] = 166;
					} else {
						$reVal['content'] = _display_error('167');
						$reVal['status'] = 167;
					}
				} else {
					$reVal['content'] = _display_error('165');
					$reVal['status'] = 165;
				}
				unset($info);
			}
			break;
		case 'adduser': //添加关注者
			$info = $user->check_record("select id from `T_group_info` WHERE `imei`='" . $imei . "'");
			if (!$info) {
				$data = array(
					'imei' => $imei,
					'isadmin' => $username,
					'member' => serialize(array(array('username' => $username, 'udid' => $udid)))
				);
				//添加设备列表
				$query = $auth->_main_user_db->query("select id from `T_user_imei` WHERE `username`='" . $username . "' and `imei`='" . $imei . "' limit 1");
				if ($query && $query->num_rows() <= 0) {
					$info = $auth->_main_user_db->query("select names,headimag from T_phone_info where imei='" . $imei . "'");
					if ($info->num_rows() > 0 || true) {
						$auth->_main_user_db->query("insert into T_user_imei(username,udid,imei,names,headimag)value('".$username ."','". $udid . "','" . $imei . "','" . $info->row()->names . "','" . $info->row()->headimag . "')");
						//更新用户信息
						$auth->_main_user_db->query("update T_user_info set imei='" . $imei . "' where username='" . $username . "'");
					}
					unset($info);
				}
				unset($query);
				if ($auth->_main_user_db->insert('T_group_info', $data) && $auth->_main_user_db->affected_rows() > 0) {
					$reVal['status'] = 0;
					$reVal['imei'] = $imei;
					$reVal['content'] = _display_error('161');
				}
			} else {
				$reVal['content'] = _display_error('162');
				$reVal['status'] = 162;
			}
			unset($info);
			break;
	}
}
echo json_encode($reVal);
?>