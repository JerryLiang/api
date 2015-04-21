<?php

/*
  用户注册
 */
define("BASEPATH", dirname(__FILE__) . '/');
include_once BASEPATH . 'config/system.php';
include_once BASEPATH . 'config/conf.php';
include_once BASEPATH . 'config/database.php';
include_once BASEPATH . 'model/user.php';
include_once INCLUDE_PATH . 'libraries/Auth.class.php';

$input = new CI_Input();
$udid = trim($input->get_post('udid'));
$imei = trim($input->get_post('imei'));
$mac = trim($input->get_post('mac'));
$username = trim($input->get_post('user'));
$upass = trim($input->get_post('upass'));
$pwd = trim($input->get_post('pwd'));

$reVal = array('content' => '', 'status' => 103);
$user = new user_model();
$auth = Auth::getInstance($dbconfig['mainuser']);

if (empty($udid) || empty($username) || empty($pwd)) {
	$reVal['content'] = _display_error('102');
	$reVal['status'] = 102;
} elseif (preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $username, $matches)) {
	$reVal['content'] = _display_error('139');
	$reVal['status'] = 139;
} elseif (strlen($username) < 6 || strlen($username) > 24) {
	$reVal['content'] = _display_error('140');
	$reVal['status'] = 140;
} elseif ($pwd != md5($udid . $mac . $username . $upass . "#1QWE")) {
	$reVal['content'] = _display_error('1022');
	$reVal['status'] = 1022;
} elseif ($user->check_user($username)) {
	$reVal['content'] = _display_error('118');
	$reVal['status'] = 118;
} else {
	$version = CLIENT_VERSION;
	$platform = CLIENT_PLATFORM;
	$insertdata = array(
		'username' => $username,
		'userpass' => $auth->encrypt($upass), //可逆算法
		'platform' => $platform,
		'version' => $version,
		'udid' => $udid,
		'mac' => $mac,
		'ip' => $_SERVER['REMOTE_ADDR']
	);
	$useridtoken = $auth->register_login($insertdata);
	if (!empty($useridtoken) && is_array($useridtoken)) {
		$reVal['content'] = _display_error('132');
		$reVal['userid'] = $useridtoken['userid'];
		$reVal['token'] = $useridtoken['token'];
		$reVal['status'] = 0;
	} else {
		if (!empty($useridtoken) && $useridtoken == '202') {
			$reVal = array('status' => 135, 'content' => _display_error('135'), 'userid' => '', 'token' => '');
		} else {
			$reVal = array('status' => 133, 'content' => _display_error('133'), 'userid' => '', 'token' => '');
		}
	}
	unset($useridtoken);
}
echo json_encode($reVal);
?>